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

class MultiFileHelper extends AppHelper
{
    var $helpers=array('Javascript');

    function beforeRender(){
        $view = ClassRegistry::getObject('view');
        if (is_object($view)) {
        $view->addScript($this->Javascript->link('scriptaculous/lib/prototype'));
        $view->addScript($this->Javascript->link('scriptaculous/src/scriptaculous'));
        $view->addScript($this->Javascript->link('multifile'));
        }
    }

    function input($fieldName, $options = array()){
        $view =& ClassRegistry::getObject('view');
        $output="<div class=\"multifile\">";
        if(isset($options['label'])){
            $title=$options['label'];
        }
        else{
            $title=$fieldName;
        }
        $output.="<label for=\"$fieldName\">".__(ucwords($title),true)."</label>";
        $output.="<input type=\"file\" name=\"$fieldName\" id=\"$fieldName\">";
        $output.="<div id=\"flist$fieldName\"></div>";
        $output.="<hr>";
        if(isset($view->data['MultiFile'][$fieldName])){
            foreach($view->data['MultiFile'][$fieldName] as $fname=>$fdat){
                $output.="<div><input type=\"hidden\" id=\"delold_".$fieldName.'_'.$fdat['Attachment']['id']."\" name=\"delold_".$fieldName.'_'.$fdat['Attachment']['id']."\" value=\"0\"><span id=\"old_".$fieldName.'_'.$fdat['Attachment']['id']."\">".$fdat['Attachment']['filename']."</span><input type=\"button\" value=\"Delete\" onClick=\"delfile('old_".$fieldName.'_'.$fdat['Attachment']['id']."');\"></div>";
            }
        }
        $output.="</div>";
        $output.="<script>var $fieldName=new MultiSelector(\$('flist$fieldName')); $fieldName.addElement(\$('$fieldName'));</script>";
        return $output;
    }
}
?>
