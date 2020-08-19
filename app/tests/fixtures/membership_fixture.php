<?php
class MembershipFixture extends CakeTestFixture {
    var $name = 'Membership';
    var $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'role_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );

    var $records = array(
        array('id'=>1,'user_id'=>1,'committee_id'=>1,'role_id'=>1),
        array('id'=>2,'user_id'=>2,'committee_id'=>1,'role_id'=>1),
        array('id'=>3,'user_id'=>3,'committee_id'=>1,'role_id'=>1),
        array('id'=>4,'user_id'=>4,'committee_id'=>1,'role_id'=>1),
        array('id'=>5,'user_id'=>5,'committee_id'=>1,'role_id'=>1),
        array('id'=>6,'user_id'=>6,'committee_id'=>2,'role_id'=>1),
    );
}
?>
