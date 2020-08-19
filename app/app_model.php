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

class AppModel extends Model 
{
	/**
	 * Define $actsAs
	 *
	 */
	var $actsAs = array('Containable','SoftDeletable');

	/**
	 * Describe checkUnique
	 *
	 * @param $data
	 * @param $fieldName
	 * @return null 
	 */
	function checkUnique($data, $fieldName) {
		$valid = false;
		if(isset($fieldName) && $this->hasField($fieldName))
		{
			$valid = $this->isUnique(array($fieldName => $data));
		}
		return $valid;
	} 

	/**
	 * Describe getData
	 *
	 * @param $fields
	 * @param $conditions
	 * @return null
	 */
	function getData($fields=array(),$conditions=array()){
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$queryData = array(
			'conditions'   => $conditions,
			'fields'       => $fields,
		);
		$data = $db->read($this, $queryData, false);
		return $data;
	}

	/**
	 * Returns a resultset array with DISTINCT fields from database matching given conditions.
	 *
	 * @param   mixed    $conditions SQL conditions as a string or as an array('field' =>'value',...)
	 * @param   mixed    $fields Either a single string of a field name, or an array of field names
	 * @return  array    Array of records
	 */
	/**
	 * Describe findDistinct
	 *
	 * @param $conditions
	 * @param $fields
	 * @return null
	 */
	function findDistinct($conditions = null, $fields = null)
	{
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		$order='';

		$str = 'DISTINCT ';
		if (!is_array($fields))
		{
			$str .= '`' . $fields . '`';
			$order=$fields;
		}
		else
		{
			foreach ($fields as $field)
			{
				$str .= '`' . $field . '`, ';
			}
			$str = substr($str, 0, -2);
		}
		$queryData = array(
			'conditions'   => $conditions,
			'fields'       => $str,
			'order'        => $order
		);
		$data = $db->read($this, $queryData, false);
		return $data;
	}

	/**
	 * Describe getWorkflowRule
	 *
	 * @param $item
	 * @return null
	 */
	function getWorkflowRule($item){
		/* Get the status of the item first */
		$wfstatus=ClassRegistry::init('Wfstatus','model');
		$dstatus=$wfstatus->find('first',array(
			'conditions'=>array('Wfstatus.model'=>$this->name,'Wfstatus.foreign_key'=>$item),
		));
		if($dstatus){
			return $dstatus['Workflow'];
		}
		return null;
	}

	/**
	 * Describe getTableRule
	 *
	 * @param $committee_id
	 * @return null
	 */
	function getTableRule($committee_id){
		$wfmodel=ClassRegistry::init('Wfmodel','model');
		$dmodel=$wfmodel->find('first',array(
			'conditions'=>array('model'=>$this->name,'committee_id'=>$committee_id),
		));
		if($dmodel){
			return $dmodel['Wfmodel'];
		}
		return null;
	}

	/**
	 * Describe checkWorkflowRule
	 *
	 * @param $rules
	 * @param $action
	 * @param $userdata
	 * @return null
	 */
	function checkWorkflowRule($rules,$action,$userdata=null){
		if(isset($rules[$action])){
			$wf2check=explode(',',$rules[$action]);
			if(!count($wf2check)){
				return false;
			}
			foreach($wf2check as $rule){
				$negate=false;
				$rule=trim($rule);
				if(substr($rule,0,1)=="!"){
					$negate=true;
					$rule=substr($rule,1);
				}
				if($rule=='all'){
					if($negate) return false; else return true;
				}
				if($rule=='owner' && isset($userdata['owner']) && $userdata['owner']){
					if($negate) return false; else return true;
				}
				if($rule=='invited' && isset($userdata['invited']) && $userdata['invited']){
					if($negate) return false; else return true;
				}
				if($rule=='attended' && isset($userdata['attended']) && $userdata['attended']){
					if($negate) return false; else return true;
				}
				if($pecah=explode(':',$rule)){
					if($pecah[0]=='role' && isset($userdata['role']) && $userdata['role']==$pecah[1]){
						if($negate) return false; else return true;
					}
					if($pecah[0]=='group' && isset($userdata['groups']) && in_array($pecah[1],$userdata['groups'])){
						if($negate) return false; else return true;
					}
				}
			}
		}
		return null;
	}

