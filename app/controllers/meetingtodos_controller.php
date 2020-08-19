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

class MeetingtodosController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Meetingtodos';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form');
    
/**
 * Describe index
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function index($committee,$id=null) {
        $this->Meetingtodo->recursive = 0;
        //$this->set('meetingsTodos', $this->paginate('Meetingtodo',array('meeting_id'=>$id)));
        
        // for use with workflow
        $this->Meetingtodo->curUser=$this->Auth->user('id');
        
        $todos=$this->Meetingtodo->find('all',array('conditions'=>array('meeting_id'=>$id)));
        $meeting = $this->Meetingtodo->Meeting->find('first',array('conditions'=>array('Meeting.id'=>$id),'contain'=>'Todo'));;
        $this->set(compact('todos','meeting'));
        
        $allow_add_meetingtodo = $this->checkAuthority('Meetingtodo',$this->Auth->user('id'),'create',$this->dcommittee['Committee']['id']);
        $this->set('allow_add_meetingtodo',$allow_add_meetingtodo); 
    }

/**
 * Describe view
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function view($committee,$id = null) {
        $dcommittee=$this->Meetingtodo->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Meetingtodo.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('meetingsTodo', $this->Meetingtodo->read(null, $id));
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set('priorities',$priorities);
    }

/**
 * Describe add
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function add($committee,$id) {
        
        if (!empty($this->data)) {
            $this->Meetingtodo->create();
            if ($this->Meetingtodo->save($this->data)) {
                $this->Session->setFlash(__('The Meetingtodo has been saved', true));
                $this->redirect(array('committee'=>$committee,'controller'=>'meetingtodos','action'=>'index','id'=>$this->data['Meetingtodo']['meeting_id']));
            } else {
                $this->Session->setFlash(__('The Meetingtodo could not be saved. Please, try again.', true));
            }
        }        
        $meetings = $this->Meetingtodo->Meeting->find('list',array('conditions'=>array('committee_id'=>$this->dcommittee['Committee']['id']),'contain'=>'Todo'));
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('meetings','priorities'));
        $this->set('meetingid',$id);
        $this->set('users', $this->Meetingtodo->User->getUsersPerCommitteeList($this->dcommittee['Committee']['id']));
        $this->set('returnpage',$this->referer(null,true));
    }

/**
 * Describe edit
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function edit($committee,$id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Meetingtodo', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Meetingtodo->save($this->data)) {
                $this->Session->setFlash(__('The Meetingtodo has been saved', true));
                if(isset($this->data['Meetingtodo']['returnpage'])){
                    $this->redirect($this->data['Meetingtodo']['returnpage']);
                }
                else{
                    $toret=$this->Meetingtodo->read(null,$id);
                    $this->redirect(array('committee'=>$committee,'controller'=>'meetings','action'=>'todo','id'=>$toret['Meetingtodo']['meeting_id']));
                }
            } else {
                $this->Session->setFlash(__('The Meetingtodo could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Meetingtodo->read(null, $id);
        }
        $meetings = $this->Meetingtodo->Meeting->find('list');
        $users = $this->Meetingtodo->User->find('list');
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('meetings','users','priorities'));
        $this->set('users', $this->Meetingtodo->User->getUsersPerCommitteeList($this->dcommittee['Committee']['id']));
        $this->set('returnpage',$this->referer(null,true));
    }

/**
 * Describe delete
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function delete($committee,$id = null) {
        if (!$id) {
            $this->Session->setFlash(__("Invalid id for Meeting's To-do", true));
            $this->redirect(array('committee'=>$committee,'controller'=>'meetingtodos','action'=>'index'));
        }
        $toret=$this->Meetingtodo->read(null,$id);
        $this->Meetingtodo->del($id);
        $this->Session->setFlash(__("Meeting's To-do deleted", true));
        $this->redirect(array('committee'=>$committee,'controller'=>'meetingtodos','action'=>'index','id'=>$toret['Meetingtodo']['meeting_id']));
    }

}
?>
