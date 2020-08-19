<?php 

App::import('Model', 'MeetingsTodo');

class MeetingsTodoTestCase extends CakeTestCase {
	var $TestObject = null;

	function setUp() {
		$this->TestObject = new MeetingsTodo();
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
