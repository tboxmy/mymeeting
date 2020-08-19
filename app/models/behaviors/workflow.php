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

class WorkflowBehavior extends ModelBehavior
{
    /**
     * Define $settings
     *
     */
    var $settings=array();
    /**
     * Define $runtime
     *
     */
    var $runtime=array();
    /**
     * Define $wfstatus
     *
     */
    var $wfstatus,$wfmodel;

    /**
     * Describe __construct
     *
     * @return null
     */
    function __construct(){
        $this->wfstatus=ClassRegistry::init('Wfstatus','model');
        $this->wfmodel=ClassRegistry::init('Wfmodel','model');
    }

    /**
     * Describe setup
     *
     * @param $model
     * @param $config
     * @return null
     */
    function setup(&$model,$config = array()){
        //$this->settings[$model->alias]['assocAlias'] = $model->alias.'Comment';
        return true;
    }

    /**
     * Describe afterFind
     *
     * @param $model
     * @param $results
     * @param $primary
     * @return null
     */
    function afterFind(&$model,$results,$primary){
        if(isset($model->curUser) && $model->curUser){ 
            foreach($results as &$result){
                if(isset($result[$model->alias])){
                    $auth=$model->getAuthority($model->curUser,$result[$model->alias][$model->primaryKey]);
                    if(!is_array($auth)){
                        $auth['view']=null;
                        $auth['edit']=null;
                        $auth['delete']=null;
                        $auth['approve']=null;
                        $auth['disapprove']=null;
                    }
                    $result['auth']=$auth;
                }
            }
        } else {
            $this->log("[Behaviour Workflow afterFind] Properties curUser for model '.$model->alias.' is not defined");
        }
        return $results;
    }

    /**
     * Describe afterSave
     *
     * @param $model
     * @param $created
     * @return null
     */
    public function afterSave(&$model,$created){
        if($created){
            $foreign_key=$model->getLastInsertID();
            if(method_exists($model,'getCommitteeId')){
                $com_id=$model->getCommitteeId($foreign_key);
                $workflow=$this->wfstatus->Workflow->find('first',array('conditions'=>array('model'=>$model->alias,'committee_id'=>$com_id),'order'=>'level'));
                if($workflow){
                    $this->wfstatus->create();
                    $data['model']=$model->alias;
                    $data['foreign_key']=$foreign_key;
                    $data['workflow_id']=$workflow['Workflow']['id'];
                    $data['level']=$workflow['Workflow']['level'];
                    $this->wfstatus->save($data);
                }
            } else {
                $this->log("[Behaviour Workflow afterSave] Method getCommitteeId() for model '.$model->alias.' is missing");
            }
        }
        else{
            $foreign_key=$model->id;
        }
    }
}
?>
