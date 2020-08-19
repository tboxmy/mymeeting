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

class AppController extends Controller {
    /**
     * Define $components
     *
     */
    var $components = array('Acl','Auth','p28n');
    /**
     * Define $uses
     *
     */
    var $uses = array('Committee','Log','User');

    var $dcommittee = null;
    /**
     * Describe idFromShortName
     *
     * @param $shortname
     * @return null
     */
    function idFromShortName($shortname){
        $ddat=$this->Committee->getData(array('id'),array('short_name'=>$shortname));
        if(count($ddat)>1){
            $this->Session->setFlash(__('There appears to be more than 1 committee with that name'));
            $this->redirect(array('controller'=>'committees','action'=>'mainpage'));
        }
        elseif(count($ddat)==1){
            return $ddat[0]['Committee']['id'];
        }
        else{
            $this->Session->setFlash(__('Please select a valid committee'));
            $this->redirect(array('controller'=>'committees','action'=>'mainpage'));
        }
    }
    
    function writelog($class=null,$method=null,$msg=null) {
        $user = $this->Auth->user('id');
        // save to db
        if(isset($this->params['url']['url']) && $this->params['controller']!='ajaxes'){
            $curlog['user_id']=$user;
            $curlog['controller']=$this->params['controller'];
            $curlog['action']=$this->params['action'];
            if(isset($this->params['id'])) $curlog['targetid']=$this->params['id'];
            if(isset($this->params['pass']['0'])) $curlog['targetid']=$this->params['pass']['0'];
            $curlog['url']=$this->params['url']['url'];
            $curlog['timestamp']=date('Y-m-d H:i:s');
            $curlog['message']="[$class $method $user] $msg";
            $this->Log->create();
            $this->Log->save($curlog);
        }
        // save to debug.log
        if ($msg)
            $this->log("[$class $method $user] $msg", LOG_DEBUG);
        else 
            if (isset($this->params['id']))
                $this->log("[$class $method $user] ".$this->params['controller']."/".$this->params['action']." for ".$this->params['id'], LOG_DEBUG);
            elseif (isset($this->params['pass']['0']))
                $this->log("[$class $method $user] ".$this->params['controller']."/".$this->params['action']." for ".$this->params['pass']['0'], LOG_DEBUG);
            else
                $this->log("[$class $method $user] ".$this->params['controller']."/".$this->params['action'], LOG_DEBUG);
    }

