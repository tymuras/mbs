<?php
	
class Post extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
	
	public function getCategories()
	{
		echo '<pre>';
		var_export( 1);
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
	}
}
