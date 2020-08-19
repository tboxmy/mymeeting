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

class MembershipsController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Memberships';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'Crumb','Javascript');
    /**
     * To set a default sort order
     */
    var $paginate = array('order'=>array('User.name'=>'ASC'));

    //adding user roles on committee
    /**
     * Describe addroles
     *
     * @return null
     */
    function addroles(){}

    //edditing user roles on committee

    /**
     * Describe editroles
     *
     * @param $id
     * @return null
     */
    function editroles($id = null){
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Membership', true));
            $this->redirect(array('controller'=>'Committees','action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Membership->save($this->data)) {
                $this->Session->setFlash(__('The changes on user role has been saved', true));
                $this->redirect(array('controller'=>'Committees','action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Membership could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->set('membership', $this->Membership->read(null, $id));    
            $this->data = $this->Membership->read(null, $id);
        }
        $roles = $this->Membership->Role->find('list');
        $this->set(compact('roles'));    
    }    

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Membership->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Membership->recursive = 2;

        // first page
        if (empty($this->params['named']['page']) && empty($this->data)) {
            $this->Session->del('Search.name'); 
            $this->Session->del('Search.email'); 
        }

        // get the search terms
        if(!empty($this->data['Search']['name']) && $this->data['Search']['name']!='' ) $cursearch_name = $this->data['Search']['name'];
        elseif($this->Session->check('Search.name')) $cursearch_name = $this->Session->read('Search.name'); 
        else $cursearch_name = '';
        if(!empty($this->data['Search']['email']) && $this->data['Search']['email']!='') $cursearch_email = $this->data['Search']['email'];
        elseif($this->Session->check('Search.email')) $cursearch_email = $this->Session->read('Search.email');
        else $cursearch_email = '';

        // construct queries
        $filters = array();
        array_push($filters,"Membership.committee_id = ".$dcommittee['Committee']['id']);
        if(isset($cursearch_name) && $cursearch_name!='') {
            array_push($filters,"User.name  like '%".$cursearch_name."%'");
            //$filters['User.name'] = 'LIKE %'.$cursearch_name.'%';
            $this->Session->write('Search.name', $cursearch_name);  
        }
        if(isset($cursearch_email) && $cursearch_email!='') {
            array_push($filters,"User.email  like '%".$cursearch_email."%'");
            //$filters['User.email'] = 'LIKE %'.$cursearch_email.'%';
            $this->Session->write('Search.email', $cursearch_email);        
        }

        $memberships=$this->paginate('Membership', $filters);
        $memberships=$this->fixupauth($memberships,'Membership',$this->Auth->user('id'),$dcommittee['Committee']['id']);
        $this->set('memberships', $memberships); 

        //$this->set('allow_add_users',true);
        if($this->checkAuthority('Membership',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_users',true);
        $this->set('committee',$committee);
    }

    /**
     * Describe addressbook
     *
     * @return null
     */
    function addressbook() {
        if($this->Session->check('CurCommittee')){
            //to get current selected committee
            $this->set('memberships',$this->paginate('Membership','Committee.id='.$this->Session->read('CurCommittee')));
        }
        else
        {
            $this->set('memberships',$this->paginate('Membership'));
        }   
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null ) {
        $dcommittee=$this->Membership->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Membership.', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        $membership = $this->Membership->read(null,$id);
        $this->set('membership',$membership);
        $this->Membership->User->Title->Behaviors->attach('Containable');
        $title = $this->Membership->User->find('all',array('conditions'=>array('User.id'=>$membership['User']['id']),'contain'=>'Title'));
        $this->set('title',$title);
        $roles = $this->Membership->find('all',array('conditions'=>array('user_id'=>$membership['User']['id']),'order'=>'Committee.name ASC'));
        //debug($roles);
        $this->set('roles',$roles);
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Membership->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $duser=$this->Membership->User->field('id',array('email'=>$this->data['User']['email']));
            if($duser){
                /* The user already exists so grab his id */
                $this->data['Membership']['user_id']=$duser;
            }
            else{
                /* If it is actually a new user then save the new user data first and grab the id */
                $this->data['User']['password']=$this->Auth->password($this->data['User']['username']);
                $this->Membership->User->create();
                if($this->Membership->User->save($this->data['User'])){
                    $this->data['Membership']['user_id']=$this->Membership->User->getLastInsertID();
                }
                else{
                    $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
                    $usersaved=false;
                }
            }
            $this->Membership->create();
            if(isset($this->data['Membership']['user_id']) && $this->Membership->isUnique(array('user_id'=>$this->data['Membership']['user_id'],'committee_id'=>$this->data['Membership']['committee_id']),false)){
                /* Check that the user actually haven't registered with that committee */
                if ($this->Membership->save($this->data)) {
                    $this->Session->setFlash(__('The User has been saved', true));
                    $this->redirect(array('controller'=>'Memberships','committee'=>$committee,'action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
                }
            }
            else{
                if(isset($usersaved) && $usersaved){
                    $this->redirect(array('committee'=>$committee,'action'=>'index'));
                }
            }
        }
        $users = $this->Membership->User->find('list');
        $committees = $this->Membership->Committee->find('list');
        $roles = $this->Membership->Role->find('list');
        $titles=$this->Membership->User->Title->find('list');
        $this->set(compact('users', 'committees', 'roles','titles'));
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit( $committee = null,$id = null) {
        $dcommittee=$this->Membership->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Membership', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->Membership->save($this->data)) {
                $this->Session->setFlash(__('The Membership has been saved', true));
                $this->redirect(array('committee'=>$committee,'action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Membership could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Membership->read(null, $id);
            $this->set('membership', $this->data);
        }
        $users = $this->Membership->User->find('list');
        $committees = $this->Membership->Committee->find('list');
        $roles = $this->Membership->Role->find('list');
        $this->set(compact('users','committees','roles'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Membership->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Membership', true));
            $this->redirect(array('committee'=>$committee,'action'=>'index'));
        }
        $this->Membership->del($id);
        $this->Session->setFlash(__('Membership deleted', true));
        $this->redirect(array('committee'=>$committee,'action'=>'index'));
    }
}
?>
