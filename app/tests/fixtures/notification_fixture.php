<?php
class NotificationFixture extends CakeTestFixture {
	var $name = 'Notification';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'message_title' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'notification_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'notification_sent' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'message' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'to' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
