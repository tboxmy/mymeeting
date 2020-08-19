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

class AnnouncementsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Announcements';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'Javascript');

    /**
     * To set a default sort order
     *
     */
    var $paginate = array('order'=>array('Announcement.created' => 'desc'));


    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Announcement->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Announcement->recursive = 0;
        $announcement=$this->paginate('Announcement',array('committee_id'=>$dcommittee['Committee']['id']));
        $announcement=$this->fixupauth($announcement,'Announcement',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('announcements', $announcement);
        if($this->checkAuthority('Announcement',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_announcement',true);

    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Announcement->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Announcement.', true));
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
        }
        $this->set('announcement', $this->Announcement->read(null, $id));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Announcement->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->data['Announcement']['committee_id']=$dcommittee['Committee']['id'];
            $this->Announcement->create();
            $this->data['Announcement']['user_id']=$this->Auth->user('id');
            if ($this->Announcement->save($this->data)) {
                $this->Session->setFlash(__('The Announcement has been saved', true));
                $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The Announcement could not be saved. Please, try again.', true));
            }
        }
        $users = $this->Announcement->User->getUsersPerCommitteeList($dcommittee['Committee']['id']);
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
        $dcommittee=$this->Announcement->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Announcement', true));
            $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
        }
        if (!empty($this->data)) {
            if ($this->Announcement->save($this->data)) {
                $this->Session->setFlash(__('The Announcement has been saved', true));
                $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
            } else {
                $this->Session->setFlash(__('The Announcement could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Announcement->read(null, $id);
        }
        $users = $this->Announcement->User->getUsersPerCommitteeList($dcommittee['Committee']['id']);
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
        $dcommittee=$this->Announcement->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Announcement', true));
            $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
        }
        $this->Announcement->del($id);
        $this->Session->setFlash(__('Announcement deleted', true));
        $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
    }
}
