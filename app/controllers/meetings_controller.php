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

class MeetingsController extends AppController {


    /**
     * Define $name
     *
     */
    var $name = 'Meetings';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'DatePicker','Comment', 'Ajax', 'Javascript','MultiFile','Text');
    /**
     * Define $components
     *
     */
    var $components = array('RequestHandler', 'Email','MultiFile');
    /**
     * Define $uses
     *
     */
    var $uses = array('Meeting','Setting','Notification','Template','Todo','Decision','Group','Hash','Meetingtodo');


    var $paginate = array('order'=>array('Meeting.meeting_date'=>'desc'));

    /**
     * Define $_string_to_log_message
     *
     */
    var $_string_to_log_message = '';
    /**
     * Define $_string_to_log_to
     *
     */
    var $_string_to_log_to = '';

    /**
     * Describe report
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function report($committee,$id) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->layout='report';
        $decisions=$this->Meeting->Decision->findAll(array('meeting_id'=>$id));
        $meeting=$this->Meeting->read(null,$id);
        $report_title="Report for Meeting ".$this->
            $this->set(compact('report_title','decisions','meeting'));
    }

    /**
     * Describe editminutes
     *
     * @param $committee
     * @return null
     */
    function editminutes($committee) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data)){
            $this->Meeting->save($this->data);
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$this->data['Meeting']['id'],'controller'=>'meetings')); 
        }
        if (empty($this->data)) {
            $this->data = $this->Meeting->read(null, $this->params['meetingid']);
            $this->set('data',$this->data);
        }
    }

    /**
     * Describe announcedecisions
     *
     * @param $committee
     * @return null
     */
    function announcedecisions($committee) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(isset($this->params['meetingid'])){
            $decisions=$this->Meeting->Decision->find('all',array(
                'conditions'=>array(
                    'meeting_id'=>$this->params['meetingid'],
                ),
                'fields'=>array(
                    'id',
                ),
            ));
            foreach($decisions as $decision){
                $this->Decision->notifyuser($decision['Decision']['id']);
            }
            $this->Session->setFlash(__('Notifications of decisions sent to users', true));
            $this->redirect($this->referer(null,true));
        }
        else{
            $this->Session->setFlash(__('Invalid meeting id', true));
            $this->redirect($this->referer(null,true));
        }
    }

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Meeting->nextnumber($dcommittee['Committee']['id']);
        $this->Meeting->recursive = 1;
        $meetings=$this->paginate('Meeting',array('committee_id'=>$dcommittee['Committee']['id']));
        $meetings=$this->fixupauth($meetings,'Meeting',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('meetings',$meetings);
        if($this->checkAuthority('Meeting',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_meeting',true);
        if($this->checkAuthority('Meetingtodo',$this->Auth->user('id'),'view',$dcommittee['Committee']['id'],null)) $this->set('can_view_todo',true);
        if($this->checkAuthority('Attendance',$this->Auth->user('id'),'view',$dcommittee['Committee']['id'],null)) $this->set('can_view_attendance',true);
        $this->set('committee',$committee);
    }

    /**
     * Describe indexfollowup
     *
     * @param $committee
     * @param $meetingid
     * @return null
     */
    function indexfollowup($committee,$meetingid) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $meetingid=$this->Meeting->findById($meetingid);
        $this->set('meetingid',$meetingid);
        $this->Meeting->recursive = 1;
        $this->set('meetings',$this->paginate('Meeting',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id'] ,'parent_id'=>$meetingid['Meeting']['id']) )));
        $this->set('allow_add_meeting',true);
        $this->set('committee',$committee);
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Meeting.', true));
            $this->redirect(array('action'=>'index'));
        }
        $meeting=$this->Meeting->read(null,$id);
        $prev=$this->Meeting->find('first',array(
            'conditions'=>array(
                'Meeting.committee_id'=>$dcommittee['Committee']['id'],
                'Meeting.deleted=0',
                'Meeting.meeting_date<\''.$meeting['Meeting']['meeting_date'].'\'',
            ),
            'fields'=>array(
                'id',
                'meeting_num',
            ),
            'order'=>array(
                'Meeting.meeting_date'=>'desc'
            ),
        ));
        $next=$this->Meeting->find('first',array(
            'conditions'=>array(
                'Meeting.committee_id'=>$dcommittee['Committee']['id'],
                'Meeting.deleted=0',
                'Meeting.meeting_date>\''.$meeting['Meeting']['meeting_date'].'\'',
            ),
            'fields'=>array(
                'id',
                'meeting_num',
            ),
            'order'=>array(
                'Meeting.meeting_date'=>'asc'
            ),
        ));
        if($prev){
            $this->set('prev',$prev);
        }
        if($next){
            $this->set('next',$next);
        }
        $this->set('meeting', $meeting);
        if($this->checkAuthority('Decision',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_decision',true);

        // for search dropdowns
        $projects = $this->Meeting->Decision->Item->find('list',array('conditions'=>array('Item.committee_id'=>$dcommittee['Committee']['id']),'order'=>'Item.name ASC'));
        $groups = $this->Group->find('list',array('conditions'=>array('Group.committee_id'=>$dcommittee['Committee']['id']),'order'=>'Group.name ASC'));
        $users_tmp = $this->Committee->User->getUsersPerCommittee($dcommittee['Committee']['id']);
        foreach ($users_tmp as $key => $user) { 
            $users[$user['User']['id']] = $user['User']['name'];
        } 
        $this->set(compact('projects','groups','users'));

        $decision=$this->Meeting->Decision->find('all',array(
            'conditions'=>array(
                'Decision.meeting_id'=>$id,
            ),
            'order'=>array(
                'Decision.ordering asc',
            )
        )); 

        if (!empty($this->data['Search']['item']) || !empty($this->data['Search']['group']) || !empty($this->data['Search']['user'])) {

            $final_decisions=array();
            $decision_ids=Set::extract($decision,'{n}.Decision.id');

            if(!empty($this->data['Search']['item'])){
                //get and combine the decision ids that fit the item description
                $final_decisions=am($final_decisions,Set::extract($this->Meeting->Decision->find('all',array(
                    'conditions'=>array(
                        'item_id'=>$this->data['Search']['item'],
                        'Decision.id'=>$decision_ids,
                    ),
                    'fields'=>array(
                        'id',
                    ),
                )),'{n}.Decision.id'));
            }

            if(!empty($this->data['Search']['group'])){
                //get and combine the decision ids that fit the group description
                $final_decisions=am($final_decisions,Set::extract($this->Meeting->Decision->DecisionsGroup->find('all',array(
                    'conditions'=>array(
                        'group_id'=>$this->data['Search']['group'],
                        'decision_id'=>$decision_ids,
                    ),
                    'fields'=>array(
                        'decision_id',
                    ),
                )),'{n}.DecisionsGroup.decision_id'));
            }

            if(!empty($this->data['Search']['user'])){
                //get and combine the decision ids that fit the user description
                $final_decisions=am($final_decisions,Set::extract($this->Meeting->Decision->DecisionsUser->find('all',array(
                    'conditions'=>array(
                        'user_id'=>$this->data['Search']['user'],
                        'decision_id'=>$decision_ids,
                    ),
                    'fields'=>array(
                        'decision_id',
                    ),
                )),'{n}.DecisionsUser.decision_id'));
            }
            //find all the decisions with ids that was found before this
            $decision=$this->Meeting->Decision->find('all',array(
                'conditions'=>array(
                    'Decision.id'=>$final_decisions,
                ),
                'order'=>array(
                    'Decision.ordering asc',
                )
            )); 
        }
        $this->set('decisions',$decision);

        if($this->checkAuthority('Meetingtodos',$this->Auth->user('id'),'view',$dcommittee['Committee']['id'],null)) $this->set('can_view_todo',true);
        if($this->checkAuthority('Attendance',$this->Auth->user('id'),'view',$dcommittee['Committee']['id'],null)) $this->set('can_view_attendance',true);

        /* Check whether the user is allowed to add new decision */
        if($this->Meeting->Decision->isAuthorized($this->Auth->user('id'),'create',$this->Meeting->getCommitteeId($id))){
            $this->set('allow_add_decision',true);
        }
    }


    /**
     * Describe preview
     *
     * @param $committee
     * @return null
     */
    function preview($committee) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
    }

    /**
     * Describe edit_invitation
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit_invitation($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data)) {
            $this->Template->save($this->data);
            $meetingdata['id']=$id;
            $meetingdata['invite_date']=strlen($this->data['Template']['invite_date'])?$this->data['Template']['invite_date']:null;
            $this->Meeting->save($meetingdata);
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'invite','id'=>$this->data['Meeting']['id']));
        }
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'invite')));
        }
        if($template){
            $this->set('template_type','invite');
            $this->set('template',$template);
            $this->set('meeting',$meeting);
        }
        $this->render("edit_template");
    }

    /**
     * Describe edit_cancelation
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit_cancelation($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if(!empty($this->data)) {
            $this->Template->save($this->data);
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'cancel','id'=>$this->data['Meeting']['id']));
        }
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'cancel')));
        $this->Meeting->Behaviors->detach('SoftDeletable');
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'cancel')));
        }
        if($template){
            $this->set('template_type','cancel');
            $this->set('template',$template);
            $this->set('meeting',$meeting);
        }
        $this->render("edit_template");
    }

    /**
     * Describe invite
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function invite($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'invite')));
        }
        if($template){
            $meeting['Link']['meeting']=array('committee'=>urlencode($dcommittee['Committee']['short_name']),'controller'=>'meetings','action'=>'view','id'=>$id);
            $meeting['Link']['confirm']='/hash/%hash';
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);
            $this->set('template',$template);
            $this->set('meeting',$meeting);
        }
    }

    /**
     * Describe cancel
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function cancel($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'cancel')));
        $this->Meeting->Behaviors->detach('SoftDeletable');
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'cancel')));
        }
        if($template){
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);
            $this->set('template',$template);
            $this->set('meeting',$meeting);
        }
    }

    /**
     * Describe send_emails
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function send_emails($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $meeting=$this->Meeting->read(null,$id);
        $prev_meeting=$this->Session->read('prev_meeting');
        $meeting['OldMeeting']=$prev_meeting['Meeting'];
        for($i=0;$i<3;$i++){
            switch($i){
            case 0:   //send invitation
                $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
                $users=$this->Meeting->User->find('all',array('conditions'=>array('User.id'=>array_values($this->Session->read('to_invite')))));
                $this->Session->del('to_invite');
                break;
            case 1:   //send change notification
                $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'change')));
                $users=$this->Meeting->User->find('all',array('conditions'=>array('User.id'=>array_values($this->Session->read('to_notify_changes')))));
                $this->Session->del('to_notify_changes');
                break;
            case 2:   //send uninvite 

                $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'uninvite')));
                $users=$this->Meeting->User->find('all',array('conditions'=>array('User.id'=>array_values($this->Session->read('to_uninvite')))));
                $this->Session->del('to_uninvite');
                break;
            }
            $meeting['Link']['meeting']=array('committee'=>urlencode($dcommittee['Committee']['short_name']),'controller'=>'meetings','action'=>'view','id'=>$id);
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);
            $this->set('template',$template);
            $this->set('meeting',$meeting);
            $notification['meeting_id']=$id;
            $notification['type']=$template['Template']['type'];
            if($meeting['Meeting']['invite_date']){
                $notification['notification_date']=date("Y-m-d H:i:s",strtotime($meeting['Meeting']['invite_date'].' 07:30:00'));
            }
            else{
                $notification['notification_date']=date("Y-m-d H:i:s");
            }
            $notification['message_title']=$template['Template']['title'];
            foreach($users as $user){
                $this->Meeting->Notification->create();
                $data['name']=$user['User']['name'];
                $notification['message']=$this->Meeting->replacetemplate($template['Template']['template'],$data);
                $notification['to']=$user['User']['email'];
                $this->Meeting->Notification->save($notification);
            }
        }
        $this->Session->setFlash(__('Emails set to send',true));
        $this->redirect(array('committee'=>$committee,'action'=>'index'));
    }

    /**
     * Describe send_invite
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function send_invite($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'invite')));
        }
        if($template){
            $meeting['Link']['meeting']=array('committee'=>urlencode($dcommittee['Committee']['short_name']),'controller'=>'meetings','action'=>'view','id'=>$id);
            $meeting['Link']['confirm']='/hash/%hash';
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);

            $notification['meeting_id']=$id;
            $notification['type']=$template['Template']['type'];
            if($meeting['Meeting']['invite_date']){
                $notification['notification_date']=date("Y-m-d H:i:s",strtotime($meeting['Meeting']['invite_date'].' 07:30:00'));
            }
            else{
                $notification['notification_date']=date("Y-m-d H:i:s");
            }
            $notification['message_title']=$template['Template']['title'];
            foreach($meeting['User'] as $user){
                $att = $this->Meeting->Attendance->find('first',array('conditions'=>array('meeting_id'=>$meeting['Meeting']['id'],'user_id'=>$user['id'])));
                $hash = $this->Hash->find('all',array('conditions'=>array('model'=>'Attendance','foreign_key'=>$att['Attendance']['id'],'hash_type'=>'confirm'),'fields'=>array('hash')));
                $title = $this->Meeting->Attendance->User->Title->find('first',array('conditions'=>array('Title.id'=>$user['title_id'])));
                $this->Meeting->Notification->create();
                $data['name']=$title['Title']['short_name'].' '.$user['name'];
                count($hash) ? $data['hash']= $hash[0]['Hash']['hash'] : $data['hash']='';
                $notification['message']=$this->Meeting->replacetemplate($template['Template']['template'],$data);
                $notification['to']=$user['email'];
                $this->Meeting->Notification->save($notification);
                //debug($notification);
            }
            $this->Session->setFlash(__('The invitations has been sent', true));
        }
        $this->redirect(array('committee'=>$committee,'action'=>'index'));
    }

    /**
     * Describe send_cancel
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function send_cancel($committee,$id){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'cancel')));
        $this->Meeting->Behaviors->detach('SoftDeletable');
        $this->Meeting->Attendance->Behaviors->detach('SoftDeletable');
        $meeting=$this->Meeting->read(null,$id);
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'cancel')));
        }
        if($template){
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);
            $this->set('template',$template);
            $this->set('meeting',$meeting);
            $notification['meeting_id']=$id;
            $notification['type']=$template['Template']['type'];
            $notification['notification_date']=date("Y-m-d H:i:s");
            $notification['message_title']=$template['Template']['title'];
            foreach($meeting['User'] as $user){
                $this->Meeting->Notification->create();
                $data['name']=$user['name'];
                $notification['message']=$this->Meeting->replacetemplate($template['Template']['template'],$data);
                $notification['to']=$user['email'];
                $this->Meeting->Notification->save($notification);
            }
            $this->Session->setFlash(__('The cancelations has been sent', true));
        }
        $this->redirect(array('committee'=>$committee,'action'=>'index'));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        
        if (!empty($this->data)) {
            $this->Meeting->create();
            if (isset($this->data['Meeting']['sendnow'])) $this->data['Meeting']['invite_date'] = date('Y-m-d');
            $this->data['Session']['user_id']=$this->Auth->user('id');

            if ($this->Meeting->save($this->data)) {
                $meeting_id=$this->Meeting->getLastInsertID();

                // save data inside hash table for attendance confirmation
                $attendance = $this->Meeting->Attendance->findAllByMeetingId($meeting_id); 
                $this->Hash->insertToHashTable('confirm',$attendance);

                $todos=$this->Meeting->Committee->Todo->findAll(array('committee_id'=>$this->dcommittee['Committee']['id']));
                foreach($todos as $todo){
                    $ctodo['name']=$todo['Todo']['name'];
                    $ctodo['priority']=$todo['Todo']['priority'];
                    $ctodo['user_id']=$this->Auth->user('id');
                    $ctodo['meeting_id']=$meeting_id;
                    $this->Meeting->Todo->create();
                    $this->Meeting->Todo->save($ctodo);
                } 

                $templates=$this->Template->findAll(array('foreign_key'=>$this->dcommittee['Committee']['id'],'model'=>'Committee'));
                foreach($templates as $template){
                    $ctemplate['type']=$template['Template']['type'];
                    $ctemplate['title']=$template['Template']['title'];
                    $ctemplate['description']=$template['Template']['description'];
                    $ctemplate['template']=$template['Template']['template'];
                    $ctemplate['foreign_key']=$meeting_id;
                    $ctemplate['model']='Meeting';
                    $this->Template->create();
                    $this->Template->save($ctemplate);
                }
                $this->Session->setFlash(__('The Meeting has been saved', true));
                $this->redirect(array('committee'=>$this->dcommittee['Committee']['short_name'],'action'=>'invite','id'=>$meeting_id));
            } else {
                $this->Session->setFlash(__('The Meeting could not be saved. Please, try again.', true));
            }
        }
        $this->set('groups',$this->Meeting->Attendance->User->Group->find('list',array('conditions'=>array('committee_id'=>$this->dcommittee['Committee']['id']))));
        $this->set('users', $this->Meeting->Attendance->User->getUsersPerCommitteeList($this->dcommittee['Committee']['id']));
        $this->set('nextnum',$this->Meeting->nextnumber($this->dcommittee['Committee']['id']));
        $this->set('defaulttitle',$this->Meeting->meetingtitle($this->dcommittee['Committee']['id']));
    }

    //add follow-up meeting

    /**
     * Describe addfollowup
     *
     * @param $committee
     * @param $meetingid
     * @return null
     */
    function addfollowup($committee, $meetingid){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $meetingid=$this->Meeting->findById($meetingid);
        $this->set('meetingid',$meetingid);

        if (!empty($this->data)) {

            $this->Meeting->create();
            if (isset($this->data['Meeting']['sendnow'])) $this->data['Meeting']['invite_date'] = date('Y-m-d');
            $this->data['Session']['user_id']=$this->Auth->user('id');
            if ($this->Meeting->save($this->data)) {
                $meeting_id=$this->Meeting->getLastInsertID();
                $todos=$this->Meeting->Committee->Todo->findAll(array('committee_id'=>$dcommittee['Committee']['id']));
                foreach($todos as $todo){
                    $ctodo['name']=$todo['Todo']['name'];
                    $ctodo['priority']=$todo['Todo']['priority'];
                    $ctodo['meeting_id']=$meeting_id;
                    $this->Meeting->Todo->create();
                    $this->Meeting->Todo->save($ctodo);
                }   
                $this->Session->setFlash(__('The Meeting has been saved', true));


                $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'meetingid'=>$meetingid['Meeting']['id'],'action'=>'indexfollowup'));
            } else {
                $this->Session->setFlash(__('The Meeting could not be saved. Please, try again.', true));
            }
        }

        $this->set('groups',$this->Meeting->User->Group->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('users', $this->Meeting->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
    }

    /**
     * Describe summary
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function summary($committee,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Meeting.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('meeting', $this->Meeting->read(null, $id));
        $decision=$this->Meeting->Decision->find('all',array('conditions'=>array('Decision.meeting_id'=>$id)));
        $this->set('decisions',$decision);

        $this->render('summary','popup');
    }

    /**
     * Describe minutes
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function minutes($committee,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Meeting.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('meeting', $this->Meeting->read(null, $id));
        $decision=$this->Meeting->Decision->find('all',array('conditions'=>array('Decision.meeting_id'=>$id)));
        $this->set('decision',$decision); 
        $attended = $this->Meeting->User->Attendance->findAll(array('meeting_id'=>$id,'attended'=>1));
        $this->set('attended', $attended);
        $this->set('titles',$this->Meeting->User->Title->find('list'));
        $notattended = $this->Meeting->User->Attendance->findAll(array('meeting_id'=>$id,'attended'=>0));
        $this->set('notattended', $notattended);
        $this->render('minutes','popup');
    }

    /**
     * Describe previewemails
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function previewemails($committee,$id) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $invite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
        $change=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'change')));
        $uninvite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'uninvite')));
        $meeting=$this->Meeting->read(null,$id);
        if(isset($this->data)){
            $template['template']=$this->data['Template']['invite'];
            $template['id']=$invite['Template']['id'];
            $this->Template->save($template);
            $template['template']=$this->data['Template']['change'];
            $template['id']=$change['Template']['id'];
            $this->Template->save($template);
            $template['template']=$this->data['Template']['uninvite'];
            $template['id']=$uninvite['Template']['id'];
            $this->Template->save($template);
            if(Validation::date($this->data['Template']['invite_date'])){
                $this->data['Meeting']['invite_date']=$this->data['Template']['invite_date'];
                $this->Meeting->save($this->data);
                $meeting=$this->Meeting->read(null,$id);
            }
            $invite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
            $change=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'change')));
            $uninvite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'uninvite')));
        }
        $to_invite=$this->Session->read('to_invite');
        $to_uninvite=$this->Session->read('to_uninvite');
        $to_notify_changes=$this->Session->read('to_notify_changes');
        $this->set('to_invite',$to_invite);
        $this->set('to_uninvite',$to_uninvite);
        $this->set('to_notify_changes',$to_notify_changes);
        $meeting['Link']['meeting']=array('committee'=>urlencode($dcommittee['Committee']['short_name']),'controller'=>'meetings','action'=>'view','id'=>$id);
        $invite['Template']['template']=$this->Meeting->replacetemplate($invite['Template']['template'],$meeting);
        $prev_meeting=$this->Session->read('prev_meeting');
        $meeting['OldMeeting']=$prev_meeting['Meeting'];
        $change['Template']['template']=$this->Meeting->replacetemplate($change['Template']['template'],$meeting);
        $uninvite['Template']['template']=$this->Meeting->replacetemplate($uninvite['Template']['template'],$meeting);
        $this->set('invite',$invite);
        $this->set('change',$change);
        $this->set('uninvite',$uninvite);
        $this->set('meeting',$meeting);
    }

    /**
     * Describe editemails
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function editemails($committee=null,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $meeting=$this->Meeting->read(null,$id);
        $invite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'invite')));
        $change=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'change')));
        $uninvite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$id,'type'=>'uninvite')));
        $this->set('invite',$invite);
        $this->set('change',$change);
        $this->set('uninvite',$uninvite);
        $this->set('meeting',$meeting);
    }

    /**
     * Create notifications when comments are made
     *
     * @param $meeting_id 
     * @param $comment_id
     * @return null
     */
    function sendcomment($meeting_id,$comment_id){
        $this->Meeting->bindModel(array(
            'hasAndBelongsToMany'=>array(
                'User'=>array('with'=>'Attendance'),
            )
        ),false);
        $meeting=$this->Meeting->read(null,$meeting_id);
        $this->Comment->bindModel(array(
            'belongsTo'=>array(
                'User',
            )
        ),false);
        $comment=$this->Comment->read(null,$comment_id);
        $dcommittee=$this->Meeting->Committee->findById($meeting['Meeting']['committee_id']);
        $this->set('dcommittee',$dcommittee);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$meeting_id,'type'=>'meeting comment')));
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$meeting['Committee']['id'],'type'=>'meeting comment')));
        }
        if($template){
            $meeting['Comment']['comment']=$comment['Comment']['description'];
            $meeting['Comment']['user']=$comment['User']['name'];
            $meeting['Link']['meeting']=array('committee'=>urlencode($dcommittee['Committee']['short_name']),'controller'=>'meetings','action'=>'view','id'=>$meeting_id);
            $template['Template']['template']=$this->Meeting->replacetemplate($template['Template']['template'],$meeting);
            $notification['meeting_id']=$meeting_id;
            $notification['type']=$template['Template']['type'];
            $notification['notification_date']=date("Y-m-d H:i:s");
            $notification['message_title']=$template['Template']['title'];
            foreach($meeting['User'] as $user){
                $this->Meeting->Notification->create();
                $data['name']=$user['name'];
                $notification['message']=$this->Meeting->replacetemplate($template['Template']['template'],$data);
                $notification['to']=$user['email'];
                $this->Meeting->Notification->save($notification);
            }
        }
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee=null,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Meeting', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $prev_invited_users = Set::extract($this->Meeting->Attendance->find('all',array('conditions'=>array('meeting_id'=>$this->data['Meeting']['id']))),'{n}.User.id');
            $this->data['Session']['user_id']=$this->Auth->user('id');
            $prev_meeting=$this->Meeting->read(null,$this->data['Meeting']['id']);
            $this->Session->write('prev_meeting',$prev_meeting);
            $this->Meeting->unbindModel(array('hasAndBelongsToMany'=>array('User')),false);
            
            if ($this->Meeting->save($this->data)) { 
                // save attendance + hash
                $users=$this->Meeting->Attendance->find('all',array('conditions'=>array('meeting_id'=>$id,'Attendance.deleted'=>'0'),'fields'=>'User.*'));
                $old = array();
                foreach ($users as $user) array_push($old, $user['User']['id']);
                $new = array();
                if(!isset($this->data['User'])){ // if none of the user is invited
                    $invite = false;
                } else{
                    $invite=true;
                    foreach ($this->data['User']['User'] as $val) if ($val) array_push($new, $val);
                    if(is_array($new) && !count(array_diff($old,$new)) && !count(array_diff($new,$old))) // no change on list of invitees
                        $invite=false;
                }
                $this->Meeting->Attendance->saveInvitees($id,$old,$new); 
                
                
                if(isset($this->data['Meeting']['returnpage'])){
                    if(isset($this->data['MeetingComment']['Comment'])){
                        $this->Comment=ClassRegistry::init('Comment','model');
                        $this->sendcomment($this->data['Meeting']['id'],$this->Comment->getLastInsertID());
                    }
                    $this->redirect($this->data['Meeting']['returnpage']);
                }
                if($invite){
                    $this->Meeting->Notification->deleteAll(array('meeting_id'=>$this->data['Meeting']['id'],'notification_sent'=>0));
                    if(!$this->Meeting->Notification->find('count',array('conditions'=>array('meeting_id'=>$this->data['Meeting']['id'],'notification_sent'=>1)))){  //notification has never been sent
                        $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'invite','id'=>$this->data['Meeting']['id']));
                    }
                    else{ //notification has been sent already so please send changes
                        $new_invited_users = Set::extract($this->Meeting->Attendance->find('all',array('conditions'=>array('meeting_id'=>$this->data['Meeting']['id']))),'{n}.User.id');
                        $to_invite = array_diff($new_invited_users, $prev_invited_users);
                        $to_uninvite = array_diff($prev_invited_users, $new_invited_users);
                        $to_notify_changes = array_intersect($prev_invited_users, $new_invited_users);
                        $this->Session->write('to_invite',$to_invite);
                        $this->Session->write('to_uninvite',$to_uninvite);
                        $this->Session->write('to_notify_changes',$to_notify_changes);
                        $appendflash = '';
                        $this->Session->setFlash(__('The Meeting has been saved', true).$appendflash);
                        $this->set('to_invite',$to_invite);
                        $this->set('to_uninvite',$to_uninvite);
                        $this->set('to_notify_changes',$to_notify_changes);
                        $invite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$this->data['Meeting']['id'],'type'=>'invite')));
                        $change=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$this->data['Meeting']['id'],'type'=>'change')));
                        $uninvite=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$this->data['Meeting']['id'],'type'=>'uninvite')));
                        $meeting=$this->Meeting->read(null,$this->data['Meeting']['id']);
                        $invite['Template']['template']=$this->Meeting->replacetemplate($invite['Template']['template'],$meeting);
                        $meeting['OldMeeting']=$prev_meeting['Meeting'];
                        $change['Template']['template']=$this->Meeting->replacetemplate($change['Template']['template'],$meeting);
                        $uninvite['Template']['template']=$this->Meeting->replacetemplate($uninvite['Template']['template'],$meeting);
                        $this->set('invite',$invite);
                        $this->set('change',$change);
                        $this->set('uninvite',$uninvite);
                        $this->set('meeting',$meeting);
                        $this->render('previewemails');
                    }
                }
                else{
                    $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'index'));
                }
            }
            else {
                $this->Session->setFlash(__('The Meeting could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Meeting->read(null, $id);
            $this->set('data',$this->data);
        }
        $users = $this->Meeting->Attendance->User->getUsersPerCommitteeList($dcommittee['Committee']['id']);
        $users2 = $this->Meeting->Attendance->find('all',array('conditions'=>array('meeting_id'=>$id,'Attendance.deleted'=>array(0,1)),'fields'=>'Attendance.*'));
        $this->set('groups',$this->Meeting->Attendance->User->Group->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set(compact('users'));
        $this->set(compact('users2'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);

        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Meeting', true));
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'index'));
        }
        $this->Meeting->unbindModel(array('hasAndBelongsToMany'=>array('User')),false);
        $this->Meeting->del($id);
        $this->Session->setFlash(__('Meeting deleted', true));
        $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'cancel','id'=>$id));
    }


    /////////////////////// ajax functions ///////////////////////

    /**
     * Describe getvenue
     *
     * @return null
     */
    function getvenue() {
        Configure::write('debug', 0); // dont want debug in ajax returned html
        if ($this->RequestHandler->isAjax()) {
            $this->Meeting->recursive=-1;
            $ddat=$this->Meeting->findDistinct(array('venue'=>'LIKE %B%'),'venue');
            $this->set('ddat',$ddat);
            $this->render('getvenue','ajax');
        }
    }


    /**
     * Describe attendance
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function attendance($committee=null,$id = null) { 
        $dcommittee=$this->Meeting->Committee->findByShortName($committee); 
        $this->set('dcommittee',$dcommittee); 
        if (!$id && empty($this->data)) { 
            $this->Session->setFlash(__('Invalid Meeting', true)); 
            $this->redirect(array('committee'=>$dcommittee['Committee']['id'],'action'=>'index')); 
        } 
        if($this->data){ 
            $this->Meeting->Attendance->saveData($this->data);
        } 

        // get invite list for this meeting 
        $invitees = $this->Meeting->Attendance->find('all',array('conditions'=>array('meeting_id'=>$id),'order'=>'User.name ASC')); 
        $this->set('invitees', $invitees); 

        // get meeting details 
        $this->set('meeting', $this->Meeting->read(null, $id)); 
    } 
}
?>