	/**
	 * Describe getAuthority
	 *
	 * @param $user_id
	 * @param $item
	 * @return null
	 */
	function getAuthority($user_id,$item){
		if($item){
			$wfrule=$this->getWorkflowRule($item);
			if($wfrule===null){
				return null;
			}
			else{
				$userdata=$this->userData($user_id,$item);
				$toret['view']=$this->checkWorkflowRule($wfrule,'view',$userdata);
				$toret['edit']=$this->checkWorkflowRule($wfrule,'edit',$userdata);
				$toret['delete']=$this->checkWorkflowRule($wfrule,'delete',$userdata);
				$toret['approve']=$this->checkWorkflowRule($wfrule,'approve',$userdata);
				$toret['disapprove']=$this->checkWorkflowRule($wfrule,'disapprove',$userdata);
				return $toret;
			}
		}
		return true;
	}

	/**
	 * Describe isAuthorized
	 *
	 * @param $user_id
	 * @param $action
	 * @param $item
	 * @param $committee_id
	 * @param $committee_roles
	 * @return null
	 */
	function isAuthorized($user_id,$action,$item=null,$committee_id=null,$committee_roles=null){
		if($item){ 
			/* Item id exists */
			$wfrule=null;
			if($action=='create'){
				/* Actually if you want to create, the item_id doesn't matter because you have to use committee_id to make sure you can create that model in that committee */
				if($committee_id){ 
					$wfrule=$this->getTableRule($committee_id);
				}
				else{
					return false;
				}
			}
			else{
				/* Get the workflow associated with the item_id */
				$wfrule=$this->getWorkflowRule($item);
			}
			if($wfrule===null){
				return true;
			}
			$userdata=array_merge($committee_roles,$this->userData($user_id,$item));
		}
		else{
			/* If the user didn't provide the item_id then they want to check the permission for that table */
			if($committee_id){
				$wfrule=$this->getTableRule($committee_id);
			}
			else{
				return false;
			}
			$userdata=$committee_roles;
		}
		return $this->checkWorkflowRule($wfrule,$action,$userdata);
	}

	/**
	 *
	 * Replace path in template with data from array
	 *
	 * @param string $template Template with all the placeholders to be replaced
	 * @param array  $data     Data to be replaced in the template
	 * @return string Template with all the placeholders replaced with whatever data available in array
	 *
	 */

	function replacetemplate($template,$data=null){
		preg_match_all('/(%[a-zA-Z._:]+)/',$template,$matches);
		foreach($matches[1] as $curmatch){
			$curmatch=substr($curmatch,1);
			// remove trailing . 
			if(substr($curmatch,-1,1)=='.' && Set::check($data,substr($curmatch,0,-1))){
				$curmatch=substr($curmatch,0,-1);
			}
			$fullmatch=$curmatch;
			// get the text to link to
			if(($pos=strpos($curmatch,':'))!==false){
				$text=substr($curmatch,$pos+1);
				$curmatch=substr($curmatch,0,$pos);
			}
			else{
				$text='address';
			}
			if(Set::check($data,$curmatch)){ 
				$replacedata=Set::classicExtract($data,$curmatch);
				if($curmatch=='Meeting.meeting_date' || $curmatch=='OldMeeting.meeting_date'){
					$ddate=strtotime($replacedata);
					$replacedata=sprintf(__('%s,%s',true),date(Configure::read('date_format'),$ddate),date(Configure::read('time_format'),$ddate));
				}
				elseif(strtolower(substr($curmatch,0,4))=='link'){ // if it's %Link.aaa:bbbb
					$server=Configure::read('server_url');
					if(substr($server,-1,1)=='/'){
						$server=substr($server,0,strlen($server)-1);
					}
					if(($pos=strpos($server,'://'))!==false){
						$protocol=substr($server,0,$pos).'://';
						$server=substr($server,$pos+3);
					}
					else{
						$protocol='http://';
					}
					if(strlen($server)<4 && isset($_SERVER['SERVER_NAME'])){
						$server=$_SERVER['SERVER_NAME'];
					}
					$address=$protocol.$server.Router::url($replacedata);
					if($text=='address') $text=$address;
					$replacedata="<a href='$address'>$text</a>";
				}
				$template=str_replace('%'.$fullmatch,$replacedata,$template);
			}
		}
		return $template;
	}
}
?>
