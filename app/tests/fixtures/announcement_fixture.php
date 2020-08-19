<?php
class AnnouncementFixture extends CakeTestFixture {
	var $name = 'Announcement';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
