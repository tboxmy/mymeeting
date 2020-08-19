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

class SystemtodosController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Systemtodos';
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
        $this->Systemtodo->recursive = 0;
         $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('priorities')); 
        
        // first page
        if (empty($this->params['named']['page']) || empty($this->data)) {
            $this->Session->del('Search.name'); 
            $this->Session->del('Search.priority'); 
        }

        // get the search terms
        if(!empty($this->data['Search']['name'])) $cursearch_name = $this->data['Search']['name'];
        elseif($this->Session->check('Search.name')) $cursearch_name = $this->Session->read('Search.name'); 
        else $cursearch_name = '';
        if(!empty($this->data['Search']['priority'])) $cursearch_priority = $this->data['Search']['priority'];
        elseif($this->Session->check('Search.priority')) $cursearch_priority = $this->Session->read('Search.priority'); 
        else $cursearch_priority = '';
        
        // construct queries
        $filters = array();
        if(isset($cursearch_name) && $cursearch_name!='') {
            array_push($filters,"Systemtodo.name like '%".$cursearch_name."%'");
            //$filters['Systemtodo.name'] = 'LIKE %'.$cursearch_name.'%';
            $this->Session->write('Search.name', $cursearch_name);        
        }
        if(isset($cursearch_priority) && $cursearch_priority!='') {
            array_push($filters,"Systemtodo.priority = '".$cursearch_priority."'");
            //$filters['Systemtodo.priority'] = 'LIKE %'.$cursearch_priority.'%';
            $this->Session->write('Search.priority', $cursearch_priority);        
        }
        $this->set('todos', $this->paginate($filters));
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
            $this->Session->setFlash(__('Invalid Systemtodo.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('todo', $this->Systemtodo->read(null, $id));
    }

/**
 * Describe add
 *
 * @return null
 */
    function add() {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $this->Systemtodo->create();
            if ($this->Systemtodo->save($this->data)) {
                $this->Session->setFlash(__('The To-do has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The To-do could not be saved. Please, try again.', true));
            }
        }
        $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('priorities')); 
    }
    
/**
 * Describe summary
 *
 * @param $id
 * @return null
 */
    function summary($id = null) {            
        if ($id) {
            $this->Session->setFlash(__('Invalid To-do.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('todo', $this->Systemtodo->read(null, $id));
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
            $this->Session->setFlash(__('Invalid To-do', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Systemtodo->save($this->data)) {
                $this->Session->setFlash(__('The To-do has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The To-do could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Systemtodo->read(null, $id);
        }
        $todos = $this->Systemtodo->find('list');
         $priorities = array('1'=>__('Immediate', true), '2'=>__('Urgent', true), '3'=>__('High', true), '4'=>__('Normal', true), '5'=>__('Low', true), '6'=>__('None', true));
        $this->set(compact('todos','priorities')); 
    }


/**
 * Describe delete
 *
 * @param $id
 * @return null
 */
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for To-do', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Systemtodo->del($id);
        $this->Session->setFlash(__('To-do deleted', true));
        $this->redirect(array('action'=>'index'));
    }

}
?>
