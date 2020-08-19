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

class MeetingsUsersController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'MeetingsUsers';
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
        $this->MeetingsUser->recursive = 0;
        $this->set('meetingsUsers', $this->paginate());
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid MeetingsUser.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('meetingsUser', $this->MeetingsUser->read(null, $id));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->MeetingUser->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            foreach ($this->data['MeetingsUser'] as $id => $attended) {
                if ($id != 'meetingid') {
                    // build data array
                    $user = $this->MeetingsUser->getUserId($id);
                    $data['MeetingsUser']['user_id'] = $user['user_id'];
                    $data['MeetingsUser']['meeting_id'] = $this->data['MeetingsUser']['meetingid'];

                    if ($attended) {
                        $data['MeetingsUser']['attended'] = 1;
                    } else { $data['MeetingsUser']['attended'] = 0; }

                    // delete the records
                    $this->MeetingsUser->del($id);

                    // add new record
                    $this->MeetingsUser->create();
                    $this->MeetingsUser->save($data);
                }
            }
            $this->Session->setFlash(__('The attendance has been saved', true));
            $this->redirect(array('action'=>'index', 'controller'=>'meetings'));
        }
        $meetings = $this->MeetingsUser->Meeting->find('list');
        $users = $this->MeetingsUser->User->find('list');
        $this->set(compact('meetings', 'users'));
    }

    /**
     * Describe edit
     *
     * @param $id
     * @return null
     */
    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid MeetingsUser', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->MeetingsUser->save($this->data)) {
                $this->Session->setFlash(__('The MeetingsUser has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The MeetingsUser could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->MeetingsUser->read(null, $id);
        }
        $meetings = $this->MeetingsUser->Meeting->find('list');
        $users = $this->MeetingsUser->User->find('list');
        $this->set(compact('meetings','users'));
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for MeetingsUser', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->MeetingsUser->del($id);
        $this->Session->setFlash(__('MeetingsUser deleted', true));
        $this->redirect(array('action'=>'index'));
    }
}
?>
