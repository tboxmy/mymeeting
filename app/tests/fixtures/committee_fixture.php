<?php
class CommitteeFixture extends CakeTestFixture {
	var $name = 'Committee';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'short_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'meeting_num_template' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'name'=>'OSCC','short_name'=>'OSCC','meeting_num_template'=>'%xxxx/%yyyy')
	);
}
?>
