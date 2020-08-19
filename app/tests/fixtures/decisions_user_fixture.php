<?php
class DecisionsUserFixture extends CakeTestFixture {
	var $name = 'DecisionsUser';
	var $fields = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'decision_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'decision_id'=>1,'user_id'=>1),
		array('id'=>2,'decision_id'=>2,'user_id'=>1),
		array('id'=>3,'decision_id'=>3,'user_id'=>1),
		array('id'=>4,'decision_id'=>4,'user_id'=>1),
		array('id'=>5,'decision_id'=>1,'user_id'=>2),
		array('id'=>6,'decision_id'=>9,'user_id'=>2),
	);
}
?>
