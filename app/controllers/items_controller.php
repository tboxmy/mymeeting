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

class ItemsController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Items';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form','Comment','Text','Javascript','Ajax');
/**
 * Define $uses
 *
 */
    var $uses = array('Item','Group','Meeting','User');

	var $paginate = array('order'=>array('Item.short_name'=>'asc'));

/**
 * Describe index
 *
 * @param $committee
 * @return null
 */
    function index($committee) {
        $dcommittee=$this->Item->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->set('items', $this->paginate('Item',array('committee_id'=>$dcommittee['Committee']['id'])));
        if($this->checkAuthority('Item',$this->Auth->user('id'),'create',$dcommittee['Committee']['id'],null)) $this->set('allow_add_item',true);
	$this->set('committee',$committee);
    }

/**
 * Describe view
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function view($committee, $id = null) {
        $dcommittee=$this->Item->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Project.', true));
            $this->redirect(array('action'=>'index'));
        }
        $item=$this->Item->read(null,$id);
		$prev=$this->Item->find('first',array(
			'conditions'=>array(
				'Item.committee_id'=>$dcommittee['Committee']['id'],
                                'Item.deleted=0',
				'Item.short_name<\''.$item['Item']['short_name'].'\'',
			),
			'fields'=>array(
				'id',
				'short_name',
			),
			'order'=>array(
				'Item.short_name'=>'desc'
			),
		));
		$next=$this->Item->find('first',array(
			'conditions'=>array(
				'Item.committee_id'=>$dcommittee['Committee']['id'],
                                'Item.deleted=0',
				'Item.short_name>\''.$item['Item']['short_name'].'\'',
			),
			'fields'=>array(
				'id',
				'short_name',
			),
			'order'=>array(
				'Item.short_name'=>'asc'
			),
		));
		if($prev){
			$this->set('prev',$prev);
		}
		if($next){
			$this->set('next',$next);
		}
		$this->set('item', $item);

        // for search dropdowns
        $groups = $this->Group->find('list',array('conditions'=>array('Group.committee_id'=>$dcommittee['Committee']['id']),'order'=>'Group.name ASC'));
        // get all users under this committee
        $users_tmp = $this->User->UsersGroup->find('all',array('conditions'=>array('UsersGroup.group_id'=>array_keys($groups))));
        $users_ids = array_unique(Set::extract($users_tmp, '{n}.UsersGroup.user_id'));
        $users = $this->User->find('list',array('conditions'=>array('User.id'=>$users_ids),'order'=>'User.name ASC'));
        //debug($users);
        
        //$meetings_tmp = $this->Meeting->find('all',array('conditions'=>array('Meeting.committee_id'=>$dcommittee['Committee']['id']),'order'=>' Meeting.meeting_num ASC'));
        $meetings_tmp = $this->Meeting->find('all',array('conditions'=>array('Meeting.committee_id'=>$dcommittee['Committee']['id'],'Meeting.parent_id'=>'0'),'order'=>' Meeting.meeting_num ASC'));
        $meetings_child = $this->Meeting->find('all',array('conditions'=>"Meeting.committee_id='".$dcommittee['Committee']['id']."' AND Meeting.parent_id!='0'"));
        
        foreach ($meetings_tmp as $meet) { 
            $meetings[$meet['Meeting']['id']] = $meet['Meeting']['meeting_num'].' - '.$meet['Meeting']['meeting_title']; 
            
            //$meetings = $this->_getChild($meet['Meeting']['id'],$meetings_child);
            foreach ($meetings_child as $child) {
                if ($meet['Meeting']['id'] == $child['Meeting']['parent_id']) {
                    $meetings[$child['Meeting']['id']] = "    -- ".$child['Meeting']['meeting_num'].' - '.$child['Meeting']['meeting_title'];
                }
            }
        }
        $this->set(compact('groups','users','meetings'));
        
        // find decisions to display
        if (!empty($this->data['Search']['meeting']) || !empty($this->data['Search']['group']) || !empty($this->data['Search']['user'])) {
            // for preselected values
            
            if (isset($this->data['Search']['user']) && $this->data['Search']['user']!='') { 
                $this->set('cursearch_user',$this->data['Search']['user']);
            } 
            if (isset($this->data['Search']['group']) && $this->data['Search']['group']!='') {
                $this->set('cursearch_group',$this->data['Search']['group']);
            } 
            if (isset($this->data['Search']['item']) && $this->data['Search']['item']!='') {
                $this->set('cursearch_project',$this->data['Search']['item']);
            }
            // then do the search 
            $decision = $this->Item->Decision->search($this->data['Search']);
        } else { 
            $decision=$this->Item->Decision->find('all',array(
                'conditions'=>array(
                    'Decision.item_id'=>$id,
                ),
                'order'=>array(
                    'Decision.meeting_id asc',
                    'Decision.ordering asc',
                ),
            )); 
        }
        $this->set('decisions',$decision);
        
        $this->set('item', $this->Item->read(null, $id));
        if($this->Item->Decision->isAuthorized($this->Auth->user('id'),'create',$dcommittee['Committee']['id'])) $this->set('allow_add_decision',true);
    }
/**
 * Describe _getChild
 *
 * @param $parent_id
 * @param $children_array
 * @param $return
 * @return null
 */
    /*
    function _getChild($parent_id,&$children_array,&$return=array()) {
        echo "<pre>".print_r($children_array,true)."</pre>";echo '<b>'.count($children_array).'</b>';
        $children = $children_array;
        if (!count($children)) {
            echo "<pre>".print_r($return,true)."</pre>**************";
            return $return;
        }
        else {
            foreach ($children_array as $key=>$child) {
                $child_id = $child['Meeting']['id'];
                if ($parent_id == $child['Meeting']['parent_id']) {
                    $return[$child_id] = " -- ".$child['Meeting']['meeting_num'].' - '.$child['Meeting']['meeting_title'];
                    unset($children[$key]);
                    echo '<br>1';
                } else {
                    unset($children[$key]);echo '<br>2';
                }
                //echo "<pre>".print_r($children,true)."</pre>===================";
                //echo "<br> -- ".$child['Meeting']['meeting_num'].' - '.$child['Meeting']['meeting_title'];;
                echo "<pre>".print_r($return,true)."</pre>===============";
                $this->_getChild($child_id,$children,$return);
            }
        }
    }*/

