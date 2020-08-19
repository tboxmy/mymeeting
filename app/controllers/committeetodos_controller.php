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

class CommitteetodosController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Committeetodos';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form');
    /**
     * Define $priorities
     *
     */
    var $priorities = array('1'=>'Immediate', '2'=>'Urgent', '3'=>'High', '4'=>'Normal', '5'=>'Low', '6'=>'None');


    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Committeetodo->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Committeetodo->recursive = 0;
        //$this->set('committeesTodos', $this->paginate('Committeetodo',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $committeestodo=$this->paginate('Committeetodo',array('committee_id'=>$dcommittee['Committee']['id']));
        $committeestodo=$this->fixupauth($committeestodo,'Committeetodo',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('committeesTodos', $committeestodo);
        if($this->checkAuthority('Committeetodo',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_todos',true);
        $this->set('committee',$committee);
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('priorities'));         
        //$this->set('priorities',$this->priorities); 

    }


        /*$this->Committeetodo->recursive = 0;
             if(isset($this->params['named']['committee_id'])){
            $this->set('committeesTodos', $this->paginate('Committeetodo',array('Committeetodo.committee_id'=>$this->params['named']['committee_id'])));
            $this->set('curcommittee',$this->params['named']['committee_id']);
        }
        else{
            $this->set('committeesTodos', $this->paginate());
        }
        $this->set('allow_add_committeesTodos',true);
        }*/



    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Committeetodo->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Committeetodo.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('committeesTodo', $this->Committeetodo->read(null, $id));
        $this->set('priorities',$this->priorities); 
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Committeetodo->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Committeetodo->create();
            if ($this->Committeetodo->save($this->data)) {
                $this->Session->setFlash(__('The To-do has been saved', true));
                $this->redirect(array('committee'=>$committee,'action'=>'index'));
            } else {
                $this->Session->setFlash(__('The To-do could not be saved. Please, try again.', true));
            }
        }
        $committees = $this->Committeetodo->Committee->find('list');
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('committees','priorities'));
        if(isset($this->params['named']['committee_id'])){
            $this->set('curcommittee',$this->params['named']['committee_id']);
        }
        $this->set('users', $this->Committeetodo->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
        $this->set('returnpage',$this->referer(null,true));
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee=null,$id = null) {
        $dcommittee=$this->Committeetodo->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Committeetodo', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Committeetodo->save($this->data)) {
                $this->Session->setFlash(__('The Committeetodo has been saved', true));
                $this->redirect(array('committee'=>$committee,'action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Committeetodo could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Committeetodo->read(null, $id);
            $this->set('committeesTodo', $this->data);
        }
        $committees = $this->Committeetodo->Committee->find('list');
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('committees','priorities'));
        $this->set('users', $this->Committeetodo->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
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
            $this->Session->setFlash(__('Invalid id for Committeetodo', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        $this->Committeetodo->del($id);
        $this->Session->setFlash(__('Committeetodo deleted', true));
        $this->redirect(array('committee'=>$committee,'action'=>'index'));
    }

}
?>
