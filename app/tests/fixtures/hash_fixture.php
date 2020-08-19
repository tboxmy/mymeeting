<?php 
/* SVN FILE: $Id$ */
/* Hash Fixture generated on: 2008-12-23 15:12:33 : 1230018393*/

class HashFixture extends CakeTestFixture {
	var $name = 'Hash';
	var $table = 'hashes';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
			'url' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'hash_type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
			'hash' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'limit' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
			'due_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'limit_count' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
			);
	var $records = array(array(
			'id'  => 1,
			'user_id'  => 1,
			'url'  => 'Lorem ipsum dolor sit amet',
			'hash_type'  => 'Lorem ipsum dolor sit amet',
			'hash'  => 'Lorem ipsum dolor sit amet',
			'limit'  => 1,
			'due_date'  => '2008-12-23 15:46:33',
			'limit_count'  => 1,
			'created'  => '2008-12-23 15:46:33'
			));
}
?>