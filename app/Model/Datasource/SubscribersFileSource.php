<?php
class SubscribersFileSource extends DataSource {

    private $_storage_file = 'plain_storage.txt';
	
	protected $_schema = array(
        'id' => array(
            'type' => 'string',
            'null' => false,
            'key' => 'primary',
            'length' => 255,
        ),
        'name' => array(
            'type' => 'string',
            'null' => true,
            'length' => 255,
        ),
        'mail' => array(
            'type' => 'text',
            'null' => true,
        ),
		
		'categories' => array(
            'type' => 'string',
            'null' => true,
            'length' => 32,
        ),
		
		'atime' => array(
            'type' => 'datetime',
            'null' => true,
        ),
		
    );

    public function __construct($config) {
        parent::__construct($config);     
    }
	
	public function getFileName()
	{
		return $this->_storage_file;
	}

    public function listSources($data = null) {
        return null;
    }

	public function describe($model) {
        return $this->_schema;
    }

    public function calculate(Model $model, $func, $params = array()) {
        return 'COUNT';
    }

    public function read(Model $model, $queryData = array(), $recursive = null) {
		if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
		return $this->getFileData();
	 }

	 public function create(Model $model, $fields = null, $values = null) {        
		$aItem = array_combine ($fields, $values);
		$data = $this->getFileData();
		
		if (!empty($aItem['id'])) {
			
			foreach ( $data as &$entry ) {
				
				if($entry['Post']['id'] ==  $aItem['id']) {
					$entry['Post'] = array_merge($entry['Post'], $aItem);
					break;
				}
			}
			
		} else {			
			$aItem['id'] = md5(json_encode($values));				
			$aItem['atime'] = date( 'Y-m-d H:i:s' );
			$data[] = array('Post'=> $aItem);			
		}
		
		return $this->saveFileData($data);
    }
	
	public function getFileData()
	{		
		$filename = $this->getFileName();
		if ( file_exists( $filename ) ) {
			$content = file_get_contents( $this->getFileName());						
			if (!empty($content)) {
				return unserialize($content);
			}	
		} 		
		return array();	
	}
	
	public function saveFileData( $data )
	{
		return file_put_contents($this->getFileName(), serialize($data));	
	}

    public function update(Model $model, $fields = null, $values = null, $conditions = null) {	
		
		$fields[] = 'id';
		$values[] = $model->id;
		return $this->create($model, $fields, $values);
    }

    public function delete(Model $model, $id = null) {		
		
		$data = $this->getFileData();
		foreach ( $data as $nr => $item ) {
			echo $item['Post']['id'].' -> '.var_export($id, true); echo '<hr>';
			
			if($item['Post']['id'] == $id[$model->alias.'.id']) {
				unset($data[$nr]);				
				break;
			}
		}
		return $this->saveFileData($data);
    }
	
	public function query($method, $data, $model )
	{
		switch ($method) {
			case 'findById':
				$id = reset($data);						
				if ($id) {
					$data = $this->getFileData();
					foreach ( $data as $entry ) {						
						if($entry['Post']['id'] ==  $id) {
							return $entry;
							break;
						}
					}
				}
			break;
		}
	}
}
?>