<?php
class Membership extends AppModel {
    var $name = "Membership";
    var $belongsTo = array("User","Committee","Role");

    function saveCommittee($committee_id,$user_id,$defaultrole) {
        
        $ddat['committee_id']=$committee_id;
        $ddat['user_id']=$this->Auth->user('id');
        
        $defaultrole=$this->Role->findByName($defaultrole);
        if(!$defaultrole['Role']['id']) {  //what?? it's not set properly in mymeeting.php??? aaaah.. just get the first working id then
            $defaultrole=$this->Role->find('first',array('field'=>'id','order'=>'id'));
        }
        $ddat['role_id']=$defaultrole['Role']['id'];
        $this->create();
        $this->save($ddat);
    }
}
?>
