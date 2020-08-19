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

class GroupsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Groups';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form');

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Group->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Group->recursive = 0;
        // first page
        if (empty($this->params['named']['page']) || empty($this->data)) $this->Session->del('Search.name');  

        // get the search terms
        if(!empty($this->data['Search']['name'])) $cursearch_group = $this->data['Search']['name'];
        elseif($this->Session->check('Search.name')) $cursearch_group = $this->Session->read('Search.name'); 
        else $cursearch_group = '';

        // construct queries
        $filters = array('committee_id'=>$dcommittee['Committee']['id']);
        if(isset($cursearch_group) && $cursearch_group!='') {
            array_push($filters,"Group.name  like '%".$cursearch_group."%'");
            $this->Session->write('Search.name', $cursearch_group);        
        }

        $groups=$this->paginate('Group',$filters);
        $groups=$this->fixupauth($groups,'Group',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('groups', $groups);
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Group->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Group.', true));
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
        }
        $this->set('group', $this->Group->read(null, $id));
         if($this->checkAuthority('Group',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_group',true);

    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Group->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->data['Group']['committee_id']=$dcommittee['Committee']['id'];
            $this->Group->create();
            if ($this->Group->save($this->data)) {
                $this->Session->setFlash(__('The Group has been saved', true));
                $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The Group could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Group->User->getUsersPerCommitteeList($dcommittee['Committee']['id']);
        $this->set(compact('users'));
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee,$id = null) {
        $dcommittee=$this->Group->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Group', true));
            $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
        }
        if (!empty($this->data)) {
            if ($this->Group->save($this->data)) {
                $this->Session->setFlash(__('The Group has been saved', true));
                $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The Group could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Group->read(null, $id);
        }
        $users = $this->Group->User->getUsersPerCommitteeList($dcommittee['Committee']['id']);
        $this->set(compact('users'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Group->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Group', true));
            $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
        }
        $this->Group->del($id);
        $this->Session->setFlash(__('Group deleted', true));
        $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
    }
}
?>
