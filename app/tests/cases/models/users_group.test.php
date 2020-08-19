<?php 

App::import('Model', 'UsersGroup');

class UsersGroupTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new UsersGroup();
	}

	function tearDown() {
		unset($this->TestObject);
	}

	/*
	function testMe() {
		$result = $this->TestObject->findAll();
		$expected = 1;
		$this->assertEqual($result, $expected);
	}
	*/
}
?>
