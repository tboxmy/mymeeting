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

class SettingsController extends AppController {

/**
 * Define $name
 *
 */
    var $name = 'Settings';
/**
 * Define $helpers
 *
 */
    var $helpers = array('Html', 'Form', 'Javascript');
/**
 * Define $components
 *
 */
    var $components = array('ImageUpload');
    var uses = ('Item');
/**
 * Define $uses
 *
 */
//    var $uses = array('File');

/**
 * Describe edit
 *
 * @param $id
 * @return null
 */
    function edit($id = null) {
        
        if (!empty($this->data)) {
            if ($this->_setmymeeting($this->data)) {
                $this->Session->setFlash(__('The Global Settings has been saved', true));
            } else {
                $this->Session->setFlash(__('The Global Settings could not be saved. Configuration file mymeeting.php is not writable.', true));
            }
        }
        $user_settings=array('server_url','agency_name','agency_address','agency_slogan','date_format','time_format','email_from','email_from_name','email_host','email_port','days_to_remind');
        $this->set('user_settings',$user_settings);
    }

/**
 * Describe format
 *
 * @return null
 */
    function format() {
        $this->render('format','popup');
    }
    
    
/**
 * Describe setmymeeting
 *
 * @return null
 */
    function _setmymeeting($data) {
        
        $mymeeting['agency_name']=$data['Settings']['agency_name'];
        $mymeeting['agency_address']=$data['Settings']['agency_address'];
        $mymeeting['agency_slogan']=$data['Settings']['agency_slogan'];
        $mymeeting['date_format']=$data['Settings']['date_format'];
        $mymeeting['time_format']=$data['Settings']['time_format'];
        $mymeeting['email_from']=$data['Settings']['email_from'];
        $mymeeting['email_from_name']=$data['Settings']['email_from_name'];
        $mymeeting['email_host']=$data['Settings']['email_host'];
        $mymeeting['email_port']=$data['Settings']['email_port'];
        $mymeeting['days_to_remind']=$data['Settings']['days_to_remind'];
        $mymeeting['server_url']=$data['Settings']['server_url'];
        $mymeeting['defaultrole']='admin';
        $mymeeting['version']='v2.2';
        $output="<?php\n";
        $output.="\t/* Usage: \n";
        $output.="\t * Configure::write('One.key1', 'value of the Configure::One[key1]');\n";
        $output.="\t * Configure::read('Name'); will return all values for Name\n";
        $output.="\t * Configure::read('Name.key'); will return only the value of Configure::Name[key]\n";
        $output.="\t */\n\n";
        foreach($mymeeting as $mid=>$mdata){
            $output.="\tConfigure::write('$mid','$mdata');\n";
        }
        $output.="?>\n";
        $dfile= APP . 'config' . DS . 'mymeeting.php';
        
        $file = new File($dfile);
        if ($file->exists())  $file->delete(); 
        $file->create();
        
        if (!$file->writable()) return false;
        else {
            $file->open('w');
            $file->write($output);    
            $file->close();
            return true;
        }
    }
    
/**
 * Describe logo
 *
 * @return null
 */
    function logo() {
        
        $logo_uploaded = WWW_ROOT . 'img' . DS . 'logo';
            
        if (!empty($this->data)) {
                
            $logos = array();
            $logo_folder = new Folder($logo_uploaded);
            $logos = $logo_folder->find();
            // one image at a time in this folder
            if (count($logos)) {
                foreach($logos as $logo) {
                    $img = new File($logo_uploaded . DS . $logo);  
                    $img->delete();  
                }
            }
            
            // set the upload destination folder
            $destination = realpath($logo_uploaded) . '/';

            // grab the file
            $file = $this->data['Image']['upload_logo'];

            // upload the image using the image_upload component
            $result = $this->ImageUpload->upload($file, $destination, null, array('type' => 'resizecrop', 'size' => array('155', '80'), 'output' => 'jpg'));

            if (!$result){
                $this->Session->setFlash(__('Logo has been saved.',true));
            } else {
                // display error
                $errors = $this->ImageUpload->errors;
   
                // piece together errors
                if(is_array($errors)){ $errors = implode("<br />",$errors); }
   
                $this->Session->setFlash($errors);
                
                $this->Session->setFlash(__('Please correct errors below.',true));
                unlink($destination.$this->Upload->result);
            }
        }
        
        $this->set('img_path',$this->getLogo());
    }
}
?>
