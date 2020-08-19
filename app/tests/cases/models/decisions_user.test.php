<?php 

App::import('Model', 'DecisionsUser');

class DecisionsUserTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new DecisionsUser();
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
