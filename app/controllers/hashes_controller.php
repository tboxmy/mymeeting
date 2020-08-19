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

class HashesController extends AppController {

    var $name = 'Hashes';
    var $helpers = array('Html', 'Form');
    var $uses = array('Hash','Meeting','Title','Attendance');
    
    
    function hash($hashstring='') {
        
        if (!empty($this->data)) { 
            if ($this->data['Hash']['hash_type'] == 'confirm') {
                $a = $this->Attendance->find('first', array('conditions'=>array('user_id'=>$this->data['Hash']['user_id'],'meeting_id'=>$this->data['Hash']['meeting_id'])));
                
                $a['Attendance']['user_id'] = $this->data['Hash']['user_id'];
                $a['Attendance']['meeting_id'] = $this->data['Hash']['meeting_id'];
                $a['Attendance']['will_attend'] = $this->data['Hash']['will_attend'];
                if ($this->data['Hash']['will_attend'] == '0' || $this->data['Hash']['will_attend'] == '2')
                    $a['Attendance']['excuse'] = $this->data['Hash']['excuse'];
                if ($this->data['Hash']['allow_rep'] && isset($this->data['Hash']['allow_rep'])) 
                    $a['Attendance']['rep_name'] = $this->data['Hash']['wakil'];
                $a['Attendance']['confirm_date'] = date('Y-m-d H:i:s');
                if ($this->Attendance->save($a)) {
                    $this->Session->setFlash(__('Attendance confirmation has been saved', true));
                } else {
                    $this->Session->setFlash(__('Attendance confirmation could not be saved. Please, try again.', true));
                }
            }
        } 
        
        if (isset($hashstring) && !empty($hashstring)) { 
            $hash = $this->Hash->findByHash($hashstring);
            $this->set('hash',$hash);
            $d = $this->{$hash['Hash']['model']}->findById($hash['Hash']['foreign_key']);
            $this->set('d',$d);
                
            if ($hash['Hash']['hash_type'] == 'confirm') { // $d is attendance model
                $this->Meeting->Behaviors->attach('Containable');
                $committee = $this->Meeting->find('first',array('conditions'=>array('Committee.id'=>$d['Meeting']['committee_id']),'contain'=>'Committee'));
                $this->set('committee',$committee);
                $title = $this->Title->find('first',array('conditions'=>array('id'=>$d['User']['title_id'])));
                $this->set('title1',$title);
            }
            $this->render($hash['Hash']['hash_type']); 
        } else {
            $this->Session->setFlash(__('Invalid action.', true));
        }
        
    }

}
?>
