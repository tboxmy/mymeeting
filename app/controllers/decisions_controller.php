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

class DecisionsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Decisions';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'DatePicker','Comment','Text','Javascript','MultiFile','Ajax');
    /**
     * Define $components
     *
     */
    var $components = array('MultiFile');
    /**
     * Define $uses
     *
     */
    var $uses = array ('Notification','User','Comment','Template','Attachment','Decision','Item');

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Decision->recursive = 0;
        $decisions=$this->paginate('Decision',$filters); 
        $decisions=$this->fixupauth($decisions,'Decision',$this->Auth->user('id'),$dcommittee['Committee']['id']); 
        $this->set('decisions', $decisions); 
        if($this->checkAuthority('Decision',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null))
            $this->set('allow_add_decision',true); 
    }


    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Decision.', true));
            $this->redirect(array('action'=>'index'));
        }
        $decisions=$this->Decision->getCurrentStatus($id);
        $roles=$this->Decision->userData($this->Auth->user('id'),$id);
        foreach($decisions['User'] as $user){
            if($this->Auth->user('id')==$user['id']){
                $drole['owner']=true;
            }
            else{
                $drole['owner']=false;
            }
            $froles=am($roles,$drole);
            if(($decisions['Decision']['deadline'] == '0000-00-00' || date('Y-m-d') <= $decisions['Decision']['deadline'])||(isset($roles['role']) && $roles['role']==Configure::read('defaultrole'))){
                if($this->Decision->Userstatus->isAuthorized($this->Auth->user('id'),'create',null,$dcommittee['Committee']['id'],$froles)){
                    $this->set('allow_add_user_status_'.$user['id'],true);
                }
            }
        }
        foreach($decisions['Group'] as $group){
            $userlist=$this->Decision->Group->userList($group['id']);
            if(in_array($this->Auth->user('id'),$userlist)){
                $drole['owner']=true;
            }
            else{
                $drole['owner']=false;
            }
            $froles=am($roles,$drole);
            if(($decisions['Decision']['deadline'] == '0000-00-00' || date('Y-m-d') <= $decisions['Decision']['deadline'])||(isset($roles['role']) && $roles['role']==Configure::read('defaultrole'))){
                if($this->Decision->Groupstatus->isAuthorized($this->Auth->user('id'),'create',null,$dcommittee['Committee']['id'],$froles)){
                    $this->set('allow_add_group_status_'.$group['id'],true);
                }
            }
        }
        foreach($decisions['Userstatus'] as $sid=>$status){
            $attach=$this->Attachment->find('all',array('conditions'=>array('model'=>'Userstatus','foreign_key'=>$status['id'])));
            $comment=$this->Comment->find('all',array('conditions'=>array('model'=>'Userstatus','foreign_key'=>$status['id']),'order'=>'updated desc'));
            if(count($attach)){
                $decisions['Userstatus'][$sid]['MultiFile']['additionalfiles']=$attach;
            }
            if(count($comment)){
                foreach($comment as $cid=>$curcomment){
                    $users=$this->User->find('first',array('fields'=>array('name','job_title'),'conditions'=>array('User.id'=>$curcomment['Comment']['user_id'])));
                    $comment[$cid]['Comment']['user_name']=$users['User']['name'];
                    $comment[$cid]['Comment']['job_title']=$users['User']['job_title'];
                }
                $decisions['Userstatus'][$sid]['UserstatusComment']=$comment;
            }
            $decisions['Userstatus'][$sid]['auth']=$this->Decision->Userstatus->getAuthority($this->Auth->user('id'),$status['id']);
        }
        foreach($decisions['Groupstatus'] as $sid=>$status){
            $attach=$this->Attachment->find('all',array('conditions'=>array('model'=>'Groupstatus','foreign_key'=>$status['id'])));
            $comment=$this->Comment->find('all',array('conditions'=>array('model'=>'Groupstatus','foreign_key'=>$status['id']),'order'=>'updated desc'));
            if(count($attach)){
                $decisions['Groupstatus'][$sid]['MultiFile']['additionalfiles']=$attach;
            }
            if(count($comment)){
                foreach($comment as $cid=>$curcomment){
                    $users=$this->User->find('first',array('fields'=>array('name','job_title'),'conditions'=>array('User.id'=>$curcomment['Comment']['user_id'])));
                    $comment[$cid]['Comment']['user_name']=$users['User']['name'];
                    $comment[$cid]['Comment']['job_title']=$users['User']['job_title'];
                }
                $decisions['Groupstatus'][$sid]['GroupstatusComment']=$comment;
            }
            $decisions['Groupstatus'][$sid]['auth']=$this->Decision->Groupstatus->getAuthority($this->Auth->user('id'),$status['id']);
        }
        $this->data=$decisions;
        $this->set('decision',$decisions);
        
        // get history of status
        $users = Set::extract('/User/id',$decisions);
        $groups = Set::extract('/Group/id',$decisions);
        $user_statuses = $this->Decision->Userstatus->getHistory($users,$decisions['Decision']['id']);
        $group_statuses = $this->Decision->Groupstatus->getHistory($groups,$decisions['Decision']['id']);
        $this->set('user_history_status',$user_statuses);
        $this->set('group_history_status',$group_statuses);
    }

    /**
     * Describe doaddmany
     *
     * @param $committee
     * @return null
     */
    function doaddmany($committee){
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data)){
            $meeting_id=$this->data['Decision']['meeting_id'];
            $meeting=$this->Decision->Meeting->read(null,$meeting_id);
            $minutes=$meeting['Meeting']['minutes_raw'];
            $order=0;
            foreach($this->data['Decision'] as $dname=>$ddat){
                if($dname!='meeting_id'){
                    if(isset($decision)) unset($decision);
                    $decision['Decision']['meeting_id']=$meeting_id;
                    if(isset($ddat['Item'])){
                        $decision['Decision']['item_id']=$ddat['Item'];
                    }
                    elseif(isset($ddat['ItemName'])){
                        $itemdata['name']=$ddat['ItemName'];
                        $itemdata['short_name']=$ddat['ItemShortName'];
                        $itemdata['committee_id']=$dcommittee['Committee']['id'];
                        $this->Item->create();
                        $this->Item->save($itemdata);
                        $decision['Decision']['item_id']=$this->Item->getLastInsertID();
                    }
                    if(isset($ddat['Deadline'])) $decision['Decision']['deadline']=$ddat['Deadline'];
                    $decision['Decision']['description']=$ddat['Decision'];
                    $decision['Decision']['committee_id']=$dcommittee['Committee']['id'];
                    if(!$decision['Decision']['item_id']){
                        $decision['Decision']['item_id']=0;
                    }
                    $decision['Decision']['ordering']=$order++;
                    $this->Decision->save($decision);
                    $stripd=preg_replace('|^<p>(.*)</p>$|','\1',$ddat['Decision']);
                    $minutes=str_replace($ddat['OriDecision'],'<a name=\''.$this->Decision->getLastInsertID().'\'></a>'.$stripd,$minutes);
                    $decision_id=$this->Decision->getLastInsertID();
                    if(isset($ddat['User'])){
                        foreach($ddat['User'] as $user_id){
                            if($user_id){
                                $user['DecisionsUser']['decision_id']=$decision_id;
                                $user['DecisionsUser']['user_id']=$user_id;
                                $this->Decision->DecisionsUser->save($user);
                                unset($this->Decision->DecisionsUser->id);
                            }
                        }
                    }
                    if(isset($ddat['Group'])){
                        foreach($ddat['Group'] as $group_id){
                            if($group_id){
                                $group['DecisionsGroup']['decision_id']=$decision_id;
                                $group['DecisionsGroup']['group_id']=$group_id;
                                $this->Decision->DecisionsGroup->save($group);
                                unset($this->Decision->DecisionsGroup->id);
                            }
                        }
                    }
                    unset($this->Decision->id);
                }
            }
            $minutes=str_replace(array('{{','}}','((','))','[[',']]','###'),'',$minutes);
            $meeting['Meeting']['minutes']=$minutes;
            $this->Decision->Meeting->save($meeting);
            $this->redirect(array('committee'=>$committee,'controller'=>'meetings','action'=>'view','id'=>$meeting_id));
        }
    }

    /**
     * Describe verifyminutes
     *
     * @param $committee
     * @return null
     */
    function verifyminutes($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(isset($this->params['meetingid'])){  //meetingid is provided so please load the meeting data
            $meeting=$this->Decision->Meeting->read(null,$this->params['meetingid']);
            $this->set('meeting',$meeting);
            $meeting['Meeting']['id']=$meeting['Meeting']['id'];
            $meeting['Meeting']['minutes']=$meeting['Meeting']['minutes'];
        }
        if(!empty($this->data) && isset($this->data['Decision']['meeting_id'])){  //if it actually came from a form which added a new meeting, save the data (minutes_raw) first
            $meeting['Meeting']['id']=$this->data['Decision']['meeting_id'];
            $meeting['Meeting']['minutes_raw']=$this->data['Decision']['data'];
            $this->Decision->Meeting->save($meeting);
        }
        $comid=$this->Decision->Meeting->getCommitteeId($meeting['Meeting']['id']);
        $items=$this->Decision->Item->find('all',array('fields'=>array('id','short_name','name'),'conditions'=>array('committee_id'=>$comid)));
        $this->set('items',$items);
        $this->set('users',$this->Decision->User->getUsersPerCommitteeList($comid));
        $ddat=$this->Decision->extractMinutes($meeting['Meeting']['minutes_raw']);
        $tdat=null;
        if($ddat && is_array($ddat)){
            $tdat=$this->Decision->filterData($ddat,$meeting['Meeting']['id']);
        }
        if(!is_array($tdat)){  //didn't find anything spectacular (ie: no decision). Save the minutes and get out of here
            $minutes=str_replace(array('{{','}}','((','))','[[',']]','###'),'',$this->data['Decision']['data']);
            $meeting['Meeting']['minutes']=$minutes;
            $this->Decision->Meeting->save($meeting);
            $this->redirect(array('controller'=>'meetings','action'=>'view','id'=>$meeting['Meeting']['id'],'committee'=>$dcommittee['Committee']['short_name']));
        }
        $tdat=$this->Decision->itemList($tdat,$dcommittee['Committee']['id']);
        $tdat=$this->Decision->userList($tdat,$dcommittee['Committee']['id']);
        $tdat=$this->Decision->groupList($tdat,$dcommittee['Committee']['id']);
        $this->set('decisions',$tdat);
        $this->set('meeting_id',$meeting['Meeting']['id']);
    }

    /**
     * Describe verify
     *
     * @param $committee
     * @return null
     */
    function verify($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(isset($this->params['meetingid'])){
            $meeting=$this->Decision->Meeting->read(null,$this->params['meetingid']);
            $this->set('meeting',$meeting);
        }
        if(!empty($this->data) && isset($this->data['Decision']['meeting_id'])){
            $meeting['id']=$this->data['Decision']['meeting_id'];
            $meeting['minutes']=$this->data['Decision']['data'];
            $this->Decision->Meeting->save($meeting);
        }
        elseif(isset($meeting)){
            $meeting['id']=$meeting['Meeting']['id'];
            $meeting['minutes']=$meeting['Meeting']['minutes'];
        }
        $comid=$this->Decision->Meeting->getCommitteeId($meeting['id']);
        $items=$this->Decision->Item->find('all',array('fields'=>array('id','short_name','name'),'conditions'=>array('committee_id'=>$comid)));
        $this->set('items',$items);
        $this->set('users',$this->Decision->User->getUsersPerCommitteeList($comid));
        $ddat=$this->Decision->extractText($meeting['minutes']);
        $tdat=$this->Decision->filterData($ddat,$meeting['id']);
        foreach($tdat as $did=>$ctdat){
            if(count($ctdat['Item'])){
                $itemids=Set::extract($tdat[$did]['Item'],'{n}.Item.id');
                foreach($items as $citem){
                    if(!in_array($citem['Item']['id'],$itemids)){
                        $tdat[$did]['Item'][]=$citem;
                    }
                }
            }
            else{
                $tdat[$did]['Item']=$items;
                $tdat[$did]['noitem']=true;
            }
        }
        $this->set('decisions',$tdat);
        $this->set('meeting_id',$meeting['id']);
    }

    /**
     * Describe addmany
     *
     * @param $committee
     * @return null
     */
    function addmany($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data) && isset($this->data['Decision']['meeting_id'])){
        }
        if(isset($this->params['meetingid'])){
            $this->set('meeting',$this->Decision->Meeting->read(null,$this->params['meetingid']));
        }
    }

    /**
     * Describe addminutes
     *
     * @param $committee
     * @return null
     */
    function addminutes($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data) && isset($this->data['Decision']['meeting_id'])){
        }
        if(isset($this->params['meetingid'])){
            $meeting=$this->Decision->Meeting->read(null,$this->params['meetingid']);
            if($this->Session->check('minute_data')){
                $meeting['Meeting']['minutes_raw']=$this->Session->read('minute_data');
            }
            elseif(strlen($meeting['Meeting']['minutes_raw'])==0){
                $meeting['Meeting']['minutes_raw']=$dcommittee['Committee']['minute_template'];
            }
            $this->set('meeting',$meeting);
        }
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Decision->create();
            $this->data['Decision']['committee_id']=$dcommittee['Committee']['id'];
            $lastnumber=$this->Decision->find('first',array(
                'conditions'=>array(
                    'Decision.meeting_id'=>$this->data['Decision']['meeting_id'],
                ),
                'order'=>array(
                    'Decision.ordering desc'
                ),
                'contain'=>false,
                'fields'=>array(
                    'ordering',
                ),
            ));
            $this->data['Decision']['ordering']=$lastnumber['Decision']['ordering']+1;
            if ($this->Decision->save($this->data)) {
                $this->Session->setFlash(__('The Decision has been saved', true));
                if(isset($this->data['Decision']['returnpage'])){
                    if(isset($this->data['Decision']['id'])){
                        $this->Decision=ClassRegistry::init('Decision','model');
                        $this->senddecision($this->data['Decision']['id'],$this->Decision->getLastInsertID());     
                    }
                    $this->redirect($this->data['Decision']['returnpage']);
                }
                else{
                    $this->redirect(array('committee'=>$dcommittee['Committee']['id'],'action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Decision could not be saved. Please, try again.', true));
            }
        }



        if(isset($this->params['meetingid'])){
            $this->set('meeting',$this->Decision->Meeting->read(null,$this->params['meetingid']));
        }

        if(isset($this->params['itemid'])){
            $this->set('item',$this->Decision->Item->read(null,$this->params['itemid']));
        }
        $this->set('items',$this->Decision->Item->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('meetings',$this->Decision->Meeting->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('groups',$this->Decision->Meeting->User->Group->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('users', $this->Decision->Meeting->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
        $this->set('returnpage',$this->referer(null,true));
    }


    /**
     * Create notifications when comments are made to the decision
     *
     * @param $decision_id 
     * @param $comment_id
     * @return null
     */
    function sendcomment($decision_id,$comment_id){
        $this->Decision->Behaviors->detach('Comment');
        $decision=$this->Decision->read(null,$decision_id);
        $this->Comment->bindModel(array(
            'belongsTo'=>array(
                'User',
            )
        ),false);
        $comment=$this->Comment->read(null,$comment_id);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Decision','foreign_key'=>$decision_id,'type'=>'decision comment')));
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$decision['Committee']['id'],'type'=>'decision comment')));
        }
        if($template){
            $decision['Comment']['comment']=$comment['Comment']['description'];
            $decision['Comment']['user']=$comment['User']['name'];
            $decision['Link']['decision']=array('committee'=>urlencode($decision['Committee']['short_name']),'controller'=>'decisions','action'=>'view','id'=>$decision_id);
            $template['Template']['template']=$this->Decision->replacetemplate($template['Template']['template'],$decision);
            $notification['Notification']['meeting_id']=$decision['Decision']['meeting_id'];
            $notification['Notification']['type']=$template['Template']['type'];
            $notification['Notification']['notification_date']=date("Y-m-d H:i:s");
            $notification['Notification']['message_title']=$template['Template']['title'];
            $users=$this->Decision->individualImplementors($decision_id);
            $groups=$this->Decision->groupImplementors($decision_id);
            foreach($groups as $group){
                $gusers=$this->User->Group->find('first',array('conditions'=>array('Group.id'=>$group)));
                foreach($gusers['User'] as $dguser){
                    if(!in_array($dguser['id'],$users)){
                        $users[]=$dguser['id'];
                    }
                }
            }
            foreach($users as $userid){
                $user=$this->Decision->Meeting->User->find('first',array('fields'=>array('name','email'),'conditions'=>array('User.id'=>$userid)));
                $data['name']=$user['User']['name'];
                $notification['Notification']['message']=$this->Decision->replacetemplate($template['Template']['template'],$data);
                $notification['Notification']['to']=$user['User']['email'];
                $this->Notification->create();
                $this->Notification->save($notification);
            }
        }
    }


    /**
     * Describe promote
     *
     * @param $committee
     * @param $meetingid
     * @param $id
     * @return null
     */
    function promote($committee,$meetingid=null,$id = null) {
        $this->Decision->promote($id);
        $this->redirect($this->referer(null,true));
    }

    /**
     * Describe demote
     *
     * @param $committee
     * @param $meetingid
     * @param $id
     * @return null
     */
    function demote($committee,$meetingid=null,$id = null) {
        $this->Decision->demote($id);
        $this->redirect($this->referer(null,true));
    }

    /**
     * Describe notifyusers
     *
     * @param $committee
     * @param $meetingid
     * @param $id
     * @return null
     */
    function announcedecision($committee,$meetingid=null,$id = null) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Decision->notifyuser($id);
        $this->Session->setFlash(__('Notifications of decision sent to users', true));
        $this->redirect($this->referer(null,true));
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $meetingid
     * @param $id
     * @return null
     */
    function edit($committee,$meetingid=null,$id = null) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Decision', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->Decision->curUser=$this->Auth->user('id');
            $this->data['Decision']['committee_id']=$dcommittee['Committee']['id'];
            if ($this->Decision->save($this->data)) {
                $this->Session->setFlash(__('The Decision has been saved', true));
                if(isset($this->data['Decision']['returnpage'])){
                    if(isset($this->data['DecisionComment']['Comment'])){
                        $this->Comment=ClassRegistry::init('Comment','model');
                        $this->sendcomment($this->data['Decision']['id'],$this->Comment->getLastInsertID());
                    }
                    $this->redirect($this->data['Decision']['returnpage']);
                }
                else{
                    $this->redirect(array('action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Decision could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Decision->read(null, $id);
            $meeting=$this->Decision->Meeting->read(null,$this->data['Decision']['meeting_id']);
            $item=$this->Decision->Item->read(null,$this->data['Decision']['item_id']);
        }
        $this->set('returnpage',$this->referer(null,true));
        $this->set('groups',$this->Decision->Meeting->User->Group->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('items',$this->Decision->Item->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('users', $this->Decision->Meeting->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
        $this->set(compact('meeting','item'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $itemid
     * @param $id
     * @return null
     */
    function delete($committee,$itemid = null,$id = null) {
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Decision', true));
        }
        $this->Decision->del($id);
        $this->Session->setFlash(__('Decision deleted', true));
        $this->redirect($this->referer(null,true));
    }

    function importfile($committee){
        $dcommittee=$this->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Session->write('minute_data','hello');
        $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'addminutes','meetingid'=>$this->params['meetingid']));
    }
}
?>
