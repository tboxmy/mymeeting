<?php
class RoleFixture extends CakeTestFixture {
	var $name = 'Role';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
