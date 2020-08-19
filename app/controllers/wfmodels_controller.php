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

class WfmodelsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Wfmodels';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form','Javascript');
    /**
     * Define $uses
     *
     */
    var $uses = array('Wfmodel','Workflow');

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Wfmodel->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Wfmodel->recursive = 0;
        $wfmodels=$this->paginate('Wfmodel',array('Wfmodel.committee_id'=>$dcommittee['Committee']['id']));
        $wfmodels=$this->fixupauth($wfmodels,'Wfmodel',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('wfmodels', $wfmodels);
        if($this->checkAuthority('Wfmodel',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_wfmodels',true);
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid Wfmodel.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('wfmodel', $this->Wfmodel->read(null, $id));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Wfmodel->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Wfmodel->create();
            if ($this->Wfmodel->save($this->data)) {
                $this->Session->setFlash(__('The Wfmodel has been saved', true));
                if(isset($this->data['Wfmodel']['returnpage'])){
                    $this->redirect($this->data['Wfmodel']['returnpage']);
                }
                else{
                    $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'wfmodels','action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Wfmodel could not be saved. Please, try again.', true));
            }
        }
        $committees = $this->Wfmodel->Committee->find('list');
        $this->set(compact('committees'));
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
        $dcommittee=$this->Wfmodel->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Wfmodel', true));
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
        }
        if (!empty($this->data)) {
            //echo "<pre>".htmlentities(print_r($this->data,true))."</pre>";exit();
            if ($this->Wfmodel->save($this->data)) {
                if(isset($this->data['Workflow'])){
                    foreach($this->data['Workflow'] as $workdat){
                        $this->Workflow->create();
                        if(!isset($workdat['id'])){
                            $workdat['committee_id']=$dcommittee['Committee']['id'];
                            $workdat['model']=$this->Wfmodel->field('model',array('id'=>$this->data['Wfmodel']['id']));
                        }
                        $this->Workflow->save($workdat);
                    }
                }
                $this->Session->setFlash(__('The Wfmodel has been saved', true));
                $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name'],'controller'=>'wfmodels'));
            } else {
                $this->Session->setFlash(__('The Wfmodel could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Wfmodel->read(null, $id);
        }
        $committees = $this->Wfmodel->Committee->find('list');
        $workflows = $this->Workflow->find('all',array('conditions'=>array('committee_id'=>$this->data['Wfmodel']['committee_id'],'model'=>$this->data['Wfmodel']['model']),'order'=>'level'));
        //$workflows='n';
        $this->set(compact('committees','workflows'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Wfmodel->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Wfmodel', true));
            $this->redirect(array('action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
        }
        $this->Wfmodel->del($id);
        $this->Session->setFlash(__('Wfmodel deleted', true));
        $this->redirect(array('controller'=>'wfmodels','action'=>'index','committee'=>$dcommittee['Committee']['short_name']));
    }
}
?>
