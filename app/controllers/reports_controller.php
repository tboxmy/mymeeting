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
class ReportsController extends AppController {

    /**
     * Define $uses
     *
     */

    var $uses=array('User','Item','Meeting','Decision','Userstatus','Attachment');

    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form','Text');
/**
    /**
     * Describe meeting
     *
     * @param $committee
     * @param $id
     * @return null
 */
    function meeting($committee,$id=null){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->layout='report';
        $meeting=$this->Meeting->read(null,$id);
        $cdecisionfiles=$this->Attachment->decisionFiles($id);
        if(count($cdecisionfiles)){
            $decisionfiles=isset($decisionfiles)?am($decisionfiles,$cdecisionfiles):$cdecisionfiles;
        }

        $this->set(compact('meeting',$meeting));

        $this->Meeting->Decision->bindLatest();
        $decisions=$this->Meeting->Decision->find('all',array(
            'conditions'=>array('meeting_id'=>$id),
            'order'=>array(
                'Decision.ordering asc',
            )
        ));
        foreach($decisions as $decision){
            $cuserstatusfiles=$this->Attachment->userstatusFiles($decision['Decision']['id']);
            if(count($cuserstatusfiles)){
                $userstatusfiles=isset($userstatusfiles)?am($userstatusfiles,$cuserstatusfiles):$cuserstatusfiles;
            }
            $cgroupstatusfiles=$this->Attachment->groupstatusFiles($decision['Decision']['id']);
            if(count($cgroupstatusfiles)){
                $groupstatusfiles=isset($groupstatusfiles)?am($groupstatusfiles,$cgroupstatusfiles):$cgroupstatusfiles;
            }
        }
        if(isset($userstatusfiles)) $this->set('userstatusfiles',$userstatusfiles);
        if(isset($groupstatusfiles)) $this->set('groupstatusfiles',$groupstatusfiles);
        $this->set(compact('decisions',$decisions));
        $this->render('meeting','popup');
    }

    /**
     * Describe project
     *
     * @param $committee
     * @param $id
     * @return null
 */
    function project($committee,$id=null){
        $dcommittee=$this->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->layout='report';
        $item=$this->Item->read(null,$id);
        $this->set(compact('item',$item));
        $this->Item->Decision->bindLatest();
        $decisions=$this->Item->Decision->find('all',array(
            'conditions'=>array('item_id'=>$id),
            'order'=>array(
                'Decision.ordering asc',
            )
        ));
        foreach($decisions as $decision){
            $cuserstatusfiles=$this->Attachment->userstatusFiles($decision['Decision']['id']);
            if(count($cuserstatusfiles)){
                $userstatusfiles=isset($userstatusfiles)?am($userstatusfiles,$cuserstatusfiles):$cuserstatusfiles;
            }
            $cgroupstatusfiles=$this->Attachment->groupstatusFiles($decision['Decision']['id']);
            if(count($cgroupstatusfiles)){
                $groupstatusfiles=isset($groupstatusfiles)?am($groupstatusfiles,$cgroupstatusfiles):$cgroupstatusfiles;
            }
        }
        if(isset($userstatusfiles)) $this->set('userstatusfiles',$userstatusfiles);
        if(isset($groupstatusfiles)) $this->set('groupstatusfiles',$groupstatusfiles);
        $this->set(compact('decisions',$decisions));
        $this->render('project','popup');
    }
}

?>
