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

class CommentHelper extends AppHelper
{
    var $helpers=array('Html','Form','Text');

    function add_form($model,$data=null){
        $output='<div class=\'add_comment\'>';
        $output.=$this->Form->create($model,array('url'=>array('action'=>'edit','committee'=>$this->params['committee'])));
        $output.='<h4>'.__('Leave a comment',true).'</h4>';
        if(isset($data[$model]['id'])){
            $modelid=$data[$model]['id'];
        }
        elseif(isset($data['id'])){
            $modelid=$data['id'];
        }
        if(isset($modelid)){
            $output.="<input id=\"".$model."id\" type=\"hidden\" value=\"".$modelid."\" name=\"data[$model][id]\">\n";
        }
        else{
            $output.=$this->Form->input('id');
        }
        $output.=$this->Form->textarea($model.'Comment.Comment.description',array('class'=>'commentbox','rows'=>'3','cols'=>'8'));
        $output.="&nbsp;";
        $output.=$this->Form->hidden('returnpage',array('value'=>substr($this->here,strlen($this->base))));
        $output.=$this->Form->button(__('Submit',true), array('type'=>'submit'));
        $output.=$this->Form->end();
        $output.='</div>';
        return $output;
    }

    function list_comment($model,$data=null){
        $output='';
        $output.='<div class=\'list_comment\'>';
        if($data){
            if(isset($data[$model.'Comment']))
                $curdat=$data[$model.'Comment'];
        }
        else{
            if(isset($this->data[$model.'Comment']))
                $curdat=$this->data[$model.'Comment'];
        }
        if(isset($curdat)){
            $output.="<ul>";
            foreach($curdat as $cmt){
                $output.="<li>";
                //$output.="<pre>".$cmt['Comment']['description']."</pre>";
                $output.=$cmt['Comment']['description'];
                if(isset($cmt['Comment']['user_id'])){
                    if(isset($cmt['Comment']['user_name'])){
                        $output.=' -- '.$cmt['Comment']['user_name'];
                        $output.= $cmt['Comment']['job_title'] ? ', '.$cmt['Comment']['job_title'] : '';
                    }
                    $output.=" ".__('on',true)." ".date(Configure::read('date_format'),strtotime($cmt['Comment']['updated']));
                    $output.=" ".date(Configure::read('time_format'),strtotime($cmt['Comment']['updated']));
                }
                $output.="</li>";
            }
            $output.="</ul>";
        }
        $output.='</div>';
        return $output;
    }

    function disp_comment($model,$data=null){
        $output = '<div>';
        $output.=$this->list_comment($model,$data);
        $output.='<p></p>&nbsp;';
        $output.=$this->add_form($model,$data);
        $output.= '</div>';
        return $output;
    }

    function no_of_comments($model,$data=null) {
        if($data){
            if(isset($data[$model.'Comment']))
                $curdat=$data[$model.'Comment'];
        }
        else{
            if(isset($this->data[$model.'Comment']))
                $curdat=$this->data[$model.'Comment'];
        }
        if(isset($curdat)) return count($curdat);
        else return 0;
    }
}
?>
