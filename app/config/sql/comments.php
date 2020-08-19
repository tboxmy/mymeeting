<?php
class CommentsSchema extends CakeSchema {
	var $name = 'Comments';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $comments = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'extra' => 'auto_increment'),
		'model' => array('type'=>'string', 'null' => false, 'length' => 20),
		'foreign_key' => array('type'=>'integer', 'null' => false, 'key' => 'index'),
		'description' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'key' => 'index'),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>
