<?php

class Subscriber  extends AppModel {

	public $useDbConfig = 'SubscribersFileSource';
	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty'
		),
		'mail' => array(
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
		$a_letter = strtolower( $a[$this->alias]['name'][0] );
		$b_letter = strtolower( $b[$this->alias]['name'][0] );
		if ( $a_letter == $b_letter ) {
			return 0;
		}
		return ($a_letter < $b_letter) ? -1 : 1;
	}

	function cmpByMail( $a, $b )
	{
		$a_letter = strtolower( $a[$this->alias]['mail'][0] );
		$b_letter = strtolower( $b[$this->alias]['mail'][0] );
		if ( $a_letter == $b_letter ) {
			return 0;
		}
		return ($a_letter < $b_letter) ? -1 : 1;
	}

	function cmpByDate( $a, $b )
	{
		if ( $a[$this->alias]['atime'] == $b[$this->alias]['atime'] ) {
			return 0;
		}
		return ($a[$this->alias]['atime'] < $b[$this->alias]['atime']) ? -1 : 1;
	}
}
