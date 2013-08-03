<?php
App::uses('HttpSocket', 'Network/Http');

class FarAwaySource extends DataSource {

/**
 * An optional description of your datasource
 */
    public $description = 'A far away datasource';

/**
 * Our default config options. These options will be customized in our
 * ``app/Config/database.php`` and will be merged in the ``__construct()``.
 */
    public $config = array(
        'apiKey' => '',
    );

/**
 * If we want to create() or update() we need to specify the fields
 * available. We use the same array keys as we do with CakeSchema, eg.
 * fixtures and schema migrations.
 */
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

/**
 * Create our HttpSocket and handle any config tweaks.
 */
    public function __construct($config) {
        parent::__construct($config);
        $this->Http = new HttpSocket();
    }
	
	public function getFileName()
	{
		return 'plain_storage.txt';
	}

/**
 * Since datasources normally connect to a database there are a few things
 * we must change to get them to work without a database.
 */

/**
 * listSources() is for caching. You'll likely want to implement caching in
 * your own way with a custom datasource. So just ``return null``.
 */
    public function listSources($data = null) {
        return null;
    }

/**
 * describe() tells the model your schema for ``Model::save()``.
 *
 * You may want a different schema for each model but still use a single
 * datasource. If this is your case then set a ``schema`` property on your
 * models and simply return ``$model->schema`` here instead.
 */
    public function describe($model) {
        return $this->_schema;
    }

/**
 * calculate() is for determining how we will count the records and is
 * required to get ``update()`` and ``delete()`` to work.
 *
 * We don't count the records here but return a string to be passed to
 * ``read()`` which will do the actual counting. The easiest way is to just
 * return the string 'COUNT' and check for it in ``read()`` where
 * ``$data['fields'] === 'COUNT'``.
 */
    public function calculate(Model $model, $func, $params = array()) {
        return 'COUNT';
    }

/**
 * Implement the R in CRUD. Calls to ``Model::find()`` arrive here.
 */
    public function read(Model $model, $queryData = array(), $recursive = null) {
        
		
		if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
		
		
		return $this->getFileData();
		/*
		//return array($model->alias => $aFileData);
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
		
		
        /**
         * Now we get, decode and return the remote data.
         */
        $queryData['conditions']['apiKey'] = $this->config['apiKey'];
        $json = $this->Http->get('http://example.com/api/list.json', $queryData['conditions']);
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return array($model->alias => $res);
    }

/**
 * Implement the C in CRUD. Calls to ``Model::save()`` without $model->id
 * set arrive here.
 */
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

/**
 * Implement the U in CRUD. Calls to ``Model::save()`` with $Model->id
 * set arrive here. Depending on the remote source you can just call
 * ``$this->create()``.
 */
    public function update(Model $model, $fields = null, $values = null, $conditions = null) {	
		
		$fields[] = 'id';
		$values[] = $model->id;
		return $this->create($model, $fields, $values);
    }

/**
 * Implement the D in CRUD. Calls to ``Model::delete()`` arrive here.
 */
    public function delete(Model $model, $id = null) {
		
		
		$data = $this->getFileData();
		foreach ( $data as $nr => $item ) {
			echo $item['Post']['id'].' -> '.var_export($id, true); echo '<hr>';
			
			if($item['Post']['id'] == $id[$model->alias.'.id']) {
				unset($data[$nr]);				
				break;
			}
		}
		echo '***************** TRYNIMAS VEIKIA*******************';
		return $this->saveFileData($data);
		
		
		die( '**********delete veikia **************' . __FILE__ . ' ' . __LINE__ );
		
		$json = $this->Http->get('http://example.com/api/remove.json', array(
            'id' => $id[$model->alias . '.id'],
            'apiKey' => $this->config['apiKey'],
        ));
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return true;
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
