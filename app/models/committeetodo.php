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

class Committeetodo extends AppModel {

    /**
     * Defining the name of model
     *
     */
    var $name = 'Committeetodo';
    /**
     * Defining the name of the table
     *
     */
    var $useTable = 'committeetodos';
    /**
     * Defining behavior in the model
     *
     */
    var $actsAs = array();


    /**
     * Validating the fields in committeestodo model
     *
     */
    var $validate = array(
        'name'=>VALID_NOT_EMPTY,
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * A committee can see its committeetodo and an association is defined so that committeetodo can see its committee.
     *
     */
    var $belongsTo = array(
        'Committee' => array(
            'className' => 'Committee',
            'foreignKey' => 'committee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

}
?>