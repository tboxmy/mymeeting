<?php 

App::import('Model', 'DecisionsGroup');

class DecisionsGroupTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new DecisionsGroup();
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
