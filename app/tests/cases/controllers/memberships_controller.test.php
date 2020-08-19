<?php 
/* SVN FILE: $Id$ */
/* MembershipsController Test cases generated on: 2008-11-28 21:11:02 : 1227877682*/
App::import('Controller', 'Memberships');

class TestMemberships extends MembershipsController {
	var $autoRender = false;
}

class MembershipsControllerTest extends CakeTestCase {
	var $Memberships = null;

	function setUp() {
		$this->Memberships = new TestMemberships();
		$this->Memberships->constructClasses();
	}

	function testMembershipsControllerInstance() {
		$this->assertTrue(is_a($this->Memberships, 'MembershipsController'));
	}

	function tearDown() {
		unset($this->Memberships);
	}
}
?>