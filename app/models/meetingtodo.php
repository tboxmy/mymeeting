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

class Meetingtodo extends AppModel {

/**
 * Defining the name of model
 *
 */
	var $name = 'Meetingtodo';
/**
 * Defining the name of the table
 */
	var $useTable = 'meetingtodos';
/**
 * Defining behavior in the model
 *
 */
    var $actsAs = array('Workflow');
    
/**
 * Validating the fields in meeting todo model
 *
 */
  var $validate = array('name'=>VALID_NOT_EMPTY );

	//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * Building assosiations betweeen models
 *
 */
	var $belongsTo = array(
			'Meeting' => array('className' => 'Meeting',
								'foreignKey' => 'meeting_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

    /**
     * Finding all the related user data (his groups and role in the committee AND if he's the owner) 
     * which is defined by the user id and meetingtodo_id
     * $param user_id, meetingtodo_id  finds all the user data
     */
    function userData($user_id,$meetingtodo_id=null){
        
        if(!isset($Committee)){
            App::import('Model','Committee');
            $Committee=& ClassRegistry::init('Committee');
        }
        if($meetingtodo_id){
            $toret=$Committee->userData($user_id,$this->getCommitteeId($meetingtodo_id));
        }
        $this->Behaviors->disable('Workflow');
        $mt = $this->find('all',array('conditions'=>array('Meetingtodo.id'=>$meetingtodo_id),'fields'=>'Meetingtodo.user_id'));
        if ($mt[0]['Meetingtodo']['user_id'] == $user_id) {
            $toret['owner'] = true; 
        }
        return $toret;
    }
    

	/**
	 * Getting all the related committees defined by the meetingtodo_id
	 * $param meetingtodo_id finds all the committee
	 */
    function getCommitteeId($meetingtodo_id) {
		$data=$this->query("select Meeting.committee_id from meetingtodos as MT, meetings as Meeting where MT.id='$meetingtodo_id' and MT.meeting_id=Meeting.id");
		
		return $data[0]['Meeting']['committee_id'];
    }
}
?>
