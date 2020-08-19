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

class Group extends AppModel {

/**
 * Defining the name of model
 *
 */
    var $name = 'Group';
/**
 * Defining the name of the table
 *
 */
    var $useTable = 'groups';


    //validation
/**
 * Validating the fields in group model
 *
 */
   var $validate = array(
                            'name' => array(VALID_NOT_EMPTY)
                           
                                            
                           
                           );     

/**
 * Building assosiations betweeen models
 *
 */
    var $belongsTo = array(
        'Committee' => array(
            'className' => 'Committee',
            'foreignKey' => 'committee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * Building assosiations betweeen models
 *
 */
    var $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'users_groups',
            'foreignKey' => 'group_id',
            'associationForeignKey' => 'user_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );

/**
 * Finding all the related list of users in the group defined by the group_id
 * $param group_id finds all the related users in the group
 */
    function userList($group_id){
        $users=Set::extract($this->find('all',array('conditions'=>array('Group.id'=>$group_id))),'{n}.User.{n}.id');
        if(is_array($group_id)){
            return $users;
        }
        else{
            return $users[0];
        }
    }
}
?>
