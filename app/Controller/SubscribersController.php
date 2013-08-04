<?php

class SubscribersController  extends AppController {
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');
	public $uses  = array();
   
	
	public function test( )
	{
		$data['mail'] = 'tomas@greitai.lt';
		$data['name'] = 'zurba'.rand();
		$data['categories'] = array(1,2,3);
		$b = $this->Subscriber->save($data);
		echo '<pre>';
		var_export( $b );
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		
		
		$subscribers = $this->Subscriber->find('all');
		echo '<pre>';
		var_export( $subscribers);
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
	}
	
	
	public function index($sort_mode = '') {
		
		$categories = ClassRegistry::init('Category')->getList( 'element_format') ;
		$this->set('categories', $categories);		
		
		$subscribers = $this->Subscriber->find('all');
		$subscribers = $this->Subscriber->sort($subscribers, $sort_mode);
		
		$this->set('posts', $subscribers);
		$this->set('sorting', $this->Subscriber->getSortingModes());
		$this->set('active_sorting_mode', $sort_mode);
		$categories = ClassRegistry::init('Category')->getList();		
    }

    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('System error'));
        }

        $post = $this->Subscriber->findById($id);
        if (!$post) {
            throw new NotFoundException(__('System error'));
        }
        $this->set('post', $post);
    }

    public function add() {
        
		$categories = ClassRegistry::init('Category')->getList('element_format');
		$this->set('categories',$categories );				
		
		if ($this->request->is('post')) {
        
			$this->Subscriber->create();
			
            if ($this->Subscriber->save($this->request->data)) {
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

		$post = $this->Subscriber->findById($id);
		
		if (!$post) {
			throw new NotFoundException(__('System error'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Subscriber->id = $id;
			if ($this->Subscriber->save($this->request->data)) {
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

		if ($this->Subscriber->delete($id)) {
			
			$this->Session->setFlash(__('The subscriber with id: %s has been deleted.', $id));
			$this->redirect(array('action' => 'index'));
		}else
		{
			die( 'deleting failed ' . __FILE__ . ' ' . __LINE__ ); 
		}
	}
}
?>