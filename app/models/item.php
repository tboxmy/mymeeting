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

class Item extends AppModel {

/**
 * Defining the name of model
 *
 */
    var $name = 'Item';
/**
 * Defining the name of the table
 *
 */
    var $useTable = 'items';
/**
 * Displaying item short name
 *
 */
    var $displayField = 'short_name';
/**
 * Defining behavior in the model
 *
 */
    var $actsAs = array('Workflow');

    //validation
    var $committee_id = null;
/**
 * Validating the fields in group model
 *
 */
    var $validate = array(
            'name' => array('required'=>VALID_NOT_EMPTY),
            'short_name' => array(
                'alphaNumeric' => array('rule' => 'alphaNumeric'),
                'required'=>VALID_NOT_EMPTY,
                'unique'=>array('rule' =>'uniqueitem')
            ));   

    //The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * Building assosiations betweeen models
 *
 */
    var $belongsTo = array(
        'Committee' => array('className' => 'Committee',
        'foreignKey' => 'committee_id',
        'conditions' => '',
        'fields' => '',
        'order' => '')
    );

/**
 * Building assosiations betweeen models
 *
 */
    var $hasMany = array(
        'Decision' => array('className' => 'Decision',
        'foreignKey' => 'item_id',
        'dependent' => false,
        'conditions' => '',
        'fields' => '',
        'order' => '',
        'limit' => '',
        'offset' => '',
        'exclusive' => '',
        'finderQuery' => '',
        'counterQuery' => '')
    );

/**
 * Getting all the related committee defined by the item_id
 * $param item_id finds all the related committee
 */
    function getCommitteeId($item_id){
        $data=$this->getData(array('committee_id'),array('id'=>$item_id));
        return $data[0]['Item']['committee_id'];
    }

/**
 * Finding all the related user data defined by the user_id and item_id
 * $param user_id and item_id finds all the related user data
 */
    function userData($user_id,$item_id=null){
        if($item_id){
            $toret=$this->Committee->userData($user_id,$item_id);
        }
        return $toret;
    }
    
    /*
     * For validation
     * */
    function uniqueitem($value, $params=array()) {
        $item = $this->find('count',array('conditions'=>array('committee_id'=>$this->committee_id,'Item.short_name'=>$value)));
        if ($item) return false;
        else return true;
    }
}
?>
