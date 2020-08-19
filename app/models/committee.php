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

class Committee extends AppModel {
	/**
	 * Defining behavior in the model
	 *
	 */
    var $actsAs = array('Tree','Containable');
    /**
     * Defining the name of model
     *
     */
    var $name = 'Committee';
    /**
     * Defining the name of the table
     *
     */
    var $useTable = 'committees';
    /**
     * Displaying committee short name
     *
     */
    var $displayField = 'short_name';

    /**
     * Validating the fields in committee model
     *
     */
    var $validate = array(
        'name' => array('required'=>VALID_NOT_EMPTY),
        'short_name' =>array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Alphabets and numbers only'),
            'required'=>VALID_NOT_EMPTY,
            'unique'=>array('rule' => array('checkUnique', 'short_name')
        )),'meeting_num_template' => array('required'=>VALID_NOT_EMPTY));

    /**
     * Building assosiations betweeen models (ex : committee hasMany announcement)
     *
     */
    var $hasMany = array(
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Meeting' => array(
            'className' => 'Meeting',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Decision' => array(
            'className' => 'Decision',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Userstatus' => array(
            'className' => 'Userstatus',
            'foreignKey' => 'decision_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Groupstatus' => array(
            'className' => 'Groupstatus',
            'foreignKey' => 'decision_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Workflow' => array(
            'className' => 'Workflow',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
        'Wfmodel' => array(
            'className' => 'Wfmodel',
            'foreignKey' => 'committee_id',
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
            'className' => 'Committeetodo',
            'foreignKey' => 'committee_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''),
    );

    /**
     * Building assosiations betweeen models
     *
     */
    var $hasAndBelongsToMany = array(
        'User'=> array('with'=>'Membership')
    );

    /**
     * Find all the group which the user is associated with 
     * @param committee_id The committee to look in
     * @param user_id The user who's group we want to look for
     * @return an array of group id where the user is a member
     */
    function userGroups($committee_id,$user_id){
        $group=$this->Group->UsersGroup->find('all',array(
            'conditions'=>array(
                'user_id'=>$user_id,
                'group_id'=>Set::extract($this->Group->find('all',array('conditions'=>array('committee_id'=>$committee_id))),'{n}.Group.id')
            )
        ));
        return Set::extract($group,'{n}.UsersGroup.group_id');
    }

    /**
     * Find all the decision which the user is associated with 
     * @param committee_id The committee to look in
     * @param user_id The user who's status we want to look for
     * @return an array of decision id where the decision to the user
     */
    function userDecision($committee_id,$user_id){
        $decision=$this->Decision->DecisionsUser->find('all',array('conditions'=>array('decision_id'=>$this->Decision->find('list',array('conditions'=>array('committee_id'=>$committee_id))),'user_id'=>$user_id)));
        $decision=Set::extract($decision,'{n}.DecisionsUser.decision_id');
        $groupdecision=$this->Decision->DecisionsGroup->find('all',array('conditions'=>array('decision_id'=>$this->Decision->find('list',array('conditions'=>array('committee_id'=>$committee_id))),'group_id'=>$this->userGroups($committee_id,$user_id))));
        $groupdecision=Set::extract($groupdecision,'{n}.DecisionsGroup.decision_id');
        return array_merge($decision,$groupdecision);
    }

    /**
     * Find all the decision which the user has updated
     * @param committee_id The committee to look in
     * @param user_id The user who's status we want to look for
     * @return an array of decision id where the decision has been updated by the user
     */
    function updatedDecision($committee_id,$user_id){
        $userstatus=Set::extract(
            $this->Userstatus->find('all',array(
                'conditions'=>array(
                    'Userstatus.committee_id'=>$committee_id,
                    'Userstatus.user_id'=>$user_id
                )
            )),'{n}.Decision.id'
        );
        $groupstatus=Set::extract(
            $this->Groupstatus->find('all',array(
                'conditions'=>array(
                    'Groupstatus.committee_id'=>$committee_id,
                    'Groupstatus.group_id'=>$this->userGroups($committee_id,$user_id)
                )
            )),'{n}.Decision.id'
        );
        return array_merge($userstatus,$groupstatus);
    }

    /**
     * Find all the decision which the user need to update
     * @param committee_id The committee to look in
     * @param user_id The user who's status we want to look for
     * @return an array of decision id where the decision has not been updated by the user
     */
    function notUpdatedDecision($committee_id,$user_id){
        $updated=$this->updatedDecision($committee_id,$user_id);
        $this->Decision->Behaviors->detach('MultiFile');
        $this->Decision->Behaviors->detach('Comment');
        $needupdating=$this->Decision->find('all',array(
            'conditions'=>array(
                'committee_id'=>$committee_id,
                'id'=>$this->userDecision($committee_id,$user_id),
                'not'=>array('id'=>$updated),
                'or'=>array(
                    array(
                        'deadline'=>'0000-00-00',
                    ),
                    array(
                        'deadline>=\''.date('Y-m-d').'\'',
                    ),
                ),
            ),
            'contain'=>'User.id="'.$user_id.'"'
        ));
        return $needupdating;
    }

    /**
     * Finding all the related userdata defined by the committee_id and user_id
     * $param committee_id and user_id finds all the related userdata
     */
    function userData($user_id,$committee_id=null){
        $groups=$this->Membership->User->UsersGroup->find('all',array(
            'conditions'=>array('user_id'=>$user_id),
        ));
        $toret['groups']=Set::extract($groups,"{n}.UsersGroup.group_id");
        $role=$this->Membership->find('first',array(
            'fields'=>array('role_id'),
            'conditions'=>array('user_id'=>$user_id,'committee_id'=>$committee_id),
        ));
        $drole=$this->Membership->Role->find('first',array(
            'conditions'=>array('id'=>$role['Membership']['role_id']),
            'fields'=>array('name'),
        ));
        $toret['role']=$drole['Role']['name'];
        return $toret;
    }

    /**
     * Finding all the related committees per user defined by the user_id order by committee name
     * $param user_id finds all the committees per user
     */
    function getCommitteesPerUser($user_id) {
        $committees = $this->Membership->findAll(
            array(
                'conditions'=>array(
                    'Membership.user_id'=>$user_id)
                ),
                'Committee.*',
                'Committee.name ASC');
        return $committees;
    }

    /**
     * Finding all the related registered committee defined by the user_id order by committee name
     * $param user_id finds all the registered committee
     */
    function registeredCommittee($user_id){
        return Set::extract($this->Membership->find('all',array('fields'=>'committee_id','conditions'=>array('user_id'=>$user_id))),"{n}.Membership.committee_id");
    }

    /**
     * Finding all the related list of registered committee defined by the user_id order by committee name
     * $param user_id finds all the list of registered committee
     */
    function registeredCommitteeList($user_id){
        return $this->find('all',array('contain'=>false,'fields'=>array('id','short_name','name','parent_id'),'order'=>'name ASC, parent_id ASC','conditions'=>array('id'=>$this->registeredCommittee($user_id))));
    }

    /**
     * Allowing afterSave() callbacks to modify the value of a data field.
     * @param created modifies the value of a data field.
     */
    function afterSave($created){
        if($created){
            $comid=$this->getLastInsertID();
            $data['view']=$wfdata['view']='all';
            $data['edit']=$wfdata['edit']='role:admin';
            $data['delete']=$wfdata['delete']='role:admin';
            $wfdata['level']=1;
            $wfdata['committee_id']=$comid;
            $data['committee_id']=$comid;
            $data['create']='role:admin';
            $wfdata['model']=$data['model']='Meeting';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);


            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Decision';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Item';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Membership';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $data['view']=$wfdata['view']='role:admin';

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Committee';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Workflow';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Wfmodel';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Committeetodo';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Group';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Announcement';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Template';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Attendance';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Meetingtodo';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $data['create']='role:admin,owner';
            $data['view']=$wfdata['all']='role:admin';
            
            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Userstatus';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

            $this->Wfmodel->create();
            $this->Workflow->create();
            $wfdata['model']=$data['model']='Groupstatus';
            $this->Workflow->save($wfdata);
            $this->Wfmodel->save($data);

        }
    }


    function getSearchResults($dcommittee,$status) {

        // query for latest status for each user 
        $finder = 'SELECT Status.*, User.*
            FROM `userstatuses` AS `Status` 
            JOIN `users` AS `User` ON (`Status`.`user_id` = `User`.`id`) 
            LEFT JOIN userstatuses as s2 ON (Status.user_id=s2.user_id and Status.decision_id=s2.decision_id and Status.updated < s2.updated)
            WHERE s2.id is NULL AND Status.action_date != "0000-00-00" AND Status.decision_id IN ({$__cakeID__$}) ';

        // then bind it to each decision
        $this->Meeting->Decision->bindModel(array('hasMany'=>array(
            'Status' => array(
                'className' => 'Userstatus',
                'foreignKey' => 'decision_id',
                'dependent' => false,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => $finder,
                'counterQuery' => ''))));

        // get all decisions for this committee
        $result=$this->Meeting->Decision->findAll(array('Meeting.committee_id'=>$dcommittee['Committee']['id']),
            '',
            'Meeting.meeting_title,Item.name,Decision.deadline ASC');

        // determine condition based on search criteria
        switch ($status) {
        case 'takenontime' : $cond = 'Userstatus.action_date <= Decision.deadline';
            break;
        case 'takenlate' : $cond = 'Userstatus.action_date > Decision.deadline';
            break;
        }        

        // get all status fulfilling the search criteria
        $filter=$this->Meeting->Decision->Userstatus->findAll($cond,array('Userstatus.*'));     

        // get decision ids from it
        $decision_ids = array();
        foreach ($filter as $f) {
            array_push($decision_ids,$f['Userstatus']['decision_id']);
        }
        $decision_ids = array_unique($decision_ids);

        // then filter it to get decisions to display based on search criteria
        foreach ($result as $key=>$value) {
            if (!in_array($value['Decision']['id'],$decision_ids)) 
                unset($result[$key]);
        }
        //echo "<pre>".print_r($decision_ids,true)."</pre>";

        return $result; 
    }

    /**
     * Finding all the decision status which is not taken and on time defined by the committee_id
     * $param committee_id finds all the decision status which is not taken for the specified user type
     */
    function nottaken($committee_id,$type='User'){
        $all=$this->query($this->statusquery($type,$type.'Status.id is null and Decision.deadline>=now() and Meeting.committee_id='.$committee_id,false));
        return $all;
        echo "<pre>".print_r($decision_ids,true)."</pre>";
    }

    /**
     * Finding all the decision status which is not taken and over due defined by the committee_id
     * $param committee_id finds all the decision status which is not taken for the specified user type
     */
    function nottakenlate($committee_id,$type='User'){
        $all=$this->query($this->statusquery($type,$type.'Status.id is null and Decision.deadline<now() and Meeting.committee_id='.$committee_id,false));
        return $all;

    }

    /**
     * Finding all the decision status which is taken and on time defined by the committee_id
     * $param committee_id finds all the decision status which is taken and on time for the specified user type
     */
    function takenontime($committee_id,$type='User'){
        $sql = $this->statusquery($type,$type.'Status.action_date<=Decision.deadline and Meeting.committee_id='.$committee_id);
        $all=$this->query($sql);
        return $all;
    }

    /**
     * Finding all the decision status which is taken and late defined by the committee_id
     * $param committee_id finds all the decision status which is taken and late for the specified user type
     */
    function takenlate($committee_id,$type='User'){
        $all=$this->query($this->statusquery($type,$type.'Status.action_date>Decision.deadline and Meeting.committee_id='.$committee_id));
        return $all;
    }

    /**
     * Query all the decision status for the specified user type
     */
    function statusquery($type='User',$cond,$taken=true){
        $statusjoin='';
        if(!$taken){
            $statusjoin='left';
        }
        $sql = 'select * from decisions_'.low($type).'s as Decision'.$type.' ';
        $sql.= $statusjoin.' join '.low($type).'statuses as '.$type.'Status ';
        $sql.= ' on ('.$type.'Status.decision_id=Decision'.$type.'.decision_id and '.$type.'Status.'.low($type).'_id=Decision'.$type.'.'.low($type).'_id)';
        $sql.= ' left join '.low($type).'statuses as s2 ';
        $sql.= ' on ('.$type.'Status.decision_id=s2.decision_id and '.$type.'Status.'.low($type).'_id=s2.'.low($type).'_id and '.$type.'Status.updated < s2.updated ) ';
        $sql.= ' join '.low($type).'s as `'.$type.'`';
        $sql.= ' on ('.$type.'.id=Decision'.$type.'.'.low($type).'_id) ';
        $sql.= ' join decisions as Decision on (Decision'.$type.'.decision_id=Decision.id) ';
        $sql.= ' left join items as Item on (Decision.item_id=Item.id) ';
        $sql.= ' left join meetings as Meeting on (Decision.meeting_id=Meeting.id) ';
        $sql.= ' where s2.id is null and '.$cond;
        return $sql;
    }

    /**
     * Describe getStatusDeadline
     *
     * @param $id
     * @return null
     */
   /* function getStatusDeadline($id){

        // query for latest status for each user 
        $ufinder = 'SELECT u.*
                    FROM userstatuses AS u
                    JOIN decisions as d on d.id=u.decision_id
                    JOIN meetings as m on m.id=d.meeting_id
                    JOIN committees AS c ON c.id = m.committee_id
                    WHERE  c.id IN ({$__cakeID__$}) ';
         $gfinder = 'SELECT g.*
                    FROM groupstatuses AS g
                    JOIN decisions as d on d.id=g.decision_id
                    JOIN meetings as m on m.id=d.meeting_id
                    JOIN committees AS c ON c.id = m.committee_id
                    WHERE  c.id IN ({$__cakeID__$}) ';

        // then bind it to each decision
         $this->bindModel(
            array(
                'hasMany'=>array(
                    'Userstatus'=>array(
                        'className' => 'Userstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $ufinder,
                        'counterQuery' => ''),
                    'Groupstatus'=>array(
                        'className' => 'Groupstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $gfinder,
                        'counterQuery' => '')
                    )
                )
            );
        return $this->read(null, $id);

   }*/

    /**
     * Describe getCommittees
     * Funtion to find all subcommittees under parent $parent registered for $user_id
     * @param $parent
     * @param $user_id
     * @return array 
     */
    function getCommittees($user_id,$get_permission=false){ 
        // get tree structure
        $mycommittees = $this->generatetreelist(array('id'=>$this->registeredCommittee($user_id)), null, '{n}.Committee.name', '_');
        
        if ($get_permission) {
            $onlythiscommittees = array();
            foreach ($mycommittees as $key=>$val) {
                array_push($onlythiscommittees,$key);
            }
            
            // get committees details
            $committees = $this->find('all', array('conditions'=>array('id'=>$onlythiscommittees),'contain'=>'Group'));
            
            // append it
            foreach ($mycommittees as $key=>$com){
                foreach ($committees as $keyc=>$value) {
                    if ($value['Committee']['id'] == $key) {
                        $mycommittees[$key.'_details'] = array();
                        array_push($mycommittees[$key.'_details'], $value['Committee']);
                        unset($committees[$keyc]);
                        break;
                    }
                }
                
            } 
        }
        
        return $mycommittees;
    }
    
    
    
}
?>
