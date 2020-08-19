<?php
class AttendanceFixture extends CakeTestFixture {
	var $name = 'Attendance';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'will_attend' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'attended' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'representative' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
			'excuse' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
			'created' => array('type' => 'date', 'null' => true, 'default' => NULL),
			'updated' => array('type' => 'date', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
