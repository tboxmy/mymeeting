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

class TemplatesController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Templates';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form','Text','Javascript');
    /**
     * Define $uses
     *
     */
    var $uses = array('Template','Committee');

    /**
     * Describe index
     *
     * @return null
     */
    function index() {
        $this->Template->recursive = 0;
        // first page
        if (empty($this->params['named']['page']) || empty($this->data)) {
            $this->Session->del('Search.title'); 
            $this->Session->del('Search.description'); 
            $this->Session->del('Search.message'); 
        }

        // get the search terms
        if(!empty($this->data['Search']['title'])) $cursearch_title = $this->data['Search']['title'];
        elseif($this->Session->check('Search.title')) $cursearch_title = $this->Session->read('Search.title'); 
        else $cursearch_title = '';
        if(!empty($this->data['Search']['description'])) $cursearch_description = $this->data['Search']['description'];
        elseif($this->Session->check('Search.description')) $cursearch_description = $this->Session->read('Search.description'); 
        else $cursearch_description = '';
        if(!empty($this->data['Search']['message'])) $cursearch_message = $this->data['Search']['message'];
        elseif($this->Session->check('Search.message')) $cursearch_message = $this->Session->read('Search.message'); 
        else $cursearch_message = '';

        // construct queries
        $filters = array();
        if(isset($cursearch_title) && $cursearch_title!='') {
            array_push($filters,"Template.title  like '%".$cursearch_title."%'");
            $this->Session->write('Search.title', $cursearch_title);        
        }
        if(isset($cursearch_description) && $cursearch_description!='') {
            array_push($filters,"Template.description  like '%".$cursearch_description."%'");
            $this->Session->write('Search.description', $cursearch_description);        
        }
        if(isset($cursearch_message) && $cursearch_message!='') {
            array_push($filters,"Template.template  like '%".$cursearch_message."%'");
            $this->Session->write('Search.message', $cursearch_message);        
        }

        if(isset($this->params['committee'])){
            $dcommittee=$this->Committee->findByShortName($this->params['committee']);
            $this->set('dcommittee',$dcommittee);
            $rules=array_merge($filters,array('model'=>'Committee','foreign_key'=>$dcommittee['Committee']['id']));
        }
        else{
            //$this->layout='mainpage';
            $rules=array_merge($filters,array('model'=>array('System','SystemOnly')));
        }
        $templates=$this->paginate('Template',$rules);
        if(isset($dcommittee)){
            $templates=$this->fixupauth($templates,'Template',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        }
        $this->set('templates', $templates);
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        if(isset($this->params['committee'])){
            $dcommittee=$this->Committee->findByShortName($this->params['committee']);
            $this->set('dcommittee',$dcommittee);
            $id=$this->params['id'];
        }
        else{
            //$this->layout='mainpage';
        }
        if (!$id) {
            $this->Session->setFlash(__('Invalid Template.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('template', $this->Template->read(null, $id));
    }

    /**
     * Describe add
     *
     * @return null
     */
    function add() {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $this->Template->create();
            if ($this->Template->save($this->data)) {
                $this->Session->setFlash(__('The Template has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Template could not be saved. Please, try again.', true));
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
        if(isset($this->params['committee'])){
            $dcommittee=$this->Committee->findByShortName($this->params['committee']);
            $this->set('dcommittee',$dcommittee);
            $id=$this->params['id'];
        }
        else{
            //$this->layout='mainpage';
        }
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Template', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Template->save($this->data)) {
                $this->Session->setFlash(__('The Template has been saved', true));
                if(isset($this->data['Template']['returnpage'])) {
                    $this->redirect($this->data['Template']['returnpage']);
                }
                elseif(isset($dcommittee)){
                    $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
                }
                else{
                    $this->redirect(array('action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Template could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Template->read(null, $id);
            $this->set('template', $this->Template->read(null, $id));
        }
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($id = null) {
        $this->layout='mainpage';
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Template', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Template->del($id);
        $this->Session->setFlash(__('Template deleted', true));
        $this->redirect(array('action'=>'index'));
    }

}
?>
