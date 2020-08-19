<?php 

App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
    var $fixtures = array('app.log','app.user','app.title','app.meetings_todo','app.userstatus','app.decision','app.item','app.workflow','app.groupstatus','app.group','app.users_group','app.decisions_user','app.decisions_group','app.membership','app.role','app.attendance','app.announcement','app.committees_todo','app.notification','app.committee','app.meeting');

    function testgetUsersPerCommittee(){
        $this->User =& ClassRegistry::init('User');

        $result=$this->User->getUsersPerCommitteeList(1);
        $expected=array(
            '3' =>'abdullah',
            '5' => 'Ahmad',
            '1' => 'mamat',
            '2' => 'mamatian',
            '4' => 'Razak'
        );
        $this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');
    }
}
?>
