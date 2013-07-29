<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
	public $uses  = array('MyModel', 'Post');

    public function test()
	{
		$aRes = $this->MyModel->save(array(
			 'name' => 'Some Persons'.rand(),
			 'mail' => 'tomas@greitai.lt',
			 'categories' => '1,2,3',
			 'atime' => '2012-05-02'
		));
		
		
$messages = $this->MyModel->find('all', array(
			'conditions' => array('name' => 'Some Person'),
		));		
echo '<pre>';
var_export( $messages );
echo '</pre>';

		
		
		$this->MyModel->delete(-1107738900);
		
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );	
		
	App::import('ConnectionManager');
	$abc = ConnectionManager::getDataSource('farAwaySource');
	$data1 = $abc->find('all');
	echo '<pre>';
	var_export( $data1);
	echo '</pre>';
	die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		
	$aRes = $this->MyModel->find('count');
	echo '<pre>';
	var_export( $aRes);
	echo '</pre>';
	die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );


// Get all messages from 'Some Person'
		$messages = $this->MyModel->find('all', array(
			'conditions' => array('name' => 'Some Person'),
		));
		
echo '<pre>';
var_export( $messages );
echo '</pre>';
echo '<hr>';
	
		
		
		$aRes = $this->MyModel->save(array(
			 'name' => 'Some Persons'.rand(),
			 'mail' => 'tomas@greitai.lt',
			 'categories' => '1,2,3',
			 'atime' => '2012-05-02'
		));
		
		
		
		
echo '<pre>';
var_export( $aRes );
echo '</pre>';
die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		echo '<pre>';
		var_export( $messages);
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		
		$categories = ClassRegistry::init('Category')->getList();
		
		/*
		//$aCategories = Configure::read('DATABASE_CONFIG');
		
		print_r(Configure::read('aaa'));
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		echo '<pre>';
		var_export( $aCategories );
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		 * $this->set('categories', ClassRegistry::init('Category')->getList());		
		 */
		
	}
	
	public function index($sort_mode = '') {
		
		$categories = ClassRegistry::init('Category')->getList( 'element_format') ;
		$this->set('categories', $categories);		
		$this->set('posts', $this->Post->find('all'));
		$this->set('sorting', $this->Post->getSortingModes());
		$this->set('active_sorting_mode', $sort_mode);
		$categories = ClassRegistry::init('Category')->getList();		
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Sistemine klaida'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Sistemine klaida'));
        }
        $this->set('post', $post);
    }

    public function add() {
        
		$categories = ClassRegistry::init('Category')->getList('element_format');
		$this->set('categories',$categories );				
		
		if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('Your post has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Unable to add your post.'));
            }
        }
    }
	
	public function edit($id = null) {
		
		$categories = ClassRegistry::init('Category')->getList('element_format');
		$this->set('categories',$categories );				
		
		if (!$id) {
			throw new NotFoundException(__('Sistemine klaida'));
		}

		$post = $this->Post->findById($id);
		if (!$post) {
			throw new NotFoundException(__('Sistemine klaida'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('Duomenys atnaujinti.'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Fill all fields!'));
			}
		}

		if (!$this->request->data) {
			$this->request->data = $post;
		}
	}
	public function delete($id) {
		
		$categories = ClassRegistry::init('FarAwaySource');
		$x = new FarAwaySource();
		
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->Post->delete($id)) {
			
			$this->Session->setFlash(__('The post with id: %s has been deleted.', $id));
			$this->redirect(array('action' => 'index'));
		}else
		{
			die( 'deleting failed ' . __FILE__ . ' ' . __LINE__ ); 
		}
	}
}
?>
