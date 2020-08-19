<?php 

App::import('Model', 'CommitteesTodo');

class CommitteesTodoTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new CommitteesTodo();
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
