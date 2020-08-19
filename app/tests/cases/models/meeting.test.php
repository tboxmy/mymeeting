<?php 

App::import('Model', 'Meeting');

class MeetingTestCase extends CakeTestCase {
	var $fixtures = array('app.log','app.user','app.title','app.meetingtodo','app.userstatus','app.decision','app.item','app.workflow','app.groupstatus','app.group','app.users_group','app.decisions_user','app.decisions_group','app.membership','app.role','app.attendance','app.announcement','app.committeetodo','app.notification','app.committee','app.meeting');

	function testnextnumber(){
		$this->Meeting =& ClassRegistry::init('Meeting');

		$template=$result=$this->Meeting->Committee->field('meeting_num_template',array('id'=>1));
		$expected = '%xxxx/%yyyy';
		$this->assertEqual($result,$expected);

		$fnum=$this->Meeting->templatefield('x',$template);
		$fyear=$this->Meeting->templatefield('y',$template);
		$fmonth=$this->Meeting->templatefield('m',$template);

		$result=$fnum['field'];
		$expected = 'xxxx';
		$this->assertEqual($result,$expected);

		$template=$result=$this->Meeting->replacetemplatedate($template,$fyear,$fmonth);
		$expected = '%xxxx/2008';
		$this->assertEqual($result,$expected);

		$btemplate=$result=str_replace('%'.$fnum['field'],'%',$template);
		$expected = '%/2008';
		$this->assertEqual($result,$expected);

		$result=$this->Meeting->query('SELECT Meeting.meeting_num from '.$this->db->fullTableName('meetings').' as Meeting where Meeting.committee_id=1 and Meeting.meeting_num like \''.$btemplate.'\' order by Meeting.meeting_num asc limit 1');
		$expected = array(0=>array('Meeting'=>array('meeting_num'=>'1/2008')));
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'--%s');

		$result = $this->Meeting->nextnumber(1);
		$expected = '2/2008';
		$this->assertEqual($result,$expected);
	}

	function testsaving(){
		$this->Meeting =& ClassRegistry::init('Meeting');

		$data['Meeting']['committee_id']=1;
		$data['Meeting']['meeting_num']='test/1/2008';
		$data['Meeting']['meeting_title']='Meeting Test';
		$data['Meeting']['meeting_date']='2008-12-12 14:00';
		$data['Meeting']['venue']='Bilik Mesyuarat 1';
		$data['User']['User'][]=1;
		$this->Meeting->save($data);

		$resultall=$this->Meeting->findAll();
		$result=Set::extract($resultall,'{n}.Meeting.meeting_num');
		$expected=array('1/2008','test/1/2008');
		$this->assertEqual($result,$expected);

		$result=Set::extract($resultall,'{n}.User.{n}.username');
		$expected=array(
			array(),
			array(
				'mamat'
			)
		);
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'-- %s');

		$resultattend=$this->Meeting->Attendance->findAll();
		$result=Set::extract($resultattend,'{n}.Attendance');
		$expected = array(
			array(
				'id'=>1,
				'meeting_id'=>2,
				'user_id'=>1,
				'will_attend'=>0,
				'attended'=>0,
				'representative'=>0,
				'excuse'=>NULL,
				'created'=>NULL,
				'updated'=>NULL
			),
		);
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'-- %s');


		$data['Attendance']['will_attend']=1;
		$data['Attendance']['id']=1;
		$this->Meeting->Attendance->save($data);
		$resultattend=$this->Meeting->Attendance->findAll();
		$result=Set::extract($resultattend,'{n}.Attendance');
		$expected = array(
			array(
				'id'=>1,
				'meeting_id'=>2,
				'user_id'=>1,
				'will_attend'=>1,
				'attended'=>0,
				'representative'=>0,
				'excuse'=>NULL,
				'created'=>NULL,
				'updated'=>date('Y-m-d')
			),
		);
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'-- %s');

		$data['Meeting']['venue']='Bilik Mesyuarat 5';
		$data['Meeting']['id']=2;
		$this->Meeting->unbindModel(array('hasAndBelongsToMany'=>array('User')),false);
		$this->Meeting->saveAll($data);

		$resultattend=$this->Meeting->Attendance->findAll();
		$result=Set::extract($resultattend,'{n}.Attendance');
		$expected = array(
			array(
				'id'=>1,
				'meeting_id'=>2,
				'user_id'=>1,
				'will_attend'=>1,
				'attended'=>0,
				'representative'=>0,
				'excuse'=>NULL,
				'created'=>NULL,
				'updated'=>date('Y-m-d')
			),
		);
		$this->assertEqual($result,$expected,'Result is:'.print_r($result,true).'-- %s');
	}

	function testReplaceTemplate(){
		$this->Meeting =& ClassRegistry::init('Meeting');
		$template='%Meeting.meeting_num will be held at %Meeting.meeting_venue';
		$data['Meeting']['meeting_num']='1/2008';
		$data['Meeting']['meeting_venue']='Old Town Cafe';
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe';
		$this->assertEqual($result,$expected);

		$data['Link']['meeting']=array('controller'=>'meetings','action'=>'view','id'=>1);
		$template='%Meeting.meeting_num will be held at %Meeting.meeting_venue. Link at %Link.meeting';
		Configure::write('server_url','http://localhost/');
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe. Link at <a href=\'http://localhost/meetings/view/1\'>http://localhost/meetings/view/1</a>';
		$this->assertEqual($result,$expected);

		Configure::write('server_url','http://mymeeting.oscc.org.my/');
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe. Link at <a href=\'http://mymeeting.oscc.org.my/meetings/view/1\'>http://mymeeting.oscc.org.my/meetings/view/1</a>';
		$this->assertEqual($result,$expected);

		Configure::write('server_url','https://mymeeting.oscc.org.my/');
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe. Link at <a href=\'https://mymeeting.oscc.org.my/meetings/view/1\'>https://mymeeting.oscc.org.my/meetings/view/1</a>';
		$this->assertEqual($result,$expected);

		Configure::write('server_url','http://mymeeting.oscc.org.my/');
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe. Link at <a href=\'http://mymeeting.oscc.org.my/meetings/view/1\'>http://mymeeting.oscc.org.my/meetings/view/1</a>';
		$this->assertEqual($result,$expected);

		$data['Link']['meeting']=array('controller'=>'meetings','action'=>'view','id'=>1);
		$template='%Meeting.meeting_num will be held at %Meeting.meeting_venue. Click %Link.meeting:here';
		$result=$this->Meeting->replacetemplate($template,$data);
		$expected='1/2008 will be held at Old Town Cafe. Click <a href=\'http://mymeeting.oscc.org.my/meetings/view/1\'>here</a>';
		$this->assertEqual($result,$expected);
	}
}
?>
