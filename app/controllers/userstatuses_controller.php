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

class UserstatusesController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Userstatuses';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'DatePicker','Comment','MultiFile');
    /**
     * Define $components
     *
     */
    var $components = array('MultiFile','RequestHandler');
    /**
     * Define $uses
     *
     */
    var $uses = array ('Notification','Comment','Template','Userstatus','Attachment');

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Userstatus->recursive = 0;
        $this->set('userstatuses', $this->paginate());
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Status.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('userstatuses', $this->Userstatus->read(null, $id));
        $this->data=$this->Userstatus->read(null,$id);
    }

    /**
     * Describe add
     *
     * @param $committee
     * @param $decision_id
     * @return null
     */
    function add($committee,$decision_id=null) { 
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Userstatus->create();
            $this->data['Userstatus']['updater']=$this->Auth->user('id');
            $this->data['Userstatus']['committee_id']=$dcommittee['Committee']['id'];
            if ($this->Userstatus->save($this->data)) {
                $this->Session->setFlash(__('The Status has been saved', true));
                if(isset($this->data['Userstatus']['returnpage'])){
                    $this->redirect($this->data['Userstatus']['returnpage'].'#user'.$this->Userstatus->getLastInsertID());
                }
                else{
                    $this->redirect(array('committee'=>$committee,'decisionid'=>$this->data['Userstatus']['decision_id'],'action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Status could not be saved. Please, try again.', true));
            }
        }
        if($decision_id){
            $this->set('decision',$this->Userstatus->Decision->read(null,$decision_id));
            $oldstatus=$this->Userstatus->find('first',array(
                'conditions'=>array(
                    'decision_id'=>$decision_id,
                    'user_id'=>$this->params['group_id'],
                    'Userstatus.deleted'=>0,
                ),
                'order'=>array(
                    'Userstatus.updated desc',
                ),
            ));
            $this->set('oldstatus',$oldstatus);
            $this->data = $this->Userstatus->read(null, $oldstatus['Userstatus']['id']);
        }
        $this->set('returnpage',$this->referer(null,true));
        
        $decision = $this->Userstatus->Decision->find('first',array(
            'conditions'=>array('Decision.id'=>$this->params['decisionid']),
            'order'=>'Decision.created DESC'
            ));
        $this->set('decision',$decision);
    }

    /**
     * Create notifications when comments are made to the status
     *
     * @param $status_id 
     * @param $comment_id
     * @return null
     */
    function sendcomment($status_id,$comment_id){
        $this->Userstatus->Behaviors->detach('Comment');
        $status=$this->Userstatus->read(null,$status_id);
        $this->Comment->bindModel(array(
            'belongsTo'=>array(
                'User',
            )
        ),false);
        $comment=$this->Comment->read(null,$comment_id);
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Userstatus','foreign_key'=>$status_id,'type'=>'status comment')));
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$status['Committee']['id'],'type'=>'status comment')));
        }
        if($template){
            $status['Comment']['comment']=$comment['Comment']['description'];
            $status['Comment']['user']=$comment['User']['name'];
            $status['Link']['decision']=array('committee'=>urlencode($status['Committee']['short_name']),'controller'=>'decisions','action'=>'view','id'=>$status['Userstatus']['decision_id']);
            $status['Status']=$status['Userstatus'];
            $this->Userstatus->Decision->Meeting->Behaviors->detach('Comment');
            $status=am($status,$this->Userstatus->Decision->Meeting->find('first',array('contain'=>false,'conditions'=>array('id'=>$status['Decision']['meeting_id']))));
            $template['Template']['template']=$this->Userstatus->replacetemplate($template['Template']['template'],$status);
            $notification['Notification']['meeting_id']=$status['Decision']['meeting_id'];
            $notification['Notification']['type']=$template['Template']['type'];
            $notification['Notification']['notification_date']=date("Y-m-d H:i:s");
            $notification['Notification']['message_title']=$template['Template']['title'];
            $data['name']=$status['User']['name'];
            $notification['Notification']['message']=$this->Userstatus->replacetemplate($template['Template']['template'],$data);
            $notification['Notification']['to']=$status['User']['email'];
            $this->Notification->create();
            $this->Notification->save($notification);
        }
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee,$id = null) {
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Status', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->data['Userstatus']['committee_id']=$dcommittee['Committee']['id'];
            $this->Userstatus->curUser=$this->Auth->user('id');
            if ($this->Userstatus->save($this->data)) {
                if(!isset($this->data['Userstatus']['id'])){
                    $newid=$this->Userstatus->getLastInsertID();
                    $oldstatus=$this->Userstatus->find('first',array(
                        'conditions'=>array(
                            'decision_id'=>$this->data['Userstatus']['decision_id'],
                            'user_id'=>$this->data['Userstatus']['user_id'],
                            'Userstatus.deleted'=>0,
                            'Userstatus.id<'.$newid,
                        ),
                        'order'=>array(
                            'Userstatus.updated desc',
                        ),
                    ));
                    $attachments=$this->Attachment->find('all',array(
                        'conditions'=>array(
                            'foreign_key'=>$oldstatus['Userstatus']['id'],
                            'model'=>'Userstatus',
                        ),
                    ));
                    foreach($attachments as $attachment){
                        $attachment['Attachment']['foreign_key']=$newid;
                        $this->Attachment->save($attachment);
                    }
                }
                else{
                    $newid=$this->data['Userstatus']['id'];
                }
                $this->Session->setFlash(__('The Status has been saved', true));
                if(isset($this->data['Userstatus']['returnpage'])){
                    if(isset($this->data['UserstatusComment']['Comment'])){
                        $this->Comment=ClassRegistry::init('Comment','model');
                        $this->sendcomment($this->data['Userstatus']['id'],$this->Comment->getLastInsertID());
                    }
                    $this->redirect($this->data['Userstatus']['returnpage'].'#user'.$newid);
                }
                else{
                    $this->redirect(array('action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Status could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Userstatus->read(null, $id);
        }
        $decisions = $this->Userstatus->Decision->find('list');
        $users = $this->Userstatus->User->find('list');
        $this->set(compact('decisions','users'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Status', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Userstatus->del($id);
        $this->Session->setFlash(__('Status deleted', true));
        $this->redirect(array('action'=>'index'));
    }
    
    function view_history($committee,$decisionid = null,$id=null) {
        
        $dcommittee=$this->Userstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);

        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout="popup";
        
        $statuses = $this->Userstatus->find('all',array('conditions'=>array('Committee.id'=>$dcommittee['Committee']['id'],'Decision.id'=>$decisionid,'User.id'=>$id),'order'=>'Userstatus.created DESC'));
        
        foreach($statuses as $sid=>$status){
            $comment=$this->Comment->find('all',array('conditions'=>array('model'=>'Userstatus','foreign_key'=>$status['Userstatus']['id']),'order'=>'updated desc'));
            
            if(count($comment)){
                foreach($comment as $cid=>$curcomment){
                    $users=$this->Userstatus->User->find('first',array('fields'=>array('name','job_title'),'conditions'=>array('User.id'=>$curcomment['Comment']['user_id'])));
                    $comment[$cid]['Comment']['user_name']=$users['User']['name'];
                    $comment[$cid]['Comment']['job_title']=$users['User']['job_title'];
                }
                $statuses[$sid]['Userstatus']['UserstatusComment']=$comment;
            }
        }
        $this->set('statuses',$statuses);
    }
}
?>
