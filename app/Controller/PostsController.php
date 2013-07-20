<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form');
	public $uses = false;   

    public function index() {
       
		$this->set('posts', $_SERVER);
    }
	
	 public function view($id = null) {
          $this->set('post', array('a'=>$id ));
    }
}
?>
