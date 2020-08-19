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

class User extends AppModel {

    /**
     * Defining the name of model
     *
     */
    var $name = 'User';
    /**
     * Defining the name of the table
     *
     */
    var $useTable = 'users';
    /**
     * Displaying user short name
     *
     */
    var $displayName = 'name';
    /**
     * Defining behavior in the model
     *
     */
    var $actsAs = array();
    /**
     * Validating the fields in user model
     */
    var $validate = array(
        'username' => array( 
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Alphabets and numbers only'),
            'minLength'=>array(
                'rule' => array(
                    'minLength',
                    4
                ),
                'message' => 'Minimum length 4'),
            'Username already taken'=>array(
                'rule' => array(
                    'checkUnique',
                    'username'
                ),
                'on'=>'create',
                'messsage' =>'Username already taken'
            )
        ),
        'password' => array(
            'alphaNumeric'=> array(
                'rule' => 'alphaNumeric',
                'message' => 'Alphabets and numbers only'
            ),
            'minLength' => array(
                'rule' => array(
                    'minLength', 4
                ),
                'message' => 'Minimum length 4'
            )
        ),	
        'name'=> VALID_NOT_EMPTY,
        'job_title'=> array(
            'allowEmpty'=>true,
        ),
        'email'=> array(
            'email'=>array(
                'rule' => 'email',
                'required' => true,
                'message' => 'Invalid email format'
            ),
            'email Unique'=>array(
                'rule' => array(
                    'checkUnique',
                    'email'
                ),
                'required' => true,
                'message' => 'E-mail already exists'
            )
        ),
        'address'=>  array(
            'allowEmpty'=>true,
        ),
        'telephone'=> array(
            'format'=>array(
                'rule' => array(
                    'custom',
                    '/[0-9]{2}[- ]?[0-9]{6,8}$/i'
                ),
                //'required' => true,
                //'message' => 'Telephone required eg: 03-12345213',
                'allowEmpty'=>true
            )
        ),
        'mobile'=> array(
            'format'=>array(
                'rule' => array(
                    'custom','/[0-9]{3}[- ]?[0-9]{7}$/i'
                ),
                //'message' => 'Please supply valid mobile number eg: 013-1234521312',
                'allowEmpty'=>true
            )
        ),
        'fax'=> array(
            'format'=>array(
                'rule' => array(
                    'custom','/[0-9]{2}[- ]?[0-9]{6,8}$/i'
                ),
                //'message' => 'Please supply valid fax number eg: 013-1234521312',
                'allowEmpty'=>true
            )
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * Building assosiations betweeen models 
     *
     */
    var $belongsTo = array(
        'Title' => array(
            'className' => 'Title',
            'foreignKey' => 'title_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Building assosiations betweeen models 
     *
     */
    var $hasMany = array(
        'Announcement' => array(
            'className' => 'Announcement',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Meetingtodo' => array(
            'className' => 'Meetingtodo',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Userstatus' => array(
            'className' => 'Userstatus',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Groupstatus' => array(
            'className' => 'Groupstatus',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Log' => array(
            'className' => 'Log',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Building assosiations betweeen models 
     *
     */
    var $hasAndBelongsToMany = array(
        'Committee' => array(
            'with'=>'Membership'
        ),
        'Meeting' => array(
            'with'=>'Attendance'
        ),
        'Decision' => array(
            'className' => 'Decision',
            'joinTable' => 'decisions_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'decision_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Group' => array(
            'className' => 'Group',
            'joinTable' => 'users_groups',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'group_id',
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
     * Finding all the user data which has the valid login defined in the data
     * $param data finds all the related user data which has a valid login 
     */
    function validateLogin($data){
        $user = $this->find(array('username' => $data['username'], 'password' => md5($data['password']), 'deleted'=>'0'), array('id', 'username','superuser'));
        if(!empty($user))
            return $user['User'];
        return false;
    }

    /**
     * Getting all the user per committee data which has the valid login defined in the data
     * $param data finds all the related user data which has a valid login 
     */
    function getUsersPerCommittee($committee_id,$restrict=false) {
        $users = $this->Membership->findAll(array('Membership.committee_id'=>$committee_id, 'User.deleted'=>'0'),'','User.name ASC');
        return $users;
    }

    /**
     * Getting list of all the user per committee data defined by the committee_id
     * $param committee_id finds all the related user per committee data
     */
    function getUsersPerCommitteeList($committee_id) {
        $data=$this->getUsersPerCommittee($committee_id,true);
        $key=Set::extract($data,'{n}.User.id');
        $data=Set::extract($data,'{n}.User.name');
        return array_combine($key,$data);
    }
}
?>
