<?php

class PostsController extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
	public $uses  = array('MyModel', 'Post');

    public function test()
	{
	/*
	 * array (
  'Post' => 
  array (
    'id' => '3',
    'title' => 'Jonas Jonaitis 10',
    'categories' => '1,2,3,',
    'body' => 'jonas@greitai.ltsd',
    'created' => '2013-07-20 15:56:45',
    'modified' => '2013-07-20 16:42:48',
  ),
)
	 */	



	//echo $a = uniqid('as');
		//die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		

		/*
		echo "<h2>Create</h2>";
		// naujas
		$this->MyModel->id = null;
		$aRes = $this->MyModel->save(array(
			 'name' => 'zukja Persons'.rand(),
			 'mail' => 'tomas@greitai.lt',
			 'categories' => '1,2,3',
			 'atime' => '2012-05-02'
		));
		*/
		
		$id = '27c77acebb799dba663299a73c19eece';
		$post = $this->MyModel->findById($id);
		echo '<pre>';
		var_export( $post );
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
	
		$this->MyModel->id = 'a8d3e013f79912b6d51f69d7eb53d49c';
		$this->MyModel->save(array(
			'mail' => 'zurba',		
		));
		
	
		// trynimas
		$this->MyModel->delete("a8d3e013f79912b6d51f69d7eb53d49c");
		

		//die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		// visu gavimas
		$messages = $this->MyModel->find('all', array(
			'conditions' => array('name' => 'Some Person'),
		));		
		echo '<pre>';
		var_export( $messages );
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );

		
		// trynimas
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
		
		$subscribers = $this->Post->find('all');
		$subscribers = $this->Post->sort($subscribers, $sort_mode);
		
		$this->set('posts', $subscribers);
		$this->set('sorting', $this->Post->getSortingModes());
		$this->set('active_sorting_mode', $sort_mode);
		$categories = ClassRegistry::init('Category')->getList();		
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('System error'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('System error'));
        }
        $this->set('post', $post);
    }

    public function add() {
        
		$categories = ClassRegistry::init('Category')->getList('element_format');
		$this->set('categories',$categories );				
		
		if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash(__('The subscriber has been saved.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Unable to add the subscriber.'));
            }
        }
    }
	
	public function edit($id = null) {
		
		$categories = ClassRegistry::init('Category')->getList('element_format');
		$this->set('categories',$categories );				
		
		if (!$id) {
			throw new NotFoundException(__('System error'));
		}

		$post = $this->Post->findById($id);
		
		
		if (!$post) {
			throw new NotFoundException(__('System error'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Post->id = $id;
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The subscriber has been edited.'));
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
				
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->Post->delete($id)) {
			
			$this->Session->setFlash(__('The subscriber with id: %s has been deleted.', $id));
			$this->redirect(array('action' => 'index'));
		}else
		{
			die( 'deleting failed ' . __FILE__ . ' ' . __LINE__ ); 
		}
	}
}
?>
