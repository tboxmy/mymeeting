<?php 

App::import('Model', 'Decision');

class DecisionTestCase extends CakeTestCase {
	var $fixtures = array('app.log','app.user','app.title','app.meetings_todo','app.userstatus','app.decision','app.item','app.workflow','app.groupstatus','app.group','app.users_group','app.decisions_user','app.decisions_group','app.membership','app.role','app.attendance','app.announcement','app.committees_todo','app.notification','app.committee','app.meeting');

	function testextractminutes(){
		$this->Decision =& ClassRegistry::init('Decision');
		$minutes = "1. Pengerusi Ucapkan Alu-aluan
			1.1 Anda semua dialu-alukan
			###
			2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))
			###
			3. Macam bagus je {{mamat}} mengemas [[rumah]]
			###
			4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))
			###
			5. Penutup yg hebat dan bermakna oleh {{g:mega}}
		";

		$result=$this->Decision->getMinutes($minutes);
		$expected=array(
			"2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))",
			"3. Macam bagus je {{mamat}} mengemas [[rumah]]",
			"4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
			"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
		);
		$this->assertEqual($result,$expected);

		$data=$result=$this->Decision->extractMinutes($minutes);
		$expected=array(
			array(
				'Item'=>'mymeeting',
				'User'=>array(
					'abdullah',
					'g:test'
				),
				'Dateline'=>'2008-12-05',
				'Decision'=>'2. abdullah,g:test kena implement mymeeting di MAMPU sebelum 2008-12-05',
				'OriDecision'=>'2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))',
			),
			array(
				'Item'=>'rumah',
				'User'=>array(
					'mamat'
				),
				'Dateline'=>null,
				'Decision'=>'3. Macam bagus je mamat mengemas rumah',
				'OriDecision'=> "3. Macam bagus je {{mamat}} mengemas [[rumah]]",

			),
			array(
				'Item'=>'zzzz',
				'User'=>array(
					'gunesh'
				),
				'Dateline'=>'23-12-2008',
				'Decision'=>'4. gunesh need to rewrite zzzz by 23-12-2008',
				'OriDecision'=> "4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
			),
			array(
				'Item'=>null,
				'User'=>array(
					'g:mega'
				),
				'Dateline'=>null,
				'Decision'=>"5. Penutup yg hebat dan bermakna oleh g:mega",
				'OriDecision'=>"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
			),
		);
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');

		$ddata=$result=$this->Decision->filterData($data,1);
		$expected=array(
			array(
				'Item'=>array(
					array(
						'Item'=>array(
							'id'=>1,
							'short_name'=>'mymeeting',
							'name'=>'MyMeeting'
						),
					),
					array(
						'Item'=>array(
							'id'=>4,
							'short_name'=>'MAMPUmymeeting',
							'name'=>'MyMeeting MAMPU'
						),
					),
				),
				'LostItem'=>'mymeeting',
				'User'=>array(
					array(
						array(
							'User'=>array(
								'id'=>3,
								'name'=>'abdullah'
							),
						),
					),
				),
				'Group'=>array(
					array(
						array(
							'Group'=>array(
								'id'=>1,
								'name'=>'test group'
							),
						),
					),
				),
				'Dateline'=>'2008-12-05',
				'Decision'=>'2. abdullah,g:test kena implement mymeeting di MAMPU sebelum 2008-12-05',
				'OriDecision'=>'2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))',
			),
			array(
				'Item'=>array(
					array(
						'Item'=>array(
							'id'=>2,
							'short_name'=>'train',
							'name'=>'Train Wreck'
						),
					),
					array(
						'Item'=>array(
							'id'=>4,
							'short_name'=>'MAMPUmymeeting',
							'name'=>'MyMeeting MAMPU'
						),
					),
				),
				'LostItem'=>'rumah',
				'User'=>array(
					array(
						array(
							'User'=>array(
								'id'=>1,
								'name'=> 'mamat'
							),
						),
						array(
							'User'=>array(
								'id'=>2,
								'name'=> 'mamatian'
							),
						),
					),
				),
				'Group'=>array(),
				'Dateline'=>null,
				'Decision'=>'3. Macam bagus je mamat mengemas rumah',
				'OriDecision'=> "3. Macam bagus je {{mamat}} mengemas [[rumah]]",
			),
			array(
				'Item'=>array(),
				'LostItem'=>'zzzz',
				'User'=>array(
					array(),
				),
				'Group'=>array(),
				'Dateline'=>'2008-12-23',
				'Decision'=>'4. gunesh need to rewrite zzzz by 23-12-2008',
				'OriDecision'=> "4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
			),
			array(
				'Item'=>array(),
				'LostItem'=>null,
				'User'=>null,
				'Group'=>array(
					array(
						array(
							'Group'=>array(
								'id'=>2,
								'name'=>'megaman'
							),
						),
					),
				),
				'Dateline'=>null,
				'Decision'=>"5. Penutup yg hebat dan bermakna oleh g:mega",
				'OriDecision'=>"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
			),
		);
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');

		$ddata=$result=$this->Decision->itemList($ddata,1);
		$expected=array(
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'mymeeting',
				'User'=>array(
					array(
						array(
							'User'=>array(
								'id'=>3,
								'name'=>'abdullah'
							),
						),
					),
				),
				'Group'=>array(
					array(
						array(
							'Group'=>array(
								'id'=>1,
								'name'=>'test group'
							),
						),
					),
				),
				'Dateline'=>'2008-12-05',
				'Decision'=>'2. abdullah,g:test kena implement mymeeting di MAMPU sebelum 2008-12-05',
				'OriDecision'=>'2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))',
			),
			array(
				'Item'=>array(
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'rumah',
				'User'=>array(
					array(
						array(
							'User'=>array(
								'id'=>1,
								'name'=> 'mamat'
							),
						),
						array(
							'User'=>array(
								'id'=>2,
								'name'=> 'mamatian'
							),
						),
					),
				),
				'Group'=>array(),
				'Dateline'=>null,
				'Decision'=>'3. Macam bagus je mamat mengemas rumah',
				'OriDecision'=> "3. Macam bagus je {{mamat}} mengemas [[rumah]]",
			),
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 2,
						'short_name'=>'train',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
					array(
						'id'=> 4,
						'short_name'=>'MAMPUmymeeting',
					),
				),
				'LostItem'=>'zzzz',
				'User'=>array(
					array(),
				),
				'Group'=>array(),
				'Dateline'=>'2008-12-23',
				'Decision'=>'4. gunesh need to rewrite zzzz by 23-12-2008',
				'OriDecision'=> "4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
				'noitem'=>true
			),
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 2,
						'short_name'=>'train',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
					array(
						'id'=> 4,
						'short_name'=>'MAMPUmymeeting',
					),
				),
				'LostItem'=>null,
				'User'=>null,
				'Group'=>array(
					array(
						array(
							'Group'=>array(
								'id'=>2,
								'name'=>'megaman'
							),
						),
					),
				),
				'Dateline'=>null,
				'Decision'=>"5. Penutup yg hebat dan bermakna oleh g:mega",
				'OriDecision'=>"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
				'noitem'=>true,
			),
		);
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');

		$ddata=$result=$this->Decision->userList($ddata,1);
		$expected=array(
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'mymeeting',
				'User'=>array(
					array(
						array(
							'id'=>3,
							'name'=>'abdullah'
						),
						array(
							'id'=>5,
							'name'=>'Ahmad'
						),
						array(
							'id'=>1,
							'name'=>'mamat'
						),
						array(
							'id'=>2,
							'name'=>'mamatian'
						),
						array(
							'id'=>4,
							'name'=>'Razak'
						),
					),
				),
				'Group'=>array(
					array(
						array(
							'Group'=>array(
								'id'=>1,
								'name'=>'test group'
							),
						),
					),
				),
				'Dateline'=>'2008-12-05',
				'Decision'=>'2. abdullah,g:test kena implement mymeeting di MAMPU sebelum 2008-12-05',
				'OriDecision'=>'2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))',
			),
			array(
				'Item'=>array(
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'rumah',
				'User'=>array(
					array(
						array(
							'id'=>1,
							'name'=> 'mamat'
						),
						array(
							'id'=>2,
							'name'=> 'mamatian'
						),
						array(
							'id'=>3,
							'name'=> 'abdullah'
						),
						array(
							'id'=>5,
							'name'=> 'Ahmad'
						),
						array(
							'id'=>4,
							'name'=> 'Razak'
						),
					),
				),
				'Group'=>array(
					),
					'Dateline'=>null,
					'Decision'=>'3. Macam bagus je mamat mengemas rumah',
					'OriDecision'=> "3. Macam bagus je {{mamat}} mengemas [[rumah]]",
				),
				array(
					'Item'=>array(
						array(
							'id'=>1,
							'short_name'=>'mymeeting',
						),
						array(
							'id'=> 2,
							'short_name'=>'train',
						),
						array(
							'id'=> 3,
							'short_name'=>'House',
						),
						array(
							'id'=> 4,
							'short_name'=>'MAMPUmymeeting',
						),
					),
					'LostItem'=>'zzzz',
					'User'=>array(
						array(
							array(
								'id'=>3,
								'name'=>'abdullah'
							),
							array(
								'id'=>5,
								'name'=>'Ahmad'
							),
							array(
								'id'=>1,
								'name'=>'mamat'
							),
							array(
								'id'=>2,
								'name'=>'mamatian'
							),
							array(
								'id'=>4,
								'name'=>'Razak'
							),
						),
					),
					'Group'=>array(
						),
						'Dateline'=>'2008-12-23',
						'Decision'=>'4. gunesh need to rewrite zzzz by 23-12-2008',
						'OriDecision'=> "4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
						'noitem'=>true,
						'nouser'=>array(true)
					),
					array(
						'Item'=>array(
							array(
								'id'=>1,
								'short_name'=>'mymeeting',
							),
							array(
								'id'=> 2,
								'short_name'=>'train',
							),
							array(
								'id'=> 3,
								'short_name'=>'House',
							),
							array(
								'id'=> 4,
								'short_name'=>'MAMPUmymeeting',
							),
						),
						'LostItem'=>null,
						'User'=>null,
						'Group'=>array(
							array(
								array(
									'Group'=>array(
										'id'=>2,
										'name'=>'megaman'
									),
								),
							),
						),
						'Dateline'=>null,
						'Decision'=>"5. Penutup yg hebat dan bermakna oleh g:mega",
						'OriDecision'=>"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
						'noitem'=>true,
					),
				);
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');

		$result=$this->Decision->groupList($ddata,1);
		$expected=array(
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'mymeeting',
				'User'=>array(
					array(
						array(
							'id'=>3,
							'name'=>'abdullah'
						),
						array(
							'id'=>5,
							'name'=>'Ahmad'
						),
						array(
							'id'=>1,
							'name'=>'mamat'
						),
						array(
							'id'=>2,
							'name'=>'mamatian'
						),
						array(
							'id'=>4,
							'name'=>'Razak'
						),
					),
				),
				'Group'=>array(
					array(
						array(
							'id'=>1,
							'name'=>'test group'
						),
						array(
							'id'=>2,
							'name'=>'megaman'
						),
					),
				),
				'Dateline'=>'2008-12-05',
				'Decision'=>'2. abdullah,g:test kena implement mymeeting di MAMPU sebelum 2008-12-05',
				'OriDecision'=>'2. {{abdullah,g:test}} kena implement [[mymeeting]] di MAMPU sebelum ((2008-12-05))',
			),
			array(
				'Item'=>array(
					array(
						'id'=>2,
						'short_name'=>'train'
					),
					array(
						'id'=>4,
						'short_name'=>'MAMPUmymeeting'
					),
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
				),
				'LostItem'=>'rumah',
				'User'=>array(
					array(
						array(
							'id'=>1,
							'name'=> 'mamat'
						),
						array(
							'id'=>2,
							'name'=> 'mamatian'
						),
						array(
							'id'=>3,
							'name'=> 'abdullah'
						),
						array(
							'id'=>5,
							'name'=> 'Ahmad'
						),
						array(
							'id'=>4,
							'name'=> 'Razak'
						),
					),
				),
				'Group'=>array(),
				'Dateline'=>null,
				'Decision'=>'3. Macam bagus je mamat mengemas rumah',
				'OriDecision'=> "3. Macam bagus je {{mamat}} mengemas [[rumah]]",
			),
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 2,
						'short_name'=>'train',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
					array(
						'id'=> 4,
						'short_name'=>'MAMPUmymeeting',
					),
				),
				'LostItem'=>'zzzz',
				'User'=>array(
					array(
						array(
							'id'=>3,
							'name'=>'abdullah'
						),
						array(
							'id'=>5,
							'name'=>'Ahmad'
						),
						array(
							'id'=>1,
							'name'=>'mamat'
						),
						array(
							'id'=>2,
							'name'=>'mamatian'
						),
						array(
							'id'=>4,
							'name'=>'Razak'
						),
					),
				),
				'Group'=>array(),
				'Dateline'=>'2008-12-23',
				'Decision'=>'4. gunesh need to rewrite zzzz by 23-12-2008',
				'OriDecision'=> "4. {{gunesh}} need to rewrite [[zzzz]] by ((23-12-2008))",
				'noitem'=>true,
				'nouser'=>array(true)
			),
			array(
				'Item'=>array(
					array(
						'id'=>1,
						'short_name'=>'mymeeting',
					),
					array(
						'id'=> 2,
						'short_name'=>'train',
					),
					array(
						'id'=> 3,
						'short_name'=>'House',
					),
					array(
						'id'=> 4,
						'short_name'=>'MAMPUmymeeting',
					),
				),
				'LostItem'=>null,
				'User'=>null,
				'Group'=>array(
					array(
						array(
							'id'=>2,
							'name'=>'megaman'
						),
						array(
							'id'=>1,
							'name'=>'test group'
						),
					),
				),
				'Dateline'=>null,
				'Decision'=>"5. Penutup yg hebat dan bermakna oleh g:mega",
				'OriDecision'=>"5. Penutup yg hebat dan bermakna oleh {{g:mega}}",
				'noitem'=>true,
			),
		);
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');
	}

    function testordering(){
		$this->Decision =& ClassRegistry::init('Decision');
        $this->Decision->promote(8);
        $this->Decision->Behaviors->detach('Comment');
        $result=$this->Decision->find('first',array(
            'conditions'=>array(
                'id'=>8,
            ),
            'contain'=>false,
        ));
		$expected=array('Decision'=>array('id'=>8,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'minute_reference'=>'','description'=>'grp Testing decision not done late','ordering'=>7,'deadline'=>'2008-10-15','deleted'=>0,'deleted_date'=>$result['Decision']['deleted_date'],'created'=>$result['Decision']['created'],'updated'=>$result['Decision']['updated']));
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');

        $this->Decision->demote(9);
        $result=$this->Decision->find('first',array(
            'conditions'=>array(
                'id'=>9,
            ),
            'contain'=>false,
        ));
		$expected=array('Decision'=>array('id'=>9,'committee_id'=>1,'meeting_id'=>1,'item_id'=>1,'minute_reference'=>'','description'=>'grp Testing decision done on time','ordering'=>10,'deadline'=>$result['Decision']['deadline'],'deleted'=>0,'deleted_date'=>$result['Decision']['deleted_date'],'created'=>$result['Decision']['created'],'updated'=>$result['Decision']['updated']));
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');
    }

    function teststatus(){
		$this->Decision =& ClassRegistry::init('Decision');
        $this->Decision->bindLatest();
        $dresult=$this->Decision->find('all',array(
            'conditions'=>array(
                'meeting_id'=>1,
            ),
            'contain'=>array(
                'Userstatus',
            ),
        ));
        $result=Set::extract($dresult,'{n}.Userstatus.{n}.description');
        $expected=array(
            array(
                'done on time second',
                'done on time second other guy',
            ),
            array(
                'done late',
            ),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
            array(),
        );
		$this->assertEqual($result,$expected,'Result is '.print_r($result,true).'--%s');
    }
}
?>
