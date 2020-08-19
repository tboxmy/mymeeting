<?php
class DecisionsGroupFixture extends CakeTestFixture {
	var $name = 'DecisionsGroup';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'decision_id'=>5,'group_id'=>1),
		array('id'=>2,'decision_id'=>6,'group_id'=>1),
		array('id'=>3,'decision_id'=>7,'group_id'=>1),
		array('id'=>4,'decision_id'=>8,'group_id'=>1),
	);
}
?>
