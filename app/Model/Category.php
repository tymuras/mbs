<?php

class Category extends AppModel {
     public $useTable = false; 
	 
	 public function getList($sFormat = '')
	 {
		  Configure::load('categories', 'default');
		  $categories = Configure::read('categories');
		  
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
