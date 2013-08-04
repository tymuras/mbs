<?php

class Post extends AppModel {

	public $useDbConfig = 'faraway';
	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty'
		),
		'body' => array(
			'rule' => array( 'notEmpty', 'email' )
		),
		'categories' => array(
			'rule' => array( 'multiple', array( 'min' => 1 ) ),
			'allowEmpty' => false
		),
	);
	private $_sort_types = array(
		'mail' => 'By email',
		'name' => 'By name',
		'date' => 'By date'
	);

	public function getSortingModes()
	{
		return $this->_sort_types;
	}

	public function sort( $items, $sort_type = null )
	{		
		if ( !is_null( $sort_type ) && in_array( $sort_type, array_keys( $this->_sort_types ) ) ) {
			usort( $items, array( $this, "cmpBy" . ucfirst( $sort_type ) ) );
		}
		return $items;
	}

	function cmpByName( $a, $b )
	{
		$a_letter = strtolower( $a['Post']['name'][0] );
		$b_letter = strtolower( $b['Post']['name'][0] );
		if ( $a_letter == $b_letter ) {
			return 0;
		}
		return ($a_letter < $b_letter) ? -1 : 1;
	}

	function cmpByMail( $a, $b )
	{
		$a_letter = strtolower( $a['Post']['mail'][0] );
		$b_letter = strtolower( $b['Post']['mail'][0] );
		if ( $a_letter == $b_letter ) {
			return 0;
		}
		return ($a_letter < $b_letter) ? -1 : 1;
	}

	function cmpByDate( $a, $b )
	{
		if ( $a['Post']['atime'] == $b['Post']['atime'] ) {
			return 0;
		}
		return ($a['Post']['atime'] < $b['Post']['atime']) ? -1 : 1;
	}
}