/**
 * Describe add
 *
 * @param $committee
 * @return null
 */
    function add($committee) {        
        if (!empty($this->data)) {
            $this->Item->committee_id = $this->dcommittee['Committee']['id']; //for unique validation
            $this->Item->create();
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('committee'=> $this->dcommittee['Committee']['short_name'],'action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        $committees=$this->Item->Committee->registeredCommitteeList($this->Auth->user('id'));
        $this->set(compact('committees'));
    }

/**
 * Describe add_dialog
 *
 * @param $committee
 * @return null
 */
    function add_dialog($committee) {
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='popup';
        $dcommittee=$this->Item->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Item->create();
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        $committees=$this->Item->Committee->registeredCommitteeList($this->Auth->user('id'));
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
    function edit($committee = null, $id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Item', true));
            $this->redirect(array('committee'=>$this->dcommittee['Committee']['short_name'],'action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->Item->committee_id = $this->dcommittee['Committee']['id']; //for unique validation
            if ($this->Item->save($this->data)) {
                $this->Session->setFlash(__('The Item has been saved', true));
                $this->redirect(array('committee'=>$this->dcommittee['Committee']['short_name'],'action'=>'index'));
            } else {
                $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Item->read(null, $id);
            $this->set('item',$this->data);
        }
        $committees=$this->Item->Committee->registeredCommitteeList($this->Auth->user('id'));
        $this->set(compact('committees'));
    }

/**
 * Describe delete
 *
 * @param $committee
 * @param $id
 * @return null
 */
    function delete($committee, $id = null) {
        $dcommittee=$this->Item->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Item', true));
            $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
        }
        $this->Item->del($id);
        $this->Session->setFlash(__('Item deleted', true));
        $this->redirect(array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'index'));
    }

}
?>
