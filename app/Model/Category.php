<?php

class Category extends AppModel {
     public $useTable = false; 
	 
	 public function getList()
	 {
		  $categories = array(
			array('id'  => 1, 'title' => 'Food'),
			array('id'  => 2, 'title' => 'Sport'),
			array('id'  => 2, 'title' => 'Flowers')			 
		 );
		  
		return $categories;  
	 }
}
?>
