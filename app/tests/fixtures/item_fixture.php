<?php
class ItemFixture extends CakeTestFixture {
	var $name = 'Item';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'short_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'committee_id'=>1,'name'=>'MyMeeting','short_name'=>'mymeeting'),
		array('id'=>2,'committee_id'=>1,'name'=>'Train Wreck','short_name'=>'train'),
		array('id'=>3,'committee_id'=>1,'name'=>'House MD','short_name'=>'House'),
		array('id'=>4,'committee_id'=>1,'name'=>'MyMeeting MAMPU','short_name'=>'MAMPUmymeeting'),
	);
}
?>
