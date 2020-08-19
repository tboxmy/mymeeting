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
class Attachment extends AppModel
{
/**
 * Defining the name of model
 *
 */
    var $name="Attachment";
/**
 * Defining the name of the table
 *
 */
    var $useTable="attachments";

/**
 * Finding all the related files defined by the committee_id
 * $param committee_id finds all the files
 */
    function committeeFiles($committee_id){
        $this->bindModel(
            array(
                'belongsTo'=>array(
                    'Meeting' => array(
                        'className' => 'Meeting',
                        'foreignKey' => 'foreign_key',
                        'conditions' => array('Attachment.model'=>'Meeting'),
                        'fields' => '',
                        'order' => '')
                )
            )
        );
        $files=$this->find('all',array('conditions'=>array('committee_id'=>$committee_id)));
        $meetings=$this->Meeting->find('all',array('conditions'=>array('committee_id'=>$committee_id)));
        foreach($meetings as $meeting_id=>$meeting){
            $files=am($files,$this->decisionFiles($meeting_id));
            $decisions=$this->Meeting->Decision->find('list',array('conditions'=>array('meeting_id'=>$meeting_id)));
            foreach($decisions as $decision_id=>$decision){
                $files=am($files,$this->userstatusFiles($decision_id));
                $files=am($files,$this->groupstatusFiles($decision_id));
            }
        }
    }

/**
 * Finding all the related files in meeting model defined by the committee_id
 * $param committee_id finds all the files in meeting model 
 */
    function meetingFiles($committee_id){
        $this->bindModel(
            array(
                'belongsTo'=>array(
                    'Meeting' => array(
                        'className' => 'Meeting',
                        'foreignKey' => 'foreign_key',
                        'conditions' => array('Attachment.model'=>'Meeting'),
                        'fields' => '',
                        'order' => '')
                )
            )
        );
        return $this->find('all',array(
'conditions'=>array(
'committee_id'=>$committee_id,
'Meeting.deleted'=>0,
)
));
    }

/**
 * Finding all the related files in decision model defined by the meeting_id
 * $param meeting_id finds all the files in decision model 
 */
    function decisionFiles($meeting_id){
        $this->bindModel(
            array(
                'belongsTo'=>array(
                    'Decision' => array(
                        'className' => 'Decision',
                        'foreignKey' => 'foreign_key',
                        'conditions' => array('Attachment.model'=>'Decision'),
                        'fields' => '',
                        'order' => '')
                )
            )
        );
        return $this->find('all',array('conditions'=>array('meeting_id'=>$meeting_id)));
    }

/**
 * Finding all the related files in groupstatus model defined by the decision_id
 * $param decision_id finds all the files in groupstatus model 
 */
    function groupstatusFiles($decision_id){
        $this->bindModel(
            array(
                'belongsTo'=>array(
                    'Groupstatus' => array(
                        'className' => 'Groupstatus',
                        'foreignKey' => 'foreign_key',
                        'conditions' => array('Attachment.model'=>'Groupstatus'),
                        'fields' => '',
                        'order' => '')
                )
            )
        );
        return $this->find('all',array('conditions'=>array('decision_id'=>$decision_id)));
    }

/**
 * Finding all the related files in userstatus model defined by the decision_id
 * $param decision_id finds all the files in userstatus model 
 */
    function userstatusFiles($decision_id){
        $this->bindModel(
            array(
                'belongsTo'=>array(
                    'Userstatus' => array(
                        'className' => 'Userstatus',
                        'foreignKey' => 'foreign_key',
                        'conditions' => array('Attachment.model'=>'Userstatus'),
                        'fields' => '',
                        'order' => '')
                )
            )
        );
        return $this->find('all',array('conditions'=>array('decision_id'=>$decision_id)));
    }
}
?>
