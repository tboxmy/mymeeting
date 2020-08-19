<?php
class LogFixture extends CakeTestFixture {
    var $name = 'Log';
    var $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
        'targetid' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
        'controller' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'action' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50),
        'url' => array('type' => 'string', 'null' => false, 'default' => NULL),
        'timestamp' => array('type' => 'timestamp', 'null' => false),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
    );
}
?>
