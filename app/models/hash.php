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
class Hash extends AppModel {

	var $name = 'Hash';
	var $validate = array(
		'id' => array('notempty'),
		'url' => array('notempty'),
		'hash' => array('notempty')
	);

    
    function insertToHashTable($hashtype,&$dataarr) {
        
        foreach($dataarr as $arrval) {
            $hashstring = $this->get_rand_id(30);
            
            if ($hashtype == 'confirm') {
                $model = 'Attendance';
                $foreign_key = $arrval['Attendance']['id'];
                $url = "hash/$hashstring";
                list($date,$time) = explode(' ', $arrval['Meeting']['meeting_date']);
                $date = explode('-', $date);
                $time = explode(':',$time);
                $due_date = date('Y-m-d H:i:s',mktime(0,0,0, $date[1], intval($date[2])-2, $date[0]));//2 days before meeting
                $limit = 0;
                $limit_count = 0;
                
                $new = 0;
                $edit = 0;
                $k = $this->find('first',array('conditions'=>array('Model'=>'Attendance','foreign_key'=>$foreign_key,'deleted'=>'1')));
                (!$k) ? $new = 1 : $edit = 1;
            }
            
            if ($new) {
                $this->create();
                $data['model'] = $model;
                $data['foreign_key'] = $foreign_key;
                $data['url'] = $url;
                $data['hash'] = $hashstring;
                $data['hash_type'] = $hashtype;
                $data['due_date'] = $due_date;
                $data['limit'] = $limit;
                $data['limit_count'] = $limit_count;
                $this->save($data);
            } else { 
                $k['Hash']['deleted_date'] = '0000-00-00 00:00:00';
                $k['Hash']['deleted'] = '0';
                $this->save($k);
            }
        }
    }
    
    
    /**
     * Describe get_rand_id
     *
     * @param $length
     * @return random string with the length of $length
     */
    function get_rand_id($length) {
        $rand_id = "";
        if($length>0) {
            $char = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','x','y','z',
                    '1','2','3','4','5','6','7','8','9',
                    'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','X','Y','Z'
                    );
            for($i=1; $i<=$length; $i++) {
                $rand_id .= $char[mt_rand(0,count($char)-1)];
            }
            if (!count($this->findByHash($rand_id))) $this->get_rand_id($length); //if hash not unique, regenerate it 
            else return $rand_id;
        } else {
            return false;
        }
    }
    
    function removeData($hashtype,$foreign_key) {
        if ($hashtype == 'confirm') {
            //$t = $this->find('first',array('conditions'=>array('model'=>'Attendance','foreign_key'=>$foreign_key,'deleted'=>array(0,1))));
            $t = $this->find('first',array('conditions'=>array('model'=>'Attendance','foreign_key'=>$foreign_key)));
            if ($t) {
                $t['Hash']['deleted'] = 1;
                $t['Hash']['deleted_date'] = date('Y-m-d H:i:s');
                $this->save($t);
            }
        }
    }
    
    function newPassword(){
        return $this->get_rand_id(6);
    }
}
?>
