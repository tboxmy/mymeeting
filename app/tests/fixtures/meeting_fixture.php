<?php
class MeetingFixture extends CakeTestFixture {
	var $name = 'Meeting';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'meeting_num' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'meeting_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 1000),
		'meeting_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'meeting_end_estimate' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'meeting_end' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'allow_representative' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'venue' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'agenda' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'minutes' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'invite_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'minutes_raw' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'committee_id'=>1,'meeting_num'=>'1/2008'),
	);
}
?>
