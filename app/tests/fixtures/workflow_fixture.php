<?php
class WorkflowFixture extends CakeTestFixture {
	var $name = 'Workflow';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'level' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'view' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'edit' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'delete' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'approve' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'disapprove' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
