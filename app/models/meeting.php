<?php
/*
 * Copyright (c) 2008 Government of Malaysia
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * @author: Abdullah Zainul Abidin, Nuhaa All Bakry
 *          Eavay Javay Barnad, Sarogini Muniyandi
 *
 */

class Meeting extends AppModel {

	/**
	 * Defining the name of model
	 *
	 */
	var $name = 'Meeting';
	/**
	 * Defining the name of the table
	 *
	 */
	var $useTable = 'meetings';
	/**
	 * Displaying meeting short name
	 *
	 */
	var $displayField = 'meeting_num';
	/**
	 * Defining behavior in the model
	 *
	 */
	var $actsAs = array('Comment','MultiFile','Workflow','Containable');

	//validation
	/**
	 * Validating the fields in meeting model
	 *
	 */
	var $validate = array(
		'meeting_title' =>array('required'=>VALID_NOT_EMPTY),
		'meeting_date'=>array('required'=>VALID_NOT_EMPTY),
		'venue'=>array('required'=>VALID_NOT_EMPTY),
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/**
	 * Building assosiations betweeen models
	 *
	 */
	var $belongsTo = array(
		'Committee' => array(
			'className' => 'Committee',
			'foreignKey' => 'committee_id',
			'conditions' => '',
			'fields' => '',
			'order' => '')
		);

	/**
	 * Building assosiations betweeen models
	 *
	 */
	var $hasMany = array(
		'Decision' => array(
			'className' => 'Decision',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''),
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''),
		'Todo' => array(
			'className' => 'Meetingtodo',
			'foreignKey' => 'meeting_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => '')
		);

	/**
	 * Building assosiations betweeen models
	 *
	 */
	var $hasAndBelongsToMany = array(
		'User'=>array('with'=>'Attendance')
	);

	/**
	 * Getting all the related users per meeting defined by the meeting_id
	 * $param meeting_id finds all the related users per meeting
	 */
	function getUsersPerMeeting($meeting_id) {
		$o = $this->Attendance->find('all',array(
			'conditions'=>array('meeting_id'=>$meeting_id)
		));
		return $o;                                  
	}

	/**
	 * Return various data about the user (user_id) regarding a meeting (meeting_id)
	 * @return an array with invited, attended, role, and groups
	 */
	function userData($user_id,$meeting_id=null){
		if($meeting_id){
			$toret=$this->Committee->userData($user_id,$this->getCommitteeId($meeting_id));
			//$userdat=$this->MeetingsUser->find('first',array('conditions'=>array('meeting_id'=>$meeting_id,'user_id'=>$user_id)));
			$userdat=$this->Attendance->find('first',array('conditions'=>array('meeting_id'=>$meeting_id,'user_id'=>$user_id)));
			if(count($userdat['Attendance'])){
				$toret['invited']=true;
				$toret['attended']=$userdat['Attendance']['attended'];
			}
			else{
				$toret['invited']=false;
				$toret['attended']=false;
			}
			return $toret;
		}
		return false;
	}

	/**
	 * Getting all the related committees defined by the meeting_id
	 * $param meeting_id finds all the committee
	 */
	function getCommitteeId($meeting_id){
		$data=$this->getData(array('committee_id'),array('id'=>$meeting_id));
		return $data[0]['Meeting']['committee_id'];
	}

	/**
	 * Pagination
	 */
	function paginate($conditions,$fields,$order,$limit,$page,$recursive){
		/* Used to get rid of all the other bindings first. Greatly reduces the amount of query */
		return $this->findAll($conditions,$fields,$order,$limit,$page,$recursive);
	}

	/**
	 * Finding fields in the template that matches the  marker
	 * 
	 */
	function templatefield($field,$template){
		preg_match('/%(?<mfield>['.low($field).'|'.up($field).']+)/',$template,$matches);
		if(isset($matches['mfield'])){
			$toret['length']=strlen($matches['mfield'])+1;  //have to plus to compensate for marker %
			$toret['pos']=strpos($template,$matches['mfield'])-1;  //have to minus to compensate for marker %
			$toret['field']=$matches['mfield'];
			return $toret;
		}
		return null;
	}

	function replacetemplatedate($template,$fyear,$fmonth){
		if($fyear){
			if($fyear['length']==5) $ydat=date("Y");
			elseif($fyear['length']==3) $ydat=date("y");
			$template=str_replace('%'.$fyear['field'],$ydat,$template);
		}
		if($fmonth){
			if($fmonth['length']==3) $mdat=date("m");
			elseif($fmonth['length']==4) $mdat=date("M");
			$template=str_replace('%'.$fmonth['field'],$mdat,$template);
		}
		return $template;
	}

	/**
	 * Getting all the next numbers (x,y,m) in the meeting for the the defined committee_id
	 * $param committee_id finds all the next numbers in the meeting
	 */
	function nextnumber($committee_id){
		$template=$this->Committee->field('meeting_num_template',array('id'=>$committee_id));
		$fnum=$this->templatefield('x',$template);
		$fyear=$this->templatefield('y',$template);
		$fmonth=$this->templatefield('m',$template);
		if($fnum){  //inside the template there is a placeholder for numbers
			$template=$this->replacetemplatedate($template,$fyear,$fmonth);
			$btemplate=str_replace('%'.$fnum['field'],'%',$template);
			$latestnum=$this->find('first',array('limit'=>1,'order'=>'meeting_num desc','conditions'=>array('committee_id'=>$committee_id,'meeting_num'=>"like $btemplate")));
			$db =& ConnectionManager::getDataSource($this->useDbConfig);
			$latestnum=$this->query('SELECT Meeting.meeting_num from '.$db->fullTableName('meetings').' as Meeting where Meeting.committee_id='.$committee_id.' and Meeting.meeting_num like \''.$btemplate.'\' order by Meeting.meeting_num desc limit 1');
			$dnum=0;
			if(isset($latestnum[0])){
				$dlatest=$latestnum[0]['Meeting']['meeting_num'];
				for($i=$fnum['pos'];$i<strlen($dlatest);$i++){
					$c=substr($dlatest,$i,1);
					if(is_numeric($c)){
						$dnum.=$c;
					}
					else{
						break;
					}
				}
			}
			$dnum+=1;
			return str_replace('%'.$fnum['field'],$dnum,$template);
		}
		$latestnum=$this->find('first',array('limit'=>1,'order'=>'meeting_num desc','conditions'=>array('committee_id'=>$committee_id)));
		return $latestnum['Meeting']['meeting_num'];
	}
	
	function meetingtitle($committee_id) {
	    $meeting = $this->Committee->find(array('Committee.id'=>$committee_id));
	    //debug($meeting);
	    $defaulttitle = $meeting['Committee']['meeting_title_template'];
	    $defaulttitle = str_replace('%committeeshort',$meeting['Committee']['short_name'],$defaulttitle);
	    $defaulttitle = str_replace('%committeelong',$meeting['Committee']['name'],$defaulttitle);
	    return $defaulttitle;
    }
}
?>