    /**
     * Describe beforeFilter
     *
     * @return null
     */
    function beforeFilter() {
        $this->set('show_sidemenu', 0);
        
        if(isset($this->data)){
            if($this->Session->check('trylogin') && $this->Session->check('security_code')){
                if($this->Session->read('trylogin')>3 && isset($this->data['User']['captcha']) && $this->data['User']['captcha']!=$this->Session->read('security_code')){
                    $this->Session->SetFlash(__('Please key in the code',true),'default',null,'loginerror');
                    $this->Auth->logout();
                }
            }
        }
        $this->Auth->loginAction=array('controller'=>'users','action'=>'login');
        $this->Auth->loginRedirect=array('controller'=>'users','action'=>'haschangedpassword');
        $this->Auth->logoutRedirect=array('controller'=>'users','action'=>'login');
        $this->Auth->loginError=__('Invalid username or password',true);
        $this->Auth->authorize='controller';
        $this->Auth->allow(array('changeInvite','captcha','forgotpass','forgotuser'));
        if($this->Auth->user('id')){
            $this->{$this->modelClass}->curUser=$this->Auth->user('id');
            $this->writelog(get_class($this),__FUNCTION__);
                
            // set dcommittee
            if (isset($this->params['committee'])) { 
                $this->Committee->contain(array('Todo','Item'));
                $this->dcommittee=$this->Committee->findByShortName($this->params['committee']);
                $this->set('dcommittee',$this->dcommittee);
            }
            
            // set the page user will be redirected to after captcha & changing password
            if (!$this->Session->check('lastvisitedpage')) {
                $lastvisitedpage = array('controller'=>$this->params['controller'], 'action'=>$this->params['action']);
                $this->Session->write('lastvisitedpage',$lastvisitedpage); 
            }
            
            // check captcha
            if ($this->Session->check('securitycode') && $this->params['url']['url'] != 'logout' && $this->params['url']['url'] != 'users/captcha') {
                
                if ($this->data['User']['captcha'] == $this->Session->read('securitycode')) {
                    $this->Session->write('passcaptcha',1);
                    $this->Session->write('redirected',0);
                    $this->Session->del('securitycode');
                    $this->writelog(get_class($this),__FUNCTION__,'Correct captcha value: '.$this->data['User']['captcha']);
                } else {
                    $this->Session->SetFlash(__('You have entered wrong code',true));
                    $this->Session->write('passcaptcha',0);
                    $this->Session->write('redirected',1);
                    $this->Session->del('securitycode');
                        
                    $this->Session->write('login_username',$this->data['User']['username']);
                    $this->Session->write('login_captcha',$this->data['User']['captcha']);
                                
                    $this->writelog(get_class($this),__FUNCTION__,'Incorrect captcha value: '.$this->data['User']['captcha']);
                    $this->redirect(array('controller'=>'users','action'=>'login',));    
                }
                
            } else {
                $this->Session->write('passcaptcha',1);
            }
            
            
            // check if user has changed their default password
            if ($this->Session->read('passcaptcha') &&  !$this->Session->read('redirected')) {
                // if user not coming from root url
                if (!$this->Session->check('haschanged') && $this->params['url']['url'] != 'users/haschangedpassword') {
                    
                    if (!$this->Session->check('lastvisitedpage')) {
                        // set the page user will be redirected to after changing password
                        $lastvisitedpage = array('controller'=>$this->params['controller'], 'action'=>$this->params['action']);
                        $this->Session->write('lastvisitedpage',$lastvisitedpage); 
                    }
                    $this->writelog(get_class($this),__FUNCTION__,"lastvisitedpage: ".$this->params['url']['url']);
                    
                    if ($this->params['controller']."/".$this->params['action'] != 'users/forcechangepassword' && $this->params['controller']."/".$this->params['action'] != 'users/logout') {
                        $this->writelog(get_class($this),__FUNCTION__,"Redirecting to haschangedpassword from ".$this->params['controller']."/".$this->params['action']);
                        $this->redirect(array('controller'=>'users','action'=>'haschangedpassword'));
                    }
                }
                if ($this->Session->read('haschanged') == 'N') {
                    if ($this->params['controller']."/".$this->params['action'] != 'users/forcechangepassword' && $this->params['controller']."/".$this->params['action'] != 'users/logout') {
                        $this->writelog(get_class($this),__FUNCTION__,"Redirecting to forcechangepassword from ".$this->params['controller']."/".$this->params['action']);
                        $this->redirect(array('controller'=>'users','action'=>'forcechangepassword'));
                    }
                }
            }
        }
        //$this->writelog(get_class($this),__FUNCTION__,"current url: ".$this->params['url']['url']);
        
        // set page title
        $this->pageTitle = __(ucfirst($this->params['controller']),true);
        
    }

