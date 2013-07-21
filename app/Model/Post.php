<?php
	
class Post extends AppModel {
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
}
