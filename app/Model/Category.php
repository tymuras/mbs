<?php

class Category extends AppModel {
     public $useTable = false; 
	 
	 public function getList()
	 {
		  $categories = array(
			array('id'  => 1, 'title' => 'Food'),
			array('id'  => 2, 'title' => 'Sport'),
			array('id'  => 3, 'title' => 'Flowers'),			 
			array('id'  => 4, 'title' => 'Pets')			 
		 );
		  
		return $categories;  
	 }
}
?>
