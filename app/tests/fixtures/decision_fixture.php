<?php
class DecisionFixture extends CakeTestFixture {
	var $name = 'Decision';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'committee_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'meeting_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'item_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'minute_reference' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'description' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'ordering' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'deadline' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision done on time','deadline'=>'2018-12-15','deleted'=>0,'ordering'=>1),
		array('id'=>2,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision done late','deadline'=>'2008-10-15','deleted'=>0,'ordering'=>2),
		array('id'=>3,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision not done on time','deadline'=>'2018-12-15','deleted'=>0,'ordering'=>3),
		array('id'=>4,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision not done late','deadline'=>'2008-10-15','deleted'=>0,'ordering'=>4),
		array('id'=>5,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision done on time','deadline'=>'2008-12-15','deleted'=>0,'ordering'=>5),
		array('id'=>6,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision done late','deadline'=>'2008-10-15','deleted'=>0,'ordering'=>6),
		array('id'=>7,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision not done on time','deadline'=>'2008-12-15','deleted'=>0,'ordering'=>7),
		array('id'=>8,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision not done late','deadline'=>'2008-10-15','deleted'=>0,'ordering'=>8),
		array('id'=>9,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision done on time','deadline'=>'2018-12-15','deleted'=>0,'ordering'=>9),
		array('id'=>10,'committee_id'=>2,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision done on time','deadline'=>'2008-12-15','deleted'=>0,'ordering'=>10),
		array('id'=>11,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'grp Testing decision done on time','deadline'=>'2008-12-15','deleted'=>0,'ordering'=>11),
		array('id'=>12,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision done on time','deadline'=>'2008-12-15','deleted'=>0,'ordering'=>12),
		array('id'=>13,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision done late','deadline'=>'2008-10-15','deleted'=>0,'ordering'=>13),
		array('id'=>14,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'description'=>'ind Testing decision not done on time','deadline'=>'2008-12-15','deleted'=>1,'ordering'=>14),
	);
}
?>
