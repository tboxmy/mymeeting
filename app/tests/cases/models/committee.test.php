<?php 

App::import('Model', 'Committee');

class CommitteeTestCase extends CakeTestCase {
	var $fixtures = array('app.log','app.user','app.title','app.meetings_todo','app.userstatus','app.decision','app.item','app.workflow','app.groupstatus','app.group','app.users_group','app.decisions_user','app.decisions_group','app.membership','app.role','app.attendance','app.announcement','app.committees_todo','app.notification','app.committee','app.meeting');

	function testupdatedDecision(){
        $this->Committee =& ClassRegistry::init('Committee');
		$result = $this->Committee->updatedDecision(1,1);
		$expected = array('1','2','5','6','7');
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

        $result=$usergroups=$this->Committee->userGroups(1,1);
		$expected=array(1);
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

		$result = $this->Committee->notUpdatedDecision(1,1);
		$result = Set::extract($result,'{n}.Decision.id');
		$expected = array('3');
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

		$result = $this->Committee->notUpdatedDecision(1,2);
		$result = Set::extract($result,'{n}.Decision.id');
		$expected = array('1','9');
        $this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

		$result = $this->Committee->userDecision(1,2);
		$expected = array('1','9');
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

		$result = $this->Committee->userDecision(1,1);
		$expected = array('1','2','3','4','5','6','7','8');
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');
	}

}
?>
