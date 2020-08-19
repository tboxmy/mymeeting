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

class RolesController extends AppController {

	/**
	 * Define $name
	 *
	 */
	var $name = 'Roles';
	/**
	 * Define $helpers
	 *
	 */
	var $helpers = array('Html', 'Form');
	/**
	 * Define $uses
	 *
	 */
	var $uses = array('Role','Permission');

	/**
	 * Describe index
	 *
	 * @return null
	 */
	function index() {  
		//$this->layout='mainpage';
		$this->Role->recursive = 0;

		// first page
		if (empty($this->params['named']['page']) || empty($this->data)) $this->Session->del('Search.name');  

		// get the search terms
		if(!empty($this->data['Search']['name'])) $cursearch_role = $this->data['Search']['name'];
		elseif($this->Session->check('Search.name')) $cursearch_role = $this->Session->read('Search.name'); 
		else $cursearch_role = '';

		// construct queries
		$filters = array();
		if(isset($cursearch_role) && $cursearch_role!='') {
			array_push($filters,"Role.name  like '%".$cursearch_role."%'");
			$this->Session->write('Search.name', $cursearch_role);        
		}

		$this->set('roles', $this->paginate('Role',$filters));
		if($this->Auth->user('superuser')){
			$this->set('allow_add_roles',true);
		}
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
			$this->Session->setFlash(__('Invalid Role.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

	/**
	 * Describe add
	 *
	 * @return null
	 */
	function add() {
		//$this->layout='mainpage';
		if (!empty($this->data)) {
			$this->Role->create();
			if ($this->Role->save($this->data)) {
				$this->_updatepermission($this->Role->getLastInsertID());
				$this->Session->setFlash(__('The Role has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Role could not be saved. Please, try again.', true));
			}
		}
	}

	/**
	 * Describe _updatepermission
	 *
	 * @param $id
	 * @param $editing
	 * @return null
	 */
	function _updatepermission($id, $editing=false){
		$aro=new Aro();
		$aroexists=$aro->findByAlias($id);
		if(!$aroexists){
			$aro->create();
			$aro->save(array('alias'=>$id));
		}

		if ($editing) { // if editing role -> get acos for this aro $id
			$aros_acos = $this->Permission->find('all', array(
				'conditions'=>array('aro_id'=>$id),
				'fields'=>'Aco.alias'
			));
			foreach ($aros_acos as $aro_aco) {
				// put them in array
				$existing_acos_w_perm[] = $aro_aco['Aco']['alias'];
			}

		}

		foreach($this->data as $dname=>$ddat){
			if($dname!='Role'){

				if($ddat['C']) $perm[]='create';
				if($ddat['R']) $perm[]='read';
				if($ddat['U']) $perm[]='update';
				if($ddat['D']) $perm[]='delete';

				$aco=new Aco();
				$exists=$aco->findByAlias($dname);
				if(!$exists){
					$aco->create();
					$aco->save(array('alias'=>$dname));
				}

				if ($editing && in_array($dname, $existing_acos_w_perm)) { // if editing
					if (!isset($perm) || !count($perm)) { // if all task is removed -> deny all of them
						$this->Acl->deny($id,$dname,'*');
					}
				}

				if(isset($perm)){
					$this->Acl->allow($id,$dname,$perm);
					unset($perm);
				}
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
			$this->Session->setFlash(__('Invalid Role', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Role->save($this->data)) {
				$this->_updatepermission($this->Role->id, true);
				$this->Session->setFlash(__('The Role has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Role could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Role->read(null, $id);
			$this->set('role',$this->data['Role']);

			// load acl to preselect the checkboxes
			$this->_loadpermission($id);
		}
	}


	/**
	 * Describe _loadpermission
	 *
	 * @param $id
	 * @return null
	 */
	function _loadpermission($id) {
		// model Aco is in model/db_acl.php <-- loaded in DB_ACL in ACL component
		$access2 = $this->Acl->Aco->find('all');

		$allow = array();
		foreach ($access2 as $access) { // loop the acos
			$alias = $access['Aco']['alias']; // get the aco alias

			if (count($access['Aro'])) { // see if there's aro attached for this aco
				foreach ($access['Aro'] as $aro) { // loop all aros for that aco
					$set = 0;
					if ($aro['alias'] == $id) { // only take for this aro $id
						$allow[$alias.'.C'] = $aro['Permission']['_create'] == '1' ? "true":"false";
						$allow[$alias.'.R'] = $aro['Permission']['_read'] == '1' ? "true":"false";
						$allow[$alias.'.U'] = $aro['Permission']['_update'] == '1' ? "true":"false";
						$allow[$alias.'.D'] = $aro['Permission']['_delete'] == '1' ? "true":"false";
						$set = 1; //stop looping if already found it
					} else {
						// set everything else to false
						$allow[$alias.'.C'] = "false";
						$allow[$alias.'.R'] = "false";
						$allow[$alias.'.U'] = "false";
						$allow[$alias.'.D'] = "false";

					}
					if ($set) break;
				}
			} else {
				// set everything else to false
				$allow[$alias.'.C'] = "false";
				$allow[$alias.'.R'] = "false";
				$allow[$alias.'.U'] = "false";
				$allow[$alias.'.D'] = "false";
			}
		}


		$this->set('allow',$allow);
		//echo "<pre>".print_r($allow,true)."</pre>";
		//echo "<pre>".print_r($access2,true)."</pre>";
		//exit;
	}

	/**
	 * Describe delete
	 *
	 * @param $id
	 * @return null
	 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Role', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Role->del($id); 
		$this->Session->setFlash(__('Role deleted', true));
		$this->redirect(array('action'=>'index'));
	}

}
?>
