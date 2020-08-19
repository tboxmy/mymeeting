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

class AttachmentsController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Attachments';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form','Text');
/**
 * Define $uses
 *
 */
    var $uses = array('Attachment','Committee');

/**
 * Describe index
 *
 * @param $committee
 * @return null
 */
    function index($committee) {  
        $dcommittee=$this->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $meetingfiles=$this->Attachment->meetingFiles($dcommittee['Committee']['id']);
        $meetings=$this->Committee->Meeting->find('list',array(
'conditions'=>array(
'committee_id'=>$dcommittee['Committee']['id'],
'Meeting.deleted=0',
)
));
        foreach($meetings as $meeting_id=>$meeting){
            $cdecisionfiles=$this->Attachment->decisionFiles($meeting_id);
            if(count($cdecisionfiles)){
                $decisionfiles=isset($decisionfiles)?am($decisionfiles,$cdecisionfiles):$cdecisionfiles;
            }
            $decisions=$this->Committee->Meeting->Decision->find('list',array('conditions'=>array('meeting_id'=>$meeting_id)));
            foreach($decisions as $decision_id=>$decision){
                $cuserstatusfiles=$this->Attachment->userstatusFiles($decision_id);
                if(count($cuserstatusfiles)){
                    $userstatusfiles=isset($userstatusfiles)?am($userstatusfiles,$cuserstatusfiles):$cuserstatusfiles;
                }
                $cgroupstatusfiles=$this->Attachment->groupstatusFiles($decision_id);
                if(count($cgroupstatusfiles)){
                    $groupstatusfiles=isset($groupstatusfiles)?am($groupstatusfiles,$cgroupstatusfiles):$cgroupstatusfiles;
                }
            }
        }
        if(isset($meetingfiles)) $this->set('meetingfiles',$meetingfiles);
        if(isset($decisionfiles)) $this->set('decisionfiles',$decisionfiles);
        if(isset($userstatusfiles)) $this->set('userstatusfiles',$userstatusfiles);
        if(isset($groupstatusfiles)) $this->set('groupstatusfiles',$groupstatusfiles);
    }
}
?>
