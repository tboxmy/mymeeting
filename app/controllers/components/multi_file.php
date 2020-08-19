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

class MultiFileComponent extends Object
{
/**
 * Define $controller
 *
 */
    var $controller;
/**
 * Define $args
 *
 */
    var $args=array('action'=>null);

/**
 * Describe startup
 *
 * @param $controller
 * @return null
 */
    function startup(&$controller){
        $args=$controller->passedArgs;
        $this->controller=$controller;
        if($controller->action=="attachment"){
            if($args[1]){
                return $this->downloadfile($args[1]);
            }
        }
    }

/**
 * Describe downloadfile
 *
 * @param $id
 * @return null
 */
    function downloadfile($id){
        $this->mfile=ClassRegistry::init('Attachment','model');
        $dfile=$this->mfile->find('first',array('conditions'=>array('id' => $id)));
        if($dfile){
            header("Last-Modified: ".$dfile['Attachment']['modified']);
            header("Content-Type: " .$dfile['Attachment']['type']);
            header("Content-Length: " .$dfile['Attachment']['size']);
            header("Content-disposition: attachment; filename=\"".$dfile['Attachment']['filename']."\"");
            readfile($dfile['Attachment']['file']);
            exit();
        }
        else{
            return false;
        }
    }
}
?>
