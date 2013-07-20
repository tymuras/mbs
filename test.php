<?php


class Post{
	
	private $_sort_types = array('name', 'mail', 'date');
	
	public function getPostList($sort_type = null)
	{
		$postList = array(
			array('id'  => 1, 'name' => 'Aood', 'mail' => 'zok@mail.lt','date' => '2012-01-03 19:12:12'),
			array('id'  => 2, 'name' => 'Cport', 'mail' => 'bulba@sdsd.lt', 'date' => '2010-01-03'),
			array('id'  => 2, 'name' => 'Blowers', 'mail' => 'zurga@sadsds.lt', 'date' => '2005-02-03 10-10-10')			 
		 );
		 if (!is_null($sort_type) && in_array( $sort_type, $this->_sort_types )) {
			 usort($postList, array($this, "cmpBy".ucfirst($sort_type)));
		 }
		return $postList;
	}
	
	public function main()
	{
		$postList = $this->getPostList('name');
		usort($postList, array($this, "cmpByDate"));
		echo '<pre>';
		var_export( $postList);
		echo '</pre>';
	}
	
	function cmpByName($a, $b)
	{
		if ($a['name'][0] == $b['name'][0]) {
			return 0;
		}
		return ($a['name'][0] < $b['name'][0]) ? -1 : 1;
	}

	function cmpByMail($a, $b)
	{
		if ($a['mail'][0] == $b['mail'][0]) {
			return 0;
		}
		return ($a['mail'][0] < $b['mail'][0]) ? -1 : 1;
	}

	function cmpByDate($a, $b)
	{
		if ($a['date'][0] == $b['date'][0]) {
			return 0;
		}
		return ($a['date'][0] < $b['date'][0]) ? -1 : 1;
	}	
}



$post = new Post();

$post->main();

die( 'Stoped ' . __FILE__ . ' ' . __LINE__ );


?>
