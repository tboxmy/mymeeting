<?php
class LoginWebTestCase extends CakeWebTestCase {

    function testAll(){
        $this->baseurl = 'http://localhost/mymeeting';
        $this->get($this->baseurl);
        $this->setField('data[User][username]','admin');
        $this->setField('data[User][password]','123456');

        $this->clickSubmit('Login');
        $this->assertNoText('testing');

        $this->get('http://localhost/mymeeting/committees/add');
        $this->assertText('Add Committee');
        $this->setField('data[Committee][name]','My Testing Committee');
        $this->setField('data[Committee][short_name]','testing');
        $this->setField('data[Committee][meeting_num_template]','%xxxx/%yyyy');
        $this->setField('data[Committee][meeting_title_template]','Mesyuaratsaya');
        $this->clickSubmit('Submit');
        $this->assertText('Address Book');
        $this->get('http://localhost/mymeeting/');
        $this->assertText('testing');
    }
}
?>