    /**
     * Describe beforeRender
     *
     * @return null
     */
    function beforeRender(){
        /* SPECIAL CASES: 
         * 1. display admin menu when editing committee 
         *  - the adminmenu view need $this->params['committee'] */
        if (count($this->params['pass']) && is_array($this->params)) {
            $dcommittee=$this->Committee->findByShortName($this->params['pass'][0]);
            $this->params['committee'] = $dcommittee['Committee']['short_name'];
        } 

        /* dont display adminmenu for these */
        $no_adminmenu = array('committees/mainpage','committees/add',
            'users/index','users/add','users/view','users/edit','users/profile','users/changepassword','users/forcechangepassword',
            'users/captcha',
            'titles/index','titles/add','titles/edit',
            'roles/index','roles/add','roles/edit','systemtodos/index','systemtodos/add','systemtodos/edit',
            'templates/index','templates/add','templates/edit','templates/view',
            'settings/edit','settings/logo','logs/index','logs/report',
            'hashes/hash','calendar','committees/calendar'
        );
        /* display sidemenu for these */
        $show_sidemenu = array('committees/add',
            'users/index','users/add','users/view','users/edit',
            'titles/index','titles/add','titles/view','titles/edit',
            'roles/index','roles/add','roles/edit','systemtodos/index','systemtodos/add','systemtodos/edit',
            'templates/index','templates/add','templates/edit','templates/view',
            'settings/edit','settings/logo','logs/index','logs/report'
        );
        if($this->Auth->user()){
            $this->set('auth_user',$this->Auth->user());
            //$this->set('registeredCommittee',$this->Committee->registeredCommitteeList($this->Auth->user('id')));
            // show adminmenu?
            if (!in_array($this->params['controller'].'/'.$this->params['action'],$no_adminmenu) ) 
                $this->set('show_adminmenu', 1);
            else 
                $this->set('show_adminmenu', 0);
            // show sidemenu?
            if (in_array($this->params['controller'].'/'.$this->params['action'],$show_sidemenu) ) {
                $this->set('show_sidemenu', 1);
                if (isset($this->params['committee']) && $this->params['controller']=='templates') {$this->set('show_sidemenu', 0); }
            } else {
                $this->set('show_sidemenu', 0);
            }
        }

        $this->set('img_path',$this->getLogo());
    }

    /**
     * Describe isAuthorized
     *
     * @return null
     */
    function isAuthorized(){
        return true;
        if($this->Auth->user('superuser') || $this->params['controller']=='ajaxes'){
            /* All superusers and ajax controllers can do anything */
            return true;
        }

        $allowedactions=array('index','alert');
        if(in_array($this->params['action'],$allowedactions)) return true;   
        $item=null;
        $committee=null;
        $committee_roles=null;
        if(isset($this->params['id'])) $item=$this->params['id'];
        if(isset($this->params['committee'])) {
            $committee_id=$this->idFromShortName($this->params['committee']);
            $committee_roles = $this->Committee->userData($this->Auth->user('id'),$committee_id);
        }
        $permission=$this->{Inflector::classify($this->params['controller'])}->isAuthorized($this->Auth->user('id'),$this->params['action'],$item,$committee_id,$committee_roles);
        return $permission;
    }

    /**
     * Describe checkAuthority
     *
     * @param $model
     * @param $user_id
     * @param $action
     * @param $committee_id
     * @param $item_id
     * @return null
     */
    function checkAuthority($model,$user_id,$action,$committee_id,$item_id=null){
        if(!isset($this->{$model})){
            App::import('Model',$model);
            $this->{$model}=& ClassRegistry::init($model);
        }
        if(method_exists($this->{$model},'isAuthorized')){
            return $this->{$model}->isAuthorized($user_id,$action,$item_id,$committee_id,$this->Committee->userData($user_id,$committee_id));
        }
        return false;
    }   

    function fixupauth($data,$model,$user_id,$committee_id){
        $auth['view']=$this->checkAuthority($model,$user_id,'view',$committee_id);
        $auth['edit']=$this->checkAuthority($model,$user_id,'edit',$committee_id);
        $auth['delete']=$this->checkAuthority($model,$user_id,'delete',$committee_id);
        foreach($data as $did=>$ddata){
            if(!isset($ddata[$model]['auth'])){
                $data[$did]['auth']=$auth;
            }
        }
        return $data;
    }

    /**
     * Describe getLogo
     *
     * @return string path to logo
     */
    function getLogo() {

        $logo_uploaded = WWW_ROOT . 'img' . DS . 'logo';
        $found = array();
        $folder = new Folder($logo_uploaded);
        $found = $folder->find();

        if (count($found)) {
            return 'logo'. DS . $found[0];
        } else {
            return 'mymeetingv2.png';
        }
    }
}
?>
