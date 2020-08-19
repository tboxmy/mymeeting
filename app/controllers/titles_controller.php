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

class TitlesController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Titles';
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
        //$this->layout='mainpage';
        $this->Title->recursive = 0;
        // first page
        if (empty($this->params['named']['page']) || empty($this->data)) {
            $this->Session->del('Search.short'); 
            $this->Session->del('Search.long'); 
        }

        // get the search terms
        if(!empty($this->data['Search']['short'])) $cursearch_short = $this->data['Search']['short'];
        elseif($this->Session->check('Search.short')) $cursearch_short = $this->Session->read('Search.short'); 
        else $cursearch_short = '';
        if(!empty($this->data['Search']['long'])) $cursearch_long = $this->data['Search']['long'];
        elseif($this->Session->check('Search.long')) $cursearch_long = $this->Session->read('Search.long'); 
        else $cursearch_long = '';

        // construct queries
        $filters = array();
        if(isset($cursearch_short) && $cursearch_short!='') {
            array_push($filters,"Title.short_name  like '%".$cursearch_short."%'");
            $this->Session->write('Search.short_name', $cursearch_short);        
        }
        if(isset($cursearch_long) && $cursearch_long!='') {
            array_push($filters,"Title.long_name  like '%".$cursearch_long."%'");
            $this->Session->write('Search.long_name', $cursearch_long);              
        }
        $this->set('titles', $this->paginate('Title',$filters));
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        //$this->layout='mainpage';
        if (!$id) {
            $this->Session->setFlash(__('Invalid Title.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('dtitle', $this->Title->read(null, $id));
    }

    /**
     * Describe add
     *
     * @return null
     */
    function add() {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $this->Title->create();
            if ($this->Title->save($this->data)) {
                $this->Session->setFlash(__('The Title has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Title could not be saved. Please, try again.', true));
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
        //$this->layout='mainpage';
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Title', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Title->save($this->data)) {
                $this->Session->setFlash(__('The Title has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Title could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Title->read(null, $id);
        }
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Title', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Title->del($id);
        $this->Session->setFlash(__('Title deleted', true));
        $this->redirect(array('action'=>'index'));
    }

}
?>
