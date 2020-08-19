<?php
class GroupFixture extends CakeTestFixture {
	var $name = 'Group';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'committee_id'=>1,'name'=>'test group'),
		array('id'=>2,'committee_id'=>1,'name'=>'megaman'),
	);
}
?>
