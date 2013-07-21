<?php

class Category extends AppModel {
     public $useTable = false; 
	 
	 public function getList($sFormat = '')
	 {
		  $categories = array(
			array('id'  => 1, 'title' => 'Food'),
			array('id'  => 2, 'title' => 'Sport'),
			array('id'  => 3, 'title' => 'Flowers'),			 
			array('id'  => 4, 'title' => 'Pets')			 
		 );
		  
		
		  if($sFormat == 'element_format') {
			  foreach ( $categories as $val ) {
					$categoriesFormated[$val['id']] = $val['title'];			
				}
			return $categoriesFormated;					
		  }
		  
		return $categories;  
	 }
}
?>
