<?php 

App::import('Model', 'Todo');

class TodoTestCase extends CakeTestCase {
	var $fixtures = array('app.todo');

    function testRead() {
        $this->Todo =& ClassRegistry::init('Todo');

        $this->loadFixtures('Todo');
        $result=$this->Todo->find();
        $expected='siapkan projektor';
        $this->assertEqual($result['Todo']['name'],$expected,'Hello:'.print_r($result,true).'(%s)');
    }
}
?>
