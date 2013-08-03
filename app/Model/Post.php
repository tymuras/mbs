<?php
	
class Post extends AppModel {
     public $useDbConfig = 'faraway';
	
	public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => array('notEmpty', 'email')
        ),
		'categories' => array(
              'rule' => array('multiple', array('min' => 1)), 
			'allowEmpty' => false
        ),
    );
	
	private $_sorting = array(
		'mail'=> 'By email',
		'name'=> 'By email',
		'date'=> 'By Date'	
	);
	
	public function getSortingModes()
	{
		return $this->_sorting;
	}
	
	public function delete($id = NULL, $cascade = true )
	{
		parent::delete();
	}
	
	public function saveFileData( $data )
	{
		return file_put_contents($this->getFileName(), serialize($data));	
	}
	
	/*
	public function create() {        
		$aItem = array_combine ($fields, $values);
		$aItem['id'] = crc32(implode($values, ''));		
		$data = $this->getFileData();
		$data[] = array('Post'=> $aItem);
		return $this->saveFileData($data);
    }
	 * 
	 */
	
	
}
