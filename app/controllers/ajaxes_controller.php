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

class AjaxesController extends AppController {
    /**
     * Define $uses
     *
     */
    var $uses=array('Item','User','Group','Committee','UsersGroup');
    /**
     * Define $helpers
     *
     */
    var $helpers=array('Javascript','Ajax');

    /**
     * Describe listitems
     *
     * @param $committee_id
     * @return null
     */
    function listitems($committee_id){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $list=$this->Item->find('list',array('conditions'=>array('committee_id'=>$committee_id)));
        $this->layout='empty';
        foreach($list as $dkey=>$ddat){
            $output[]=$dkey;
            $output[]=$ddat;
        }
        $this->set('response',implode(',',$output));
        $this->render('raw');
    }

    /**
     * Describe latestitem
     *
     * @param $committee_id
     * @return null
     */
    function latestitem($committee_id){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $list=$this->Item->find('list',array('limit'=>1,'order'=>'updated desc','conditions'=>array('committee_id'=>$committee_id)));
        $this->layout='empty';
        foreach($list as $dkey=>$ddat){
            $output[]=$dkey;
            $output[]=$ddat;
        }
        $this->set('response',implode(',',$output));
        $this->render('raw');
    }

    /**
     * Describe checkemail
     *
     * @param $email
     * @return null
     */
    function checkemail($email){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='empty';
        $this->set('response',$this->User->find('first',array('conditions'=>array('email'=>$email))));
        $this->render('response');
    }

    /**
     * Describe userlist
     *
     * @return null
     */
    function userlist(){
        $dcommittee=$this->Committee->findByShortName($this->params['committee']);
        $this->set('dcommittee',$dcommittee);
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='empty';
        $this->set('groups',$this->Group->find('list',array('conditions'=>array('committee_id'=>$dcommittee['Committee']['id']))));
        $this->set('users',$this->Group->User->getUsersPerCommitteeList($dcommittee['Committee']['id']));
        $this->render('userlist');
    }

    /**
     * Describe groupusers
     *
     * @param $groupid
     * @return null
     */
    function groupusers($groupid){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='empty';
        $users=$this->UsersGroup->getData(array('user_id'),array('group_id'=>$groupid));
        $this->set('response',implode(',',Set::extract($users,'{n}.UsersGroup.user_id')));
        $this->render('raw');
    }

    /**
     * Describe usergroups
     *
     * @param $userid
     * @return null
     */
    function usergroups($userid){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='empty';
        $users=$this->UsersGroup->getData(array('group_id'),array('user_id'=>$userid));
        $this->set('response',implode(',',Set::extract($users,'{n}.UsersGroup.group_id')));
        $this->render('raw');
    }

    /**
     * Describe calendar
     *
     * @return null
     */
    function calendar(){
        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout='empty';
        $multicomm=false;
        if(isset($this->params['committee'])){
            $committee=$this->params['committee'];
        }
        elseif(isset($this->params['named']['committee'])){
            $committee=$this->params['named']['committee'];
        }
        else{
            $committee=$this->Committee->registeredCommittee($this->Auth->user('id'));
            $multicomm=true;
        }
        if(!$multicomm){
            $dcommittee=$this->Committee->findByShortName($committee);
            $this->set('dcommittee',$dcommittee);
        }
        if(isset($this->params['named']['year'])){
            $year=$this->params['named']['year'];
        }
        else{
            $year=date('Y');
        }
        if(isset($this->params['named']['month'])){
            $month=intval($this->params['named']['month']);
        }
        else{
            $month=intval(date('m'));
        }
        if($multicomm){
            $meetings=$this->Committee->Meeting->findAll(array('committee_id'=>$committee,'month(Meeting.meeting_date)'=>$month,'year(Meeting.meeting_date)'=>$year));
        }
        else{
            $meetings=$this->Committee->Meeting->findAll(array('committee_id'=>$dcommittee['Committee']['id'],'month(Meeting.meeting_date)'=>$month,'year(Meeting.meeting_date)'=>$year));
        }
        $this->set('meetings',$meetings);
        $this->set(compact('year','month'));
        if(isset($this->params['requested'])){
            return $this->render('calendar');
        }
    }
}
?>
