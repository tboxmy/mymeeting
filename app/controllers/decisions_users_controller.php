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

class DecisionsUsersController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'DecisionsUsers';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form');

    /**
     * Describe index
     *
     * @return null
     */
    function index() {
        $this->DecisionsUser->recursive = 0;
        $this->set('decisionsUsers', $this->paginate());
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid DecisionsUser.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('decisionsUser', $this->DecisionsUser->read(null, $id));
    }

    /**
     * Describe add
     *
     * @return null
     */
    function add() {
        if (!empty($this->data)) {
            $this->DecisionsUser->create();
            if ($this->DecisionsUser->save($this->data)) {
                $this->Session->setFlash(__('The DecisionsUser has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The DecisionsUser could not be saved. Please, try again.', true));
            }
        }
        $decisions = $this->DecisionsUser->Decision->find('list');
        $users = $this->DecisionsUser->User->find('list');
        $this->set(compact('decisions', 'users'));
    }

    /**
     * Describe edit
     *
     * @param $id
     * @return null
     */
    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid DecisionsUser', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->DecisionsUser->save($this->data)) {
                $this->Session->setFlash(__('The DecisionsUser has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The DecisionsUser could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->DecisionsUser->read(null, $id);
        }
        $decisions = $this->DecisionsUser->Decision->find('list');
        $users = $this->DecisionsUser->User->find('list');
        $this->set(compact('decisions','users'));
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for DecisionsUser', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->DecisionsUser->del($id);
        $this->Session->setFlash(__('DecisionsUser deleted', true));
        $this->redirect(array('action'=>'index'));
    }

}
?>
