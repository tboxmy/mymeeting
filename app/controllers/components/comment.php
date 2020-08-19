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

class CommentComponent extends Object
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
        if($args[0]=="comments"){
            $this->args['foreign_key']=$controller->action;
            if($args[1]=="view"){
                echo $this->list_comment();
                exit();
            }
            elseif($args[1]=="add"){
            }
        }
    }

/**
 * Describe list_comment
 *
 * @return null
 */
    function list_comment(){
        $controller=$this->controller;
        $cmtdata=$controller->{$controller->modelClass}->find('all',array(
            'conditions'=>array(
                $controller->modelClass.'.id' => $this->args['foreign_key']
            )
        ));
        if(count($cmtdata[0][$controller->modelClass.'Comment'])){
            $output="<ul>";
            foreach($cmtdata[0][$controller->modelClass.'Comment'] as $comment){
                $output.="<li>";
                $output.="<pre>".$comment['Comment']['description']."</pre>";
                $output.="<div class='commentdetails'>";
                $output.=$comment['Comment']['user_id'].' '.__('on',true).' '.date("d/m/Y (h:i a)",strtotime($comment['Comment']['updated']));
                $output.="</div>";
                $output.="</li>";
            }
            $output.="</ul>";
        }
        return $output;
    }
}
?>
