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

class WorkflowsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Workflows';
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
        $dcommittee=$this->Workflow->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Workflow->recursive = 0;
        $this->set('workflows', $this->paginate());
        if($this->Auth->user('superuser')){
            $this->set('allow_add_workflow',true);
        }
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Workflow->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Workflow.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('workflow', $this->Workflow->read(null, $id));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Workflow->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Workflow->create();
            if ($this->Workflow->save($this->data)) {
                $this->Session->setFlash(__('The Workflow has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Workflow could not be saved. Please, try again.', true));
            }
        }
        $committees = $this->Workflow->Committee->find('list');
        $this->set(compact('committees'));
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee,$id = null) {
        $dcommittee=$this->Workflow->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Workflow', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Workflow->save($this->data)) {
                $this->Session->setFlash(__('The Workflow has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Workflow could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Workflow->read(null, $id);
        }
        $committees = $this->Workflow->Committee->find('list');
        $this->set(compact('committees'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Workflow->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Workflow', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Workflow->del($id);
        $this->Session->setFlash(__('Workflow deleted', true));
        $this->redirect(array('action'=>'index'));
    }

}
?>
