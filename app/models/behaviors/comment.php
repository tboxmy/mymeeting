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

class CommentBehavior extends ModelBehavior
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
 * Define $Comment
 *
 */
	var $Comment;

/**
 * Describe __construct
 *
 * @return null
 */
	function __construct(){
		$this->Comment=ClassRegistry::init('Comment','model');
	}

/**
 * Describe setup
 *
 * @param $model
 * @param $config
 * @return null
 */
	function setup(&$model,$config = array()){
		$this->settings[$model->alias]['assocAlias'] = $model->alias.'Comment';
		return true;
	}

/**
 * Describe beforeFind
 *
 * @param $model
 * @param $query
 * @return null
 */
	public function beforeFind(&$model, $query){
		if($model->recursive){
			$commentcond['Comment.model']=$model->alias;
			if(!empty($query['conditions']) && is_array($query['conditions'])) {
				foreach($query['conditions'] as $fieldName => $constraint) {
					if(!strstr($fieldName,'Comment.')) {
						continue;
					}
					$commentcond[$fieldName] = $constraint;
					unset($query['conditions'][$fieldName]);
				}
			}

			$this->runtime[$model->alias]['query']['conditions'] = $commentcond;
			return $query;
		}
	}

/**
 * Describe afterFind
 *
 * @param $model
 * @param $results
 * @param $primary
 * @return null
 */
	public function afterFind(&$model,$results,$primary){
		if($model->recursive && is_array($results)){
			extract($this->settings[$model->alias]);
			$user=ClassRegistry::init('User','model');
			foreach($results as &$result){
				if(!isset($result[$model->alias][$model->primaryKey])){
					continue(1);
				}
				$commentcond=$this->runtime[$model->alias]['query']['conditions'];
				$commentcond['Comment.foreign_key']=$result[$model->alias][$model->primaryKey];
				$comment=$this->Comment->find('all',array('order'=>'Comment.updated desc','conditions'=>$commentcond));
				foreach($comment as $cid=>$cmt){
					$users=$user->find('first',array('fields'=>array('name','job_title'),'restrict'=>array('User'),'conditions'=>array('User.id'=>$comment[$cid]['Comment']['user_id'])));
					$comment[$cid]['Comment']['user_name']=$users['User']['name'];
					$comment[$cid]['Comment']['job_title']=$users['User']['job_title'];
				}
				if(empty($comment)){
					continue(1);
				}
				$result[$assocAlias]=$comment;
			}
		}
		return $results;
	}

/**
 * Describe beforeSave
 *
 * @param $model
 * @return null
 */
	public function beforeSave(&$model)
	{
		extract($this->settings[$model->alias]);
		if(isset($model->data[$assocAlias])){
			$this->runtime[$model->alias]['beforeSave'][$assocAlias] = $model->data[$assocAlias];
		}
		return true;
	}

/**
 * Describe afterSave
 *
 * @param $model
 * @param $created
 * @return null
 */
	public function afterSave(&$model,$created)
	{
		extract($this->settings[$model->alias]);
		if(!isset($this->runtime[$model->alias])){
			return true;
		}
		if(isset($this->runtime[$model->alias]['beforeSave'])){
			$data=$this->runtime[$model->alias]['beforeSave'];
			unset($this->runtime[$model->alias]['beforeSave']);

			foreach($data[$assocAlias] as &$comment) {
				if($created) {
					$comment['foreign_key'] = $model->getLastInsertID();
				} else {
					$comment['foreign_key'] = $model->id;
				}

				if(!isset($comment['id'])) {
					$this->Comment->create();
				}

				if(isset($model->curUser)){
					$comment['user_id']=$model->curUser;
				}

				$comment['model'] = $model->alias;
				$this->Comment->save($comment,false);
			}
		}
		return true;
	}
}

?>
