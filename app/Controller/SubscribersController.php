<?php

class SubscribersController extends AppController {

	public $helpers = array( 'Html', 'Form', 'Session' );
	public $components = array( 'Session' );
	public $uses = array('Factory');

	public function test()
	{
		$this->autoRender = false;				
		App::uses('Factory', 'Model');		
		$oItem = Factory::getOrder(100);
		
		echo '<pre>';
		var_export($oItem );
		echo '</pre>';
		die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );
		
		/*
		echo '<pre>';
		var_export( $oItem);
		echo '</pre>';
		*/
		
	}
	
	
	public function index( $sort_mode = '' )
	{
		$categories = ClassRegistry::init( 'Category' )->getList( 'element_format' );
		$this->set( 'categories', $categories );

		$subscribers = $this->Subscriber->find( 'all' );
		$subscribers = $this->Subscriber->sort( $subscribers, $sort_mode );

		$this->set( 'posts', $subscribers );
		$this->set( 'sorting', $this->Subscriber->getSortingModes() );
		$this->set( 'active_sorting_mode', $sort_mode );
	}

	public function add()
	{

		$categories = ClassRegistry::init( 'Category' )->getList( 'element_format' );
		$this->set( 'categories', $categories );

		if ( $this->request->is( 'post' ) ) {

			$this->Subscriber->create();

			if ( $this->Subscriber->save( $this->request->data ) ) {
				$this->Session->setFlash( __( 'The subscriber has been saved.' ) );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( __( 'Fill all fields!' ) );
			}
		}
	}

	public function edit( $id = null )
	{

		$categories = ClassRegistry::init( 'Category' )->getList( 'element_format' );
		$this->set( 'categories', $categories );

		if ( !$id ) {
			throw new NotFoundException( __( 'System error' ) );
		}

		$subscriber = $this->Subscriber->findById( $id );

		if ( !$subscriber ) {
			throw new NotFoundException( __( 'System error' ) );
		}

		if ( $this->request->is( 'post' ) || $this->request->is( 'put' ) ) {
			$this->Subscriber->id = $id;
			if ( $this->Subscriber->save( $this->request->data ) ) {
				$this->Session->setFlash( __( 'The subscriber has been edited.' ) );
				$this->redirect( array( 'action' => 'index' ) );
			} else {
				$this->Session->setFlash( __( 'Fill all fields!' ) );
			}
		}

		if ( !$this->request->data ) {
			$this->request->data = $subscriber;
		}
	}

	public function delete( $id )
	{

		if ( $this->request->is( 'get' ) ) {
			throw new MethodNotAllowedException();
		}

		if ( $this->Subscriber->delete( $id ) ) {

			$this->Session->setFlash( __( 'The subscriber with id: %s has been deleted.', $id ) );
			$this->redirect( array( 'action' => 'index' ) );
		}
	}

}

?>
