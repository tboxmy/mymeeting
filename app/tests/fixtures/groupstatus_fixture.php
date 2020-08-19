<?php
class GroupstatusFixture extends CakeTestFixture {
	var $name = 'Groupstatus';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
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
		array('id'=>1,'committee_id'=>1,'decision_id'=>5,'group_id'=>1,'description'=>'group updated on time','action_date'=>'2008-11-15'),
		array('id'=>2,'committee_id'=>1,'decision_id'=>6,'group_id'=>1,'description'=>'group updated late','action_date'=>'2008-11-15'),
		array('id'=>3,'committee_id'=>1,'decision_id'=>7,'group_id'=>1,'description'=>'group updated late','action_date'=>'2008-11-15'),
		);
}
?>
