<?php 
/* SVN FILE: $Id$ */
/* Hash Test cases generated on: 2008-12-23 15:12:33 : 1230018393*/
App::import('Model', 'Hash');

class HashTestCase extends CakeTestCase {
	var $Hash = null;
	var $fixtures = array('app.hash', 'app.user');

	function start() {
		parent::start();
		$this->Hash =& ClassRegistry::init('Hash');
	}

	function testHashInstance() {
		$this->assertTrue(is_a($this->Hash, 'Hash'));
	}

	function testHashFind() {
		$this->Hash->recursive = -1;
		$results = $this->Hash->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Hash' => array(
			'id'  => 1,
			'user_id'  => 1,
			'url'  => 'Lorem ipsum dolor sit amet',
			'hash_type'  => 'Lorem ipsum dolor sit amet',
			'hash'  => 'Lorem ipsum dolor sit amet',
			'limit'  => 1,
			'due_date'  => '2008-12-23 15:46:33',
			'limit_count'  => 1,
			'created'  => '2008-12-23 15:46:33'
			));
		$this->assertEqual($results, $expected);
	}
}
?>