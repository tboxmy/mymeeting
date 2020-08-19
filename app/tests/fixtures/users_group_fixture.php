<?php
class UsersGroupFixture extends CakeTestFixture {
	var $name = 'UsersGroup';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'user_id'=>1,'group_id'=>1),
	);
}
?>
