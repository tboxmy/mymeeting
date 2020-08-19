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

class CommitteesController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Committees';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'Text','Javascript');
    /**
     * Define $uses
     *
     */
    var $uses = array('Committee','Systemtodo','Template','Announcement','Meeting','User');
    
    /**
     * Describe userroles
     *
     * @param $committee
     * @return null
     */
    function userroles($committee=null){
        $dcommittee=$this->Committee->findByShortName($committee);
        $id=$dcommittee['Committee']['id'];
        if(!$id){
            $this->Session->setFlash(__('The community does not exists'));
            $this->redirect(array('controller'=>'committees','action'=>'mainpage'));
        }
        $this->set('committeesUsers',$this->paginate('Membership','Committee.id='.$id));
    }

    /**
     * Describe index
     *
     * @return null
     */
    function index() {
        $this->Committee->recursive = 0;
        $this->set('committees', $this->paginate());
    }

    /**
     * Describe change
     *
     * @return null
     */
    function change() {
        if($_GET['committee']==-1){
            $this->Session->delete('CurCommittee');
        }
        else{
            $this->Session->write('CurCommittee',$_GET['committee']);
        }
        if(isset($_GET['alert'])){
            $this->redirect(array('action'=>'alert','controller'=>$_GET['cur_view']));
        }
        elseif(isset($_GET['addressbook'])){
            $this->redirect(array('action'=>'addressbook','controller'=>$_GET['cur_view']));
        }
        elseif(isset($_GET['userroles'])){
            $this->redirect(array('action'=>'userroles','controller'=>$_GET['cur_view']));
        }
        else{
            $this->redirect(array('controller'=>$_GET['cur_view']));
        }
    }

    /**
     * Describe committeeto
     *
     * @param $id
     * @return null
     */
    function committeeto($id = null) {
        if (!$id) {
            $this->redirect(array('action'=>'index'));
        }
        // get todos details
        $dtodo = $this->Committee->Todo->find('all',array('conditions'=>array('committee_id'=>$id)));
        $this->set('todo', $dtodo);
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Committee.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('committee', $this->Committee->read(null, $id));
    }

    /**
     * Describe add
     *
     * @return null
     */
    function add() {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $this->Committee->create();
            $this->data['Committee']['user_id']=$this->Auth->user('id');
            $this->data['Committee']['item_name']='Project';
            if ($this->Committee->save($this->data)) {
                $committee_id=$this->Committee->getLastInsertID();
                $todos=$this->Systemtodo->find('all',array('contain'=>false));
                foreach($todos as $todo){
                    $ctodo['name']=$todo['Systemtodo']['name'];
                    $ctodo['priority']=$todo['Systemtodo']['priority'];
                    $ctodo['committee_id']=$committee_id;
                    $ctodo['user_id']=$this->Auth->user('id');
                    $this->Committee->Todo->create();
                    $this->Committee->Todo->save($ctodo);
                }
                $templates=$this->Template->findAll(array('model'=>'System'));
                foreach($templates as $template){
                    $ctemplate['type']=$template['Template']['type'];
                    $ctemplate['title']=$template['Template']['title'];
                    $ctemplate['description']=$template['Template']['description'];
                    $ctemplate['template']=$template['Template']['template'];
                    $ctemplate['foreign_key']=$committee_id;
                    $ctemplate['model']='Committee';
                    $this->Template->create();
                    $this->Template->save($ctemplate);
                }
                $this->Session->setFlash(__('The Committee has been saved', true));
                $ddat['committee_id']=$committee_id;
                $ddat['user_id']=$this->Auth->user('id');
                $defaultrole=Configure::read('defaultrole');  //read in the default role set in mymeeting.php
                $defaultrole=$this->Committee->Membership->Role->findByName($defaultrole);
                if(!$defaultrole['Role']['id']) {  //what?? it's not set properly in mymeeting.php??? aaaah.. just get the first working id then
                    $defaultrole=$this->Committee->Membership->Role->find('first',array('field'=>'id','order'=>'id'));
                }
                $ddat['role_id']=$defaultrole['Role']['id'];
                $this->Committee->Membership->create();
                $this->Committee->Membership->save($ddat);
                $this->redirect(array('controller'=>'memberships','committee'=>$this->data['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The Committee could not be saved. Please, try again.', true));
            }
        }
    }

    /**
     * Describe edit
     *
     * @param $id
     * @return null
     */
    function edit($id = null) {
        
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Committee', true));
            $this->redirect(array('action'=>'mainpage'));
        }
        //debug($this->data);
        if (!empty($this->data)) {
            //if (empty($this->data['Committee']['parent_id'])) $this->data['Committee']['parent_id'] = 0;
            if ($this->Committee->save($this->data)) {
                $this->Session->setFlash(__('The Committee has been saved', true));
                $this->redirect(array('action'=>'mainpage'));
            } else {
                $this->Session->setFlash(__('The Committee could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            //$this->data = $this->Committee->read(null, $id);
            $this->data = $this->Committee->findByShortName($id);
            $mycommittees = $this->Committee->getCommittees($this->Auth->user('id'));  
            $this->set('mycommittees',$mycommittees);
        }
        $todos = $this->Committee->Todo->find('list');
        $users = $this->Committee->User->find('list');
        $users = $this->Committee->User->find('list');
        $this->set(compact('todos','users','users'));
        $dcommittee=$this->Committee->findByShortName($id);
        $this->set('dcommittee',$dcommittee);
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($committee) {
        $dcommittee=$this->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Committee->del($dcommittee['Committee']['id']);
        $this->Session->setFlash(__('Committee deleted', true));
        $this->redirect(array('controller'=>'committees','action'=>'mainpage'));
    }

    /**
     * Describe mainpage
     *
     * @return null
     */
    function mainpage(){
        $mycommittees = $this->Committee->getCommittees($this->Auth->user('id'),true);    
        
        foreach ($mycommittees as $key=>$com){
            if (strpos($key,'_details') === false) {
                // append permission on the committee
                $mycommittees[$key.'_details']['0']['edit_committee']=$this->checkAuthority('Committee',$this->Auth->user('id'),'edit',$key);
                $mycommittees[$key.'_details']['0']['delete_committee']=$this->checkAuthority('Committee',$this->Auth->user('id'),'delete',$key);
                $mycommittees[$key.'_details']['0']['view_wfmodels']=$this->checkAuthority('Wfmodel',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['view_announcements']=$this->checkAuthority('Announcement',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['view_groups']=$this->checkAuthority('Group',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['view_users']=$this->checkAuthority('Membership',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['view_templates']=$this->checkAuthority('Template',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['view_todos']=$this->checkAuthority('Committeetodo',$this->Auth->user('id'),'view',$key);
                $mycommittees[$key.'_details']['0']['add_committee']=$this->checkAuthority('Committee',$this->Auth->user('id'),'create',$key);
            } 
        } 
        $this->set('committees',$mycommittees);
        
        //if (!$this->haschangedpassword()) $this->changepassword();
    }
    
    /**
     * Describe alert
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function alert($committee,$id=null){
        $dcommittee=$this->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);

        //upcoming meetings
        $upcoming=$this->Committee->Meeting->findAll(array('committee_id'=>$dcommittee['Committee']['id'], 'meeting_date>=now()'));
        $this->set('upcoming',$upcoming);

        //upcoming status deadline

        $updatedDecision=$this->Committee->updatedDecision($dcommittee['Committee']['id'],$this->Auth->user('id'));

        $needupdating=$this->Committee->notUpdatedDecision($dcommittee['Committee']['id'],$this->Auth->user('id'));
        $needupdating=$this->Committee->Decision->find('all',array('conditions'=>array('Decision.id'=>Set::extract($needupdating,'{n}.Decision.id'))));

        $userstatus=$this->Committee->userDecision($dcommittee['Committee']['id'],$this->Auth->user('id'));

        $upcomingdeadline=$this->Committee->Meeting->Decision->findAll(array(
            'Decision.committee_id'=>$dcommittee['Committee']['id'],
            'Decision.deadline>=now()',
            'Decision.id'=>$userstatus
        ));
        $this->set('upcomingdeadline',$upcomingdeadline);
        $this->set('needupdating',$needupdating);

        $announcement=$this->Committee->Announcement->findAll(array('committee_id'=>$dcommittee['Committee']['id']));
        $this->set('announcement',$announcement);
        $users = $this->Committee->Announcement->User->find('list');
        $this->set(compact('users'));
    }


    /**
     * Describe search
     *
     * @return null
     */
    function search() {
        $dcommittee=$this->Committee->findByShortName($this->params['committee']);
        $this->set('dcommittee',$dcommittee);

        if (!empty($this->data)) {
            $data_users=$this->Committee->{$this->data['Search']['status']}($dcommittee['Committee']['id'],'User');
            $this->set('results',$data_users);
            $data_grp=$this->Committee->{$this->data['Search']['status']}($dcommittee['Committee']['id'],'Group');
            $this->set('results_grp',$data_grp);
            $this->set('cursearch',$this->data['Search']['status']);
        }
    }

    /**
     * Describe calendar
     *
     * @param $committee
     * @return null
     */
    function calendar(){
    }
    
    /**
     * Describe addsubcomm
     * Create sub committee under $committee_id
     *
     * @param $committee_id
     * @return null
     */
    function addsubcomm($committee_id) {
        
        $dcommittee=$this->Committee->findByShortName($this->params['committee']);
        $this->set('dcommittee',$dcommittee);
        
        if (!empty($this->data)) {
            $this->Committee->create();
            $this->data['Committee']['item_name']='Project';
            if ($this->Committee->save($this->data)) {
                $committee_id=$this->Committee->getLastInsertID();
                $this->Systemtodo->saveCommittee($committee_id);
                $this->Template->saveCommittee($committee_id);
                $this->Membership->saveCommittee($committee_id,$this->Auth->user('id'),Configure::read('defaultrole'));
                $this->Session->setFlash(__('The sub-committee has been saved', true));
                $this->redirect(array('controller'=>'memberships','committee'=>$this->data['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The sub-committee could not be saved. Please, try again.', true));
            }
        }
    }

}
?>
