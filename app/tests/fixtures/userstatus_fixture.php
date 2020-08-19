<?php
class UserstatusFixture extends CakeTestFixture {
	var $name = 'Userstatus';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'updater' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'action_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'closed' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'date_closed' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'committee_id'=>1,'decision_id'=>1,'user_id'=>1,'updater'=>1,'description'=>'done on time','action_date'=>'2008-11-30','updated'=>'2008-11-30 10:10:10'),
		array('id'=>2,'committee_id'=>1,'decision_id'=>2,'user_id'=>1,'updater'=>1,'description'=>'done late','action_date'=>'2008-11-30','updated'=>'2008-11-30 11:11:11'),
		array('id'=>3,'committee_id'=>1,'decision_id'=>1,'user_id'=>1,'updater'=>1,'description'=>'done on time second','action_date'=>'2008-11-30','updated'=>'2008-11-30 13:10:10'),
		array('id'=>4,'committee_id'=>1,'decision_id'=>1,'user_id'=>2,'updater'=>1,'description'=>'done on time second other guy','action_date'=>'2008-11-30','updated'=>'2008-11-30 14:10:10'),
	);
}
?>
