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

class Decision extends AppModel {

    /**
     * Defining the name of model
     *
     */
    var $name = 'Decision';
    /**
     * Defining the name of the table
     *
     */
    var $useTable = 'decisions';
    /**
     * Defining behavior in the model
     *
     */
    var $actsAs = array('MultiFile','Comment','Workflow','Containable');

    //The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * Building assosiations betweeen models
     *
     */
    var $belongsTo = array(
        'Committee' => array(
            'className' => 'Committee',
            'foreignKey' => 'committee_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''),
        'Meeting' => array(
            'className' => 'Meeting',
            'foreignKey' => 'meeting_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''),
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => '')
        );

    /**
     * Build the association between the Decision and Userstatus,Decision and Groupstatus
     *
     */
    var $hasMany = array(
        'Userstatus' => array(
            'className' => 'Userstatus',
            'foreignKey' => 'decision_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'group'=>'Decision.user_id',
            'order' => 'Userstatus.updated desc',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Groupstatus' => array(
            'className' => 'Groupstatus',
            'foreignKey' => 'decision_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'group'=>'Decision.group_id',
            'order' => 'Groupstatus.updated desc',
            'limit' => 1,
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '')
        );

    /**
     * Building assosiations betweeen models
     *
     */
    var $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'decisions_users',
            'foreignKey' => 'decision_id',
            'associationForeignKey' => 'user_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''),
        'Group' => array(
            'className' => 'Group',
            'joinTable' => 'decisions_groups',
            'foreignKey' => 'decision_id',
            'associationForeignKey' => 'group_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => '')
        );

    /**
     * Finding all the related users defined by the decicion id
     * $param decision_id finds all the related users
     */
    function getUser($id){
        $ddat=mysql_fetch_assoc(mysql_query("select name, job_title from users where id=$id"));
        return $ddat;
    }

    /**
     * Finding all the users decisions defined by the decision id
     * $param decision_id and user_id finds all the related users decisions
     */
    function individualImplementors($id){
        return Set::extract($this->DecisionsUser->getData(array('user_id'),array('decision_id'=>$id)),'{n}.DecisionsUser.user_id');
    }

    /**
     * Finding all the groups decisions defined by the decision id
     * $param decision_id and group_id finds all the related groups decisions
     */
    function groupImplementors($id){
        return Set::extract($this->DecisionsGroup->getData(array('group_id'),array('decision_id'=>$id)),'{n}.DecisionsGroup.group_id');
    }

    /**
     * Getting all the meeting_id defined by the decision id
     * $param decision_id finds all the meeting_id
     */
    function getMeetingId($decision_id){
        $data=$this->getData(array('meeting_id'),array('id'=>$decision_id));
        if(isset($data[0]['Decision']['meeting_id'])){
            return $data[0]['Decision']['meeting_id'];
        }
        else{
            return false;
        }
    }

    /**
     * Getting all the committee_id defined by the decision id
     * $param decision_id and user_id finds all the related decision users
     */
    function getCommitteeId($decision_id){
        return $this->Meeting->getCommitteeId($this->getMeetingId($decision_id));
    }

    /**
     * Finding all the user data defined by the user_id and decision_id
     * $param decision_id and user_id finds all the related user data
     */
    function userData($user_id,$decision_id){
        $meeting_id=$this->getMeetingId($decision_id);
        $toret=$this->Meeting->userData($user_id,$meeting_id);
        return $toret;
    }

    function getMinutes($text){
        $pattern='style="[^"]*"';
        $replacement='';
        $text=eregi_replace($pattern,$replacement,$text);
        $decisions=explode("###",$text);
        $implpattern="|{{(.*)}}|sU";
        foreach($decisions as $curdecision){
            $numimpl=preg_match_all($implpattern,$curdecision,$implname);
            if($numimpl){
                $toret[]=trim($curdecision);
            }
        }
        if(isset($toret)){
            return $toret;
        }
        else{
            return false;
        }
    }

    /**
     * Finding all the minutes
     *
     * Will try to find all the minutes in a html formatted text. 
     * Minutes are defined as an item which contains at least 
     * one reference to the user (ie: find {{username}} enclosed in a pair of ###)
     *
     * @param text - The raw data (html formatted) where the decision might come from
     * @return array containing all the minutes extracted where each row is 1 minute
     *
     */
    function extractMinutes($text){
        $dcurdat=null;
        $decisions=$this->getMinutes($text);
        foreach($decisions as $draw){
            $ddat=strip_tags($draw,'<li><p><br>');
            $projpattern="|\[\[(.*)\]\]|sU";
            $implpattern="|{{(.*)}}|sU";
            $dtlnpattern="|\(\((.*)\)\)|sU";
            $numproject=preg_match($projpattern,$ddat,$projectname);
            if($numproject){
                $curdat['Item']=$projectname[1];
            }
            else{
                $curdat['Item']=null;
            }
            $numimpl=preg_match_all($implpattern,$ddat,$implname);
            if($numimpl){
                if(isset($dnames)) unset($dnames);
                foreach($implname[1] as $imname){
                    if(isset($dnames)){
                        $dnames=array_merge($dnames,explode(',',$imname));
                    }
                    else{
                        $dnames=explode(',',$imname);
                    }
                }
                $curdat['User']=array_merge($dnames);
            }
            else{
                $curdat['User']=null;
            }
            $numdtln=preg_match($dtlnpattern,$ddat,$dtlnname);
            if($numdtln){
                $curdat['Dateline']=$dtlnname[1];
            }
            else{
                $curdat['Dateline']=null;
            }
            $eddat=preg_replace($implpattern,"\$1",$ddat);
            $eddat=preg_replace($projpattern,"\$1",$eddat);
            $eddat=preg_replace($dtlnpattern,"\$1",$eddat);
            $curdat['Decision']=$eddat;
            $curdat['OriDecision']=$draw;
            $dcurdat[]=$curdat;
        }
        return $dcurdat;
    }

    /* Extract data from text. Legend is:
     * ### is decision separator.
     * [[project/item]] 
     * {{implementor}}
     * ((dateline))
     */
    function extractText($text){
        $decisions=explode("###",$text);
        foreach($decisions as $ddat){
            $projpattern="|\[\[(.*)\]\]|U";
            $implpattern="|{{(.*)}}|U";
            $dtlnpattern="|\(\((.*)\)\)|U";
            $numproject=preg_match($projpattern,$ddat,$projectname);
            if($numproject){
                $curdat['Item']=$projectname[1];
            }
            else{
                $curdat['Item']=null;
            }
            $numimpl=preg_match_all($implpattern,$ddat,$implname);
            if($numimpl){
                if(isset($dnames)) unset($dnames);
                foreach($implname[1] as $imname){
                    if(isset($dnames)){
                        $dnames=array_merge($dnames,explode(',',$imname));
                    }
                    else{
                        $dnames=explode(',',$imname);
                    }
                }
                $curdat['User']=array_merge($dnames);
            }
            else{
                $curdat['User']=null;
            }
            $numdtln=preg_match($dtlnpattern,$ddat,$dtlnname);
            if($numdtln){
                $curdat['Dateline']=$dtlnname[1];
            }
            else{
                $curdat['Dateline']=null;
            }
            $eddat=preg_replace($implpattern,"\$1",$ddat);
            $eddat=preg_replace($projpattern,"\$1",$eddat);
            $eddat=preg_replace($dtlnpattern,"\$1",$eddat);
            $curdat['Decision']=$eddat;
            $dcurdat[]=$curdat;
        }
        return $dcurdat;
    }

    function itemList($data,$committee_id){
        $defaultlist=Set::extract($this->Item->find('all',array('contain'=>false,'fields'=>array('id','short_name'),'conditions'=>array('committee_id'=>$committee_id))),'{n}.Item');
        foreach($data as $cid=>$curdat){
            $items=$curdat['Item'];
            if(count($items)){
                //we have found something so lets fixup the line of items
                if(isset($curret)) unset($curret);
                foreach($items as $citem){
                    $cur['id']=$citem['Item']['id'];
                    $cur['short_name']=$citem['Item']['short_name'];
                    $curret[]=$cur;
                }
                $thislist=Set::extract($this->Item->find('all',array('contain'=>false,'fields'=>array('id','short_name'),'conditions'=>array('committee_id'=>$committee_id,'not'=>array('id'=>Set::extract($curret,'{n}.id'))))),'{n}.Item');
                $data[$cid]['Item']=array_merge($curret,$thislist);
            }
            else{
                //we found nothing before this. Just get the whole amount of items
                $data[$cid]['Item']=$defaultlist;
                $data[$cid]['noitem']=true;
            }
        }
        return $data;
    }

    function groupList($data,$committee_id){
        $defaultlist=Set::extract($this->Group->find('all',array('contain'=>false,'fields'=>array('id','name'),'conditions'=>array('committee_id'=>$committee_id))),'{n}.Group');
        foreach($data as $cid=>$curdat){
            $groups=$curdat['Group'];
            if(count($groups)){
                foreach($groups as $uid=>$udata){
                    if(count($udata)){
                        //we have found something so lets fixup the line of groups
                        if(isset($curret)) unset($curret);
                        foreach($udata as $cuser){
                            $cur['id']=$cuser['Group']['id'];
                            $cur['name']=$cuser['Group']['name'];
                            $curret[]=$cur;
                        }
                        $thislist=Set::extract($this->Group->find('all',array(
                            'contain'=>false,
                            'fields'=>array('id','name'),
                            'conditions'=>array(
                                'committee_id'=>$committee_id,
                                'not'=>array('id'=>Set::extract($curret,'{n}.id')),
                            )
                        )),'{n}.Group');
                        $data[$cid]['Group'][$uid]=array_merge($curret,$thislist);
                    }
                    else{
                        //we found nothing before this. Just get the whole amount of groups
                        $data[$cid]['Group'][$uid]=$defaultlist;
                        $data[$cid]['nogroup'][$uid]=true;
                    }
                }
            }
        }
        return $data;
    }

    function userList($data,$committee_id){
        $defaultlist=Set::extract($this->Committee->find('all',array(
            'contain'=>array(
                'User'=>array(
                    'fields'=>array('id','name'),
                    'order'=>array('name'),
                ),
            ),
            'conditions'=>array(
                'id'=>$committee_id,
            )
        )),'{n}.User');
        $defaultlist=$defaultlist[0];
        foreach($defaultlist as $cid=>$cdata){
            unset($defaultlist[$cid]['Membership']);
        }
        foreach($data as $cid=>$curdat){
            $users=$curdat['User'];
            if(count($users)){
                foreach($users as $uid=>$udata){
                    if(count($udata)){
                        //we have found something so lets fixup the line of users
                        if(isset($curret)) unset($curret);
                        foreach($udata as $cuser){
                            $cur['id']=$cuser['User']['id'];
                            $cur['name']=$cuser['User']['name'];
                            $curret[]=$cur;
                        }
                        $thislist=Set::extract($this->Committee->find('all',array(
                            'contain'=>array(
                                'User'=>array(
                                    'fields'=>array('id','name'),
                                    'order'=>array('name'),
                                    'conditions'=>array('not'=>array('User.id'=>Set::extract($curret,'{n}.id'))),
                                ),
                            ),
                            'conditions'=>array(
                                'id'=>$committee_id,
                            )
                        )),'{n}.User');
                        $thislist=$thislist[0];
                        foreach($thislist as $xjcid=>$xjcdata){
                            unset($thislist[$xjcid]['Membership']);
                        }
                        $data[$cid]['User'][$uid]=array_merge($curret,$thislist);
                    }
                    else{
                        //we found nothing before this. Just get the whole amount of users
                        $data[$cid]['User'][$uid]=$defaultlist;
                        $data[$cid]['nouser'][$uid]=true;
                    }
                }
            }
        }
        return $data;
    }


    function filterData($data,$meeting_id=null){
        $comid=$this->Meeting->getCommitteeId($meeting_id);
        $allret=array();
        foreach($data as &$cdat){
            /* Get all the possible items first. Search by short name first then by name.Filter by committee_id */
            if($cdat['Item']){
                $cdat['Item']=trim($cdat['Item']);
                $ditem=$this->Item->getData(array('id','short_name','name'),array('committee_id'=>$comid,'or'=>array('short_name like \'%'.$cdat['Item'].'%\'','name like \'%'.$cdat['Item'].'%\'')));
                if(count($ditem)){
                    $retdat['Item']=$ditem;
                }
                else{
                    /*didn't find any item/projects. Try harder. Maybe the user misspelled parts of the name. Break the data into 4 parts and check for each part*/
                    $partlen=strlen($cdat['Item'])/4;
                    if($partlen>1){  //only search if it is worth it
                        $part[0]=substr($cdat['Item'],0,$partlen);
                        $part[1]=substr($cdat['Item'],$partlen,$partlen);
                        for($i=0;$i<4;$i++){
                            $part[$i]=substr($cdat['Item'],$i*$partlen,($i+1)*$partlen);
                            $dsql[]='short_name like \'%'.$part[$i].'%\'';
                            $dsql[]='name like \'%'.$part[$i].'%\'';
                            $dcond[]=array('or'=>$dsql);
                            unset($dsql);
                        }
                        $ditem=$this->Item->getData(array('id','short_name','name'),array('committee_id'=>$comid,'or'=>$dcond));
                        $retdat['Item']=$ditem;
                    }
                    else{
                        $retdat['Item']=null;
                    }
                    unset($dcond);
                }
                if(strlen($cdat['Item'])>1){
                    $retdat['LostItem']=$cdat['Item'];
                }
                else{
                    $retdat['LostItem']=null;
                }
            }
            else{
                $retdat['Item']=null;
                $retdat['LostItem']=null;
            }

            /* Look for users */
            if(isset($puser)) unset($puser);
            $comuser=Set::extract($this->User->Membership->getData(array('user_id'),array('committee_id'=>$comid)),'{n}.Membership.user_id');
            if(isset($cdat['User']) && count($cdat['User'])){
                foreach($cdat['User'] as $cuser){
                    $cuser=trim($cuser);
                    $source="user";
                    if(substr(strtolower($cuser),0,2)=="g:"){
                        $source="group";
                        $cuser=substr($cuser,2);
                    }
                    if($source=="user"){
                        $dname=$this->User->getData(array('id','name'),array('id'=>$comuser,'or'=>array('username like \'%'.$cuser.'%\'','name like \'%'.$cuser.'%\'')));
                        $found=false;
                        if(count($dname)){
                            $puser[]=$dname;
                            $found=true;
                        }
                        else{
                            /*didn't find any users. Try harder. Maybe the user misspelled parts of the name. Break the data into 4 parts and check for each part*/
                            $partlen=strlen($cuser)/4;
                            if($partlen>1){
                                $part[0]=substr($cuser,0,$partlen);
                                $part[1]=substr($cuser,$partlen,$partlen);
                                for($i=0;$i<4;$i++){
                                    $part[$i]=substr($cuser,$i*$partlen,($i+1)*$partlen);
                                    $dsql[]='username like \'%'.$part[$i].'%\'';
                                    $dsql[]='name like \'%'.$part[$i].'%\'';
                                    $dcond[]=array('or'=>$dsql);
                                    unset($dsql);
                                }
                                $ditem=$this->User->getData(array('id','name'),array('id'=>$comuser,'or'=>$dcond));
                                if(count($ditem)){
                                    $puser[]=$ditem;
                                    $found=true;
                                }
                            }
                            unset($dcond);
                        }
                        if(!$found){
                            $puser[]=null;
                        }
                    }
                    else{
                        $dgroup=$this->Group->getData(array('id','name'),array('committee_id'=>$comid,'name like \'%'.$cuser.'%\''));
                        $found=false;
                        if(count($dgroup)){
                            $pgroup[]=$dgroup;
                            $found=true;
                        }
                        else{
                            /*didn't find any users. Try harder. Maybe the user misspelled parts of the name. Break the data into 4 parts and check for each part*/
                            $partlen=strlen($cuser)/4;
                            if($partlen>1){
                                $part[0]=substr($cuser,0,$partlen);
                                $part[1]=substr($cuser,$partlen,$partlen);
                                for($i=0;$i<4;$i++){
                                    $part[$i]=substr($cuser,$i*$partlen,($i+1)*$partlen);
                                    $dsql[]='name like \'%'.$part[$i].'%\'';
                                    $dcond[]=array('or'=>$dsql);
                                    unset($dsql);
                                }
                                $ditem=$this->Group->getData(array('id','name'),array('committee_id'=>$comid,'or'=>$dcond));
                                if(count($ditem)){
                                    $pgroup[]=$ditem;
                                    $found=true;
                                }
                            }
                            unset($dcond);
                        }
                        if(!$found){
                            $pgroup[]=null;
                        }
                    }
                }
            }
            if(isset($puser)){
                $retdat['User']=$puser;
                unset($puser);
            }
            else{
                $retdat['User']=null;
            }
            if(isset($pgroup)){
                $retdat['Group']=$pgroup;
                unset($pgroup);
            }
            else{
                $retdat['Group']=null;
            }

            /* The date has to be translated into something the system can use */
            $ddate=$this->translateDate($cdat['Dateline']);
            $retdat['Dateline']=$ddate;
            $retdat['Decision']=$cdat['Decision'];
            $retdat['OriDecision']=$cdat['OriDecision'];
            $allret[]=$retdat;
        }
        return $allret;
    }


    function translateDate($date){
        /* Just return it back for now */
        $delimiter=array('/','-');
        foreach($delimiter as $d){
            if(strpos($date,$d)!==false){
                $limit=$d;
                break;
            }
        }
        if(isset($limit)){
            $parts=explode($limit,$date);
            if(count($parts)==3){
                if(strlen($parts[0])==2 && strlen($parts[2])==4){   //correct length of parts but the other way around
                    $tmp=$parts[0];
                    $parts[0]=$parts[2];
                    $parts[2]=$tmp;
                    return implode('-',$parts);
                }
                elseif(strlen($parts[2])==2 && strlen($parts[0])==4){  //correct length and right order
                    return implode('-',$parts);
                }
                else{  //else assume short malaysian way of writing date (ie dd/mm/yy)
                    $tmp=$parts[0];
                    $parts[0]=$parts[2];
                    $parts[2]=$tmp;
                    $parts[0]='20'.$parts[0];
                    return implode('-',$parts);
                }
            }
        }
        return false;
    }

    /**
     * Getting the current userstatus and groupstatusfor the decision
     */
    function getCurrentStatus($id){
        $prefix=$this->tablePrefix;
        $finder= 'SELECT `Userstatus`.`id`, `Userstatus`.`decision_id`, `Userstatus`.`user_id`, `Userstatus`.`description`, `Userstatus`.`action_date`, `Userstatus`.`deleted`, `Userstatus`.`deleted_date`, `Userstatus`.`created`, `Userstatus`.`updated`, `User`.`id`, `User`.`username`, `User`.`superuser`, `User`.`job_title`, `User`.`name`, `User`.`email`, `User`.`telephone`, `User`.`mobile`, `User`.`fax`, `User`.`address`, `User`.`title_id`, `User`.`deleted`, `User`.`deleted_date` FROM `'.$prefix.'userstatuses` AS `Userstatus` LEFT JOIN `'.$prefix.'decisions` AS `Decision` ON (`Userstatus`.`decision_id` = `Decision`.`id`) LEFT JOIN `'.$prefix.'users` AS `User` ON (`Userstatus`.`user_id` = `User`.`id`) LEFT OUTER JOIN `'.$prefix.'userstatuses` as `s2` on (`Userstatus`.`user_id`=`s2`.`user_id` and `Userstatus`.`updated`<`s2`.`updated` and `Userstatus`.`decision_id`=`s2`.`decision_id`) WHERE `Userstatus`.`decision_id` = {$__cakeID__$} and `s2`.`id` is null';
        $gfinder= 'SELECT `Groupstatus`.`id`, `Groupstatus`.`decision_id`, `Groupstatus`.`user_id`, `Groupstatus`.`group_id`, `Groupstatus`.`description`, `Groupstatus`.`action_date`, `Groupstatus`.`deleted`, `Groupstatus`.`deleted_date`, `Groupstatus`.`created`, `Groupstatus`.`updated`, `Group`.`id`, `Group`.`name`, `User`.`id`, `User`.`username`, `User`.`superuser`, `User`.`job_title`, `User`.`name`, `User`.`email`, `User`.`telephone`, `User`.`mobile`, `User`.`fax`, `User`.`address`, `User`.`title_id`, `User`.`deleted`, `User`.`deleted_date` FROM `'.$prefix.'groupstatuses` AS `Groupstatus` LEFT JOIN `'.$prefix.'decisions` AS `Decision` ON (`Groupstatus`.`decision_id` = `Decision`.`id`) LEFT JOIN `'.$prefix.'users` AS `User` ON (`Groupstatus`.`user_id` = `User`.`id`) LEFT JOIN `'.$prefix.'groups` AS `Group` ON (`Groupstatus`.`group_id` = `Group`.`id`) LEFT OUTER JOIN `'.$prefix.'groupstatuses` as `s2` on (`Groupstatus`.`group_id`=`s2`.`group_id` and `Groupstatus`.`updated`<`s2`.`updated` and `Groupstatus`.`decision_id`=`s2`.`decision_id`) WHERE `Groupstatus`.`decision_id` = {$__cakeID__$} and `s2`.`id` is null';
        $this->bindModel(
            array(
                'hasMany'=>array(
                    'Userstatus'=>array(
                        'className' => 'Userstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $finder,
                        'counterQuery' => ''),
                    'Groupstatus'=>array(
                        'className' => 'Groupstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $gfinder,
                        'counterQuery' => '')
                    )
                )
            );
        return $this->read(null, $id);
    }


    /**
     * Bind the decision model to select only the latest status from each user and group
     */
    function bindLatest(){
        $db =& ConnectionManager::getDataSource($this->useDbConfig);
        $finder= 'SELECT `Userstatus`.`id`, `Userstatus`.`decision_id`, `Userstatus`.`user_id`, `Userstatus`.`description`, `Userstatus`.`action_date`, `Userstatus`.`deleted`, `Userstatus`.`deleted_date`, `Userstatus`.`created`, `Userstatus`.`updated`, `User`.`id`, `User`.`username`, `User`.`superuser`, `User`.`job_title`, `User`.`name`, `User`.`email`, `User`.`telephone`, `User`.`mobile`, `User`.`fax`, `User`.`address`, `User`.`title_id`, `User`.`deleted`, `User`.`deleted_date` FROM '.$db->fullTableName('userstatuses').' AS `Userstatus` LEFT JOIN '.$db->fullTableName('decisions').' AS `Decision` ON (`Userstatus`.`decision_id` = `Decision`.`id`) LEFT JOIN '.$db->fullTableName('users').' AS `User` ON (`Userstatus`.`user_id` = `User`.`id`) LEFT OUTER JOIN '.$db->fullTableName('userstatuses').' as `s2` on (`Userstatus`.`user_id`=`s2`.`user_id` and `Userstatus`.`updated`<`s2`.`updated` and `Userstatus`.`decision_id`=`s2`.`decision_id`) WHERE `Userstatus`.`decision_id` in ( {$__cakeID__$} ) and `s2`.`id` is null';
        $gfinder= 'SELECT `Groupstatus`.`id`, `Groupstatus`.`decision_id`, `Groupstatus`.`user_id`, `Groupstatus`.`group_id`, `Groupstatus`.`description`, `Groupstatus`.`action_date`, `Groupstatus`.`deleted`, `Groupstatus`.`deleted_date`, `Groupstatus`.`created`, `Groupstatus`.`updated`, `Group`.`id`, `Group`.`name`, `User`.`id`, `User`.`username`, `User`.`superuser`, `User`.`job_title`, `User`.`name`, `User`.`email`, `User`.`telephone`, `User`.`mobile`, `User`.`fax`, `User`.`address`, `User`.`title_id`, `User`.`deleted`, `User`.`deleted_date` FROM '.$db->fullTableName('groupstatuses').' AS `Groupstatus` LEFT JOIN '.$db->fullTableName('decisions').' AS `Decision` ON (`Groupstatus`.`decision_id` = `Decision`.`id`) LEFT JOIN '.$db->fullTableName('users').' AS `User` ON (`Groupstatus`.`user_id` = `User`.`id`) LEFT JOIN '.$db->fullTableName('groups').' AS `Group` ON (`Groupstatus`.`group_id` = `Group`.`id`) LEFT OUTER JOIN '.$db->fullTableName('groupstatuses').' as `s2` on (`Groupstatus`.`group_id`=`s2`.`group_id` and `Groupstatus`.`updated`<`s2`.`updated` and `Groupstatus`.`decision_id`=`s2`.`decision_id`) WHERE `Groupstatus`.`decision_id` in ( {$__cakeID__$} ) and `s2`.`id` is null';
        $this->bindModel(
            array(
                'hasMany'=>array(
                    'Userstatus'=>array(
                        'className' => 'Userstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $finder,
                        'counterQuery' => ''),
                    'Groupstatus'=>array(
                        'className' => 'Groupstatus',
                        'foreignKey' => 'decision_id',
                        'dependent' => false,
                        'conditions' => '',
                        'fields' => '',
                        'order' => '',
                        'limit' => '',
                        'offset' => '',
                        'exclusive' => '',
                        'finderQuery' => $gfinder,
                        'counterQuery' => '')
                    )
                )
            );
    }

    /**
     * Finding all the search
     */
    function search($field) {

        $decision=array();
        if (isset($field['item']) && !empty($field['item'])) {
            $add_cond = array('Decision.meeting_id'=>$field['meeting_id']);
            $add_cond['Decision.item_id'] = $field['item'];
            $decision=$this->find('all',array('conditions'=>$add_cond));
        }

        if (isset($field['meeting']) && !empty($field['meeting'])) {
            $add_cond = array('Decision.item_id'=>$field['item_id']);
            $add_cond['Decision.meeting_id'] = $field['meeting'];
            $decision=$this->find('all',array('conditions'=>$add_cond));
        }
        if (isset($field['group']) && !empty($field['group'])) {

            // find all decisions assigned to the group selected
            $sql = "select *
                from (decisions as Decision, meetings as Meeting, items as Item, decisions_groups as DecisionsGroup, groups as `Group`)
                left join groupstatuses as Groupstatus on (Groupstatus.group_id=Group.id and Decision.id=Groupstatus.decision_id)
                where Decision.item_id=Item.id and Meeting.id=Decision.meeting_id 
                and Decision.id=DecisionsGroup.decision_id and `Group`.id=DecisionsGroup.group_id and `Group`.id='".$field['group']."'";
            if ($field['from']=='items/view')    
                $sql.= " and Decision.item_id='".$field['item_id']."'";
            else if ($field['from']=='meetings/view')
                $sql.= " and Decision.meeting_id='".$field['meeting_id']."'";
            $decision=$this->query($sql);

            // find other assigned groups - for display purposes
            $sql2 = "select * from decisions_groups as DecisionsGroup, groups as `Group`, decisions as Decision
                where `Group`.id=DecisionsGroup.group_id and Decision.id=DecisionsGroup.decision_id
                and `Group`.id!='".$field['group']."'";
            if ($field['from']=='items/view')    
                $sql.= " and Decision.item_id='".$field['item_id']."'";
            else if ($field['from']=='meetings/view')
                $sql.= " and Decision.meeting_id='".$field['meeting_id']."'";
            $decision2=$this->query($sql2);

            foreach ($decision as $key=>$value) { 
                $decision[$key]['User']=array(); // create empty array 
                $decision[$key]['Userstatus']=array(); // create empty array
                $decision[$key]['Group']['DecisionGroup']=$decision[$key]['DecisionsGroup']; // bring DG under Group
                $decision[$key]['Group'] = array($decision[$key]['Group']); // [Group] is set of arrays
                foreach ($decision2 as $dec) { 
                    // if decision is assigned to >1 group, append the array under [Group]
                    if ($dec['Decision']['id']==$decision[$key]['Decision']['id'] ) {
                        $dec['Group']['DecisionsGroup'] = $dec['DecisionsGroup'];
                        array_push($decision[$key]['Group'],$dec['Group']);
                    }
                }
                unset($decision[$key]['DecisionsGroup']);
                // if no update, create empty array 
                if ($decision[$key]['Groupstatus']['id'] == '' ) {
                    $decision[$key]['Groupstatus'] = array();
                }
            }
        }
        if (isset($field['user']) && !empty($field['user'])) {

            // find all decisions assigned to user selected
            $sql = "select *
                from (decisions as Decision, meetings as Meeting, items as Item, decisions_users as DecisionsUser, users as User)
                left join userstatuses as Userstatus on (Userstatus.user_id=User.id and Decision.id=Userstatus.decision_id)
                where Decision.item_id=Item.id and Meeting.id=Decision.meeting_id
                and Decision.id=DecisionsUser.decision_id and User.id=DecisionsUser.user_id and User.id='".$field['user']."'
                ";                 
            if ($field['from']=='items/view')    
                $sql.= " and Decision.item_id='".$field['item_id']."'";
            else if ($field['from']=='meetings/view')
                $sql.= " and Decision.meeting_id='".$field['meeting_id']."'";
            $decision=$this->query($sql);

            // find other assigned users - for display purposes
            $sql2 = "select * from decisions_users as DecisionsUser, users as User, decisions as Decision
                where User.id=DecisionsUser.user_id and Decision.id=DecisionsUser.decision_id
                and User.id!='".$field['user']."'";
            if ($field['from']=='items/view')    
                $sql.= " and Decision.item_id='".$field['item_id']."'";
            else if ($field['from']=='meetings/view')
                $sql.= " and Decision.meeting_id='".$field['meeting_id']."'";
            $decision2=$this->query($sql2);

            foreach ($decision as $key=>$value) { 
                $decision[$key]['Group']=array(); // create empty array 
                $decision[$key]['Groupstatus']=array(); // create empty array
                $decision[$key]['User']['DecisionsUser']=$decision[$key]['DecisionsUser']; // bring DG under Group
                $decision[$key]['User'] = array($decision[$key]['User']); // [Group] is set of arrays
                foreach ($decision2 as $dec) { 
                    // if decision is assigned to >1 group, append the array under [Group]
                    if ($dec['Decision']['id']==$decision[$key]['Decision']['id'] ) {
                        $dec['User']['DecisionsUser'] = $dec['DecisionsUser'];
                        array_push($decision[$key]['User'],$dec['User']);
                    }
                }
                unset($decision[$key]['DecisionsUser']);

                // if no update, create empty array 
                if ($decision[$key]['Userstatus']['id'] == '' ) {
                    $decision[$key]['Userstatus'] = array();
                }
            }

        }
        //echo "<pre>".print_r($decision,true)."</pre>";
        return $decision;
    }

    function promote($id){
        $this->unbindModel(array('hasAndBelongsToMany'=>array('User','Group')),false);
        $decision=$this->find('first',array(
            'conditions'=>array(
                'Decision.id'=>$id,
            )
        ));
        $prevnumber=$this->find('first',array(
            'conditions'=>array(
                'Decision.meeting_id'=>$decision['Decision']['meeting_id'],
                'Decision.ordering<'.$decision['Decision']['ordering'],
            ),
            'order'=>array(
                'Decision.ordering desc'
            ),
            'contain'=>false,
            'fields'=>array(
                'ordering',
            ),
        ));
        if($prevnumber['Decision']['ordering']<$decision['Decision']['ordering']){
            $prev=$this->find('all',array(
                'conditions'=>array(
                    'Decision.meeting_id'=>$decision['Decision']['meeting_id'],
                    'Decision.ordering'=>$prevnumber['Decision']['ordering'],
                )
            ));
            if(count($prev)==1){
                $prev[0]['Decision']['ordering']=$decision['Decision']['ordering'];
                $this->save($prev[0]);
                $decision['Decision']['ordering']=$prevnumber['Decision']['ordering'];
                $this->save($decision);
            }
            else{
                $decision['Decision']['ordering']=$prevnumber['Decision']['ordering']-1;
                $this->save($decision);
            }
        }
        else{
            $decision['Decision']['ordering']-=1;
            $this->save($decision);
        }
    }

    function demote($id){
        $this->unbindModel(array('hasAndBelongsToMany'=>array('User','Group')),false);
        $decision=$this->find('first',array(
            'conditions'=>array(
                'Decision.id'=>$id,
            )
        ));
        $nextnumber=$this->find('first',array(
            'conditions'=>array(
                'Decision.meeting_id'=>$decision['Decision']['meeting_id'],
                'Decision.ordering>'.$decision['Decision']['ordering'],
            ),
            'order'=>array(
                'Decision.ordering asc'
            ),
            'contain'=>false,
            'fields'=>array(
                'ordering',
            ),
        ));
        if($nextnumber['Decision']['ordering']>$decision['Decision']['ordering']){
            $next=$this->find('all',array(
                'conditions'=>array(
                    'Decision.meeting_id'=>$decision['Decision']['meeting_id'],
                    'Decision.ordering'=>$nextnumber['Decision']['ordering'],
                )
            ));
            if(count($next)==1){
                $next[0]['Decision']['ordering']=$decision['Decision']['ordering'];
                $this->save($next[0]);
                $decision['Decision']['ordering']=$nextnumber['Decision']['ordering'];
                $this->save($decision);
            }
            else{
                $decision['Decision']['ordering']=$nextnumber['Decision']['ordering']+1;
                $this->save($decision);
            }
        }
        else{
            $decision['Decision']['ordering']+=1;
            $this->save($decision);
        }
    }

    function notifyuser($id){
        if(!isset($this->Template)){
            App::import('Model','Template');
            $this->Template=& ClassRegistry::init('Template');
        }
        if(!isset($this->Notification)){
            App::import('Model','Notification');
            $this->Notification=& ClassRegistry::init('Notification');
        }
        $decision=$this->find('first',array(
            'conditions'=>array(
                'Decision.id'=>$id,
            ),
        ));
        $template=$this->Template->find('first',array('conditions'=>array('model'=>'Meeting','foreign_key'=>$decision['Decision']['meeting_id'],'type'=>'decision assigned')));
        if(!$template){
            $template=$this->Template->find('first',array('conditions'=>array('model'=>'Committee','foreign_key'=>$decision['Decision']['committee_id'],'type'=>'decision assigned')));
        }
        if($template){
            $decision['Link']['decision']=array('committee'=>urlencode($decision['Committee']['short_name']),'controller'=>'decisions','action'=>'view','id'=>$id);
            $template['Template']['template']=$this->replacetemplate($template['Template']['template'],$decision);
            $notification['Notification']['meeting_id']=$decision['Decision']['meeting_id'];
            $notification['Notification']['type']=$template['Template']['type'];
            $notification['Notification']['notification_date']=date("Y-m-d H:i:s");
            $notification['Notification']['message_title']=$template['Template']['title'];
            $users=$this->individualImplementors($id);
            $groups=$this->groupImplementors($id);
            foreach($groups as $group){
                $gusers=$this->User->Group->find('first',array('conditions'=>array('Group.id'=>$group)));
                foreach($gusers['User'] as $dguser){
                    if(!in_array($dguser['id'],$users)){
                        $users[]=$dguser['id'];
                    }
                }
            }
            foreach($users as $userid){
                $user=$this->Meeting->User->find('first',array('fields'=>array('name','email'),'conditions'=>array('User.id'=>$userid)));
                $data['name']=$user['User']['name'];
                $notification['Notification']['message']=$this->replacetemplate($template['Template']['template'],$data);
                $notification['Notification']['to']=$user['User']['email'];
                $this->Notification->create();
                $this->Notification->save($notification);
            }
        }
    }
}
?>
