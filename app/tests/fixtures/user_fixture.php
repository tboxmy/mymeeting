<?php
class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'password' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'superuser' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'protocol' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'job_title' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 80),
		'email' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'telephone' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'fax' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'address' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'title_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array('id'=>1,'username'=>'mamat','name'=>'mamat','protocol'=>1),
		array('id'=>2,'username'=>'mamatian','name'=>'mamatian','protocol'=>2),
		array('id'=>3,'username'=>'abdullah','name'=>'abdullah','protocol'=>2),
		array('id'=>4,'username'=>'razak','name'=>'Razak','protocol'=>2),
		array('id'=>5,'username'=>'ahmad','name'=>'Ahmad','protocol'=>2),
		array('id'=>6,'username'=>'doraemon','name'=>'Doraemon','protocol'=>2),
	);
}
?>
