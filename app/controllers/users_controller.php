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

class UsersController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Users';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'Crumb');
    /**
     * Define $uses
     *
     */
    var $uses = array('User', 'Setting', 'Committee','Notification','Template','Hash');

    /**
     * Define $paginate
     *
     */
    var $paginate = array(
        //'limit' => '4',
        'order'=>array(
            'User.username'=>'asc'
        )
    );

    /**
     * Describe captcha
     *
     * @return null
     */
    function captcha(){
        App::import('vendor','captcha');
        $captcha = new CaptchaSecurityImages();
        $code=$captcha->render();
        $this->Session->write('securitycode',$code); 
        $this->writelog(get_class($this),__FUNCTION__,"Captcha code $code generated  ");
    }

    /**
     * Describe alert
     *
     * @return null
     */
    function alert() {
        $announcements = $this->User->Announcement->findAll();
        $this->set(compact('announcements'));
        $this->User->Announcement->recursive=0;
        if($this->Session->check('CurCommittee'))
        {
            $this->set('announcements', $this->paginate('Announcement','committee_id='.$this->Session->read('CurCommittee')));
        }
        else{
            $this->set('announcements', $this->paginate('Announcement'));
        }
    }

    /**
     * Describe changepassword
     *
     * @return null
     */
    function changepassword()
    {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $someone = $this->User->findById($this->Auth->user('id'));
            if(($this->Auth->password($this->data['User']['oldpassword'])) != $someone['User']['password']) {
                $this->Session->setFlash(__('Your old password is invalid.', true));
            }
            elseif($this->data['User']['newpassword'] !=$this->data['User']['confirmpassword']){
                $this->Session->setFlash(__('Your password does not match.', true));                           
            } else {

                $this->data['User']['id'] = $this->Auth->user('id');
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['newpassword']);
                if ($this->User->save($this->data,false)){
                    $this->Session->setFlash(__('Your password has been changed',true));
                    $this->redirect(array('action'=>'profile'));
                }
            }      
        }
    }

    function resetpass($id = null) {
        $this->data['User']['id'] = $id;
        $someone = $this->User->findById($id);
        $this->data['User']['password'] = $this->Auth->password($someone['User']['username']);
        if ($this->User->save($this->data,false)){
            $this->Session->setFlash(sprintf(__('Password for %s has been reset',true),$someone['User']['username']));
            $this->redirect(array('action'=>'index'));
        }
    }
    
    function forcechangepassword() {
        
        if (!empty($this->data)) {
            if ($this->data['User']['newpassword'] !=$this->data['User']['confirmpassword']){
                $this->Session->setFlash(__('Your password does not match.', true));                           
            } else {

                $this->data['User']['id'] = $this->Auth->user('id');
                $this->data['User']['password'] = $this->Auth->password($this->data['User']['newpassword']);
                if ($this->User->save($this->data,false)){
                    $this->Session->setFlash(__('Your password has been changed',true));
                    $this->Session->write('haschanged','Y');
                    $this->writelog(get_class($this),__FUNCTION__,"Password changed. Session haschanged=Y");
                    if ($this->Session->check('lastvisitedpage')) { // if user not coming from root url
                        $this->redirect($this->Session->read('lastvisitedpage'));
                        $this->Session->del('lastvisitedpage');
                    } else {
                        $this->redirect(array('action'=>'mainpage','controller'=>'committees'));
                    }
                }
            }      
        }
    }
    
    
    function haschangedpassword() {
        $this->writelog(get_class($this),__FUNCTION__,"LOGGED IN");
        
        $user = $this->User->findById($this->Auth->user('id'));
        if ($this->Auth->password($this->Auth->user('username')) == $user['User']['password']) {
            $this->Session->write('haschanged','N');
            $this->writelog(get_class($this),__FUNCTION__,"User has NOT changed password. Session haschanged=N");
            $this->redirect(array('action'=>'forcechangepassword'));
        } else { 
            $this->Session->write('haschanged','Y');
            $this->writelog(get_class($this),__FUNCTION__,"User has changed password. Session haschanged=Y");
            if ($this->Session->check('lastvisitedpage')) { // if user not coming from root url
                $this->redirect($this->Session->read('lastvisitedpage'));
                $this->Session->del('lastvisitedpage');
            } else {
                $this->redirect(array('action'=>'mainpage','controller'=>'committees'));
            }
        }
    }
    
    function checkcaptcha() {
        $this->pageTitle = __("Login",true);
        $this->set('displaycaptcha',1);
        
    }
    
    /**
     * Describe login
     *
     * @return null
     */
    function login(){
        $this->pageTitle = __("Login",true);
        $this->set('displaycaptcha',0);
        
        if (!empty($this->data['User'])) { 
            $this->writelog(get_class($this),__FUNCTION__,$this->data['User']['username']." is trying to login");
            $this->Session->write('trylogin',$this->Session->read('trylogin')+1);
            
            if(!$this->Auth->user('id')){ // wrong username/password
                $this->Session->SetFlash(__('Invalid username or password',true));
                $this->writelog(get_class($this),__FUNCTION__,"Failed attempt to login no. ".$this->Session->read('trylogin')." with username: ".$this->data['User']['username']);
                if ($this->Session->read('trylogin') > 3) {
                    $this->set('displaycaptcha',1);
                    $this->writelog(get_class($this),__FUNCTION__,"Displaying CAPTCHA for ".$this->data['User']['username']);
                } else {
                    $this->set('displaycaptcha',0);
                }
            } 
        } else {
            
            // if user needs to enter captcha value
            if ($this->Auth->user('id')) {
                $this->set('displaycaptcha',1);
                $this->writelog(get_class($this),__FUNCTION__,"Displaying CAPTCHA for ".$this->Auth->user('id'));
            } else {
                $this->Session->write('trylogin',0);
                $this->Session->del('securitycode');                
            }
        }
    }

    /**
     * Describe logout
     *
     * @return null
     */
    function logout(){
        
        $this->Auth->logout();
        $this->writelog(get_class($this),__FUNCTION__,"LOGGED OUT");
        
        $this->Session->del('haschanged');
        $this->Session->del('lastvisitedpage');
        $this->Session->del('trylogin');      
        $this->Session->del('login_username');
        $this->Session->del('login_captcha');
        $this->Session->SetFlash(__('Successfully logged out',true));
        
        //$this->redirect($this->Auth->redirect());
        $this->redirect(array('action'=>'login'));
    }

    /**
     * Describe index
     *
     * @return null
     */
    function index() { 
        // if resetting password        
        if(isset($this->params['pass']['1']) && $this->params['pass']['1']=='reset') $this->_resetpass($this->params['pass']['0']);

        // first page
        if (empty($this->params['named']['page']) || empty($this->data)) {
            $this->Session->del('Search.username'); 
            $this->Session->del('Search.committee'); 
            $this->Session->del('Search.name'); 
            $this->Session->del('Search.job_title'); 
            $this->Session->del('Search.email'); 
        }

        // get the search terms
        if(!empty($this->data['Search']['username'])) $cursearch_user = $this->data['Search']['username'];
        elseif($this->Session->check('Search.username')) $cursearch_user = $this->Session->read('Search.username'); 
        else $cursearch_user = '';

        if(!empty($this->data['Search']['committee'])) $cursearch_comm = $this->data['Search']['committee'];
        elseif($this->Session->check('Search.committee')) $cursearch_comm = $this->Session->read('Search.committee'); 
        else $cursearch_comm = '';

        if(!empty($this->data['Search']['name'])) $cursearch_name = $this->data['Search']['name'];
        elseif($this->Session->check('Search.name')) $cursearch_name = $this->Session->read('Search.name'); 
        else $cursearch_name = '';

        if(!empty($this->data['Search']['job_title'])) $cursearch_job = $this->data['Search']['job_title'];
        elseif($this->Session->check('Search.job_title')) $cursearch_job = $this->Session->read('Search.job_title'); 
        else $cursearch_job = '';

        if(!empty($this->data['Search']['email'])) $cursearch_email = $this->data['Search']['email'];
        elseif($this->Session->check('Search.email')) $cursearch_email = $this->Session->read('Search.email'); 
        else $cursearch_email = '';

        // construct queries
        $filters = array();
        if(isset($cursearch_user) && $cursearch_user!='') {
            array_push($filters,"User.username  like '%".$cursearch_user."%'");
            //$filters['User.username'] = 'LIKE %'.$cursearch_user.'%';
            $this->Session->write('Search.username', $cursearch_user);        
        }
        if(isset($cursearch_comm) && $cursearch_comm!='') {
            //$filters = array("Committee.id ='".$cursearch_comm."'")
            $percommittee = $this->User->getUsersPerCommittee($cursearch_comm);
            $percommittee = Set::extract('/User/id',$percommittee);
            $filters['User.id'] = $percommittee;
            $this->Session->write('Search.committee', $cursearch_comm);        
        }
        if(isset($cursearch_name) && $cursearch_name!='') {
            array_push($filters,"User.name  like '%".$cursearch_name."%'");
            //$filters['User.name'] = 'LIKE %'.$cursearch_name.'%';
            $this->Session->write('Search.name', $cursearch_name);        
        }
        if(isset($cursearch_job) && $cursearch_job!='') {
            array_push($filters,"User.job_title  like '%".$cursearch_job."%'");
            //$filters['User.job_title'] = 'LIKE %'.$cursearch_job.'%';
            $this->Session->write('Search.job_title', $cursearch_job);        
        }
        if(isset($cursearch_email) && $cursearch_email!='') {
            array_push($filters,"User.email  like '%".$cursearch_email."%'");
            //$filters['User.email'] = 'LIKE %'.$cursearch_email.'%';
            $this->Session->write('Search.email', $cursearch_email);        
        }
        $filters['User.deleted'] = '0';
        $this->set('users', $this->paginate('User', $filters)); 

        // for searchbox
        $committee = $this->Committee->find('list',array('order'=>'Committee.short_name ASC'));
        $this->set('committee',$committee);
    }

    /**
     * Describe view
     *
     * @param $id
     * @return null
     */
    function view($id = null) {
        //$this->layout='mainpage';
        if (!$id) {
            $this->Session->setFlash(__('Invalid User.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('user', $this->User->find(array('User.id'=>$id)));
    }

    /**
     * Describe add
     *
     * @return null
     */
    function add() {
        //$this->layout='mainpage';
        if (!empty($this->data)) {
            $this->User->create();
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
            }
        }
        $committees = $this->User->Committee->find('list');
        $meetings = $this->User->Meeting->find('list');
        $groups = $this->User->Group->find('list');
        $titles = $this->User->Title->find('list');
        $this->set(compact('committees', 'meetings', 'groups', 'titles'));
    }

    /**
     * Describe edit
     *
     * @param $id
     * @return null
     */
    function edit($id = null) {
        //$this->layout='mainpage';
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid User', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', true));
                $this->redirect('index');
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->User->read(null, $id);
        }
        $committees = $this->User->Membership->Committee->find('list');
        $meetings = $this->User->Attendance->Meeting->find('list');
        $titles = $this->User->Title->find('list');
        $this->set(compact('committees','meetings','titles'));
    }

    /**
     * Describe profile
     *
     * @return null
     */
    function profile() {
        if (!$this->Auth->user('id')) {
            $this->Session->setFlash(__('Invalid User', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The profile has been saved', true));
                $this->redirect(array('controller'=>'committees','action'=>'mainpage'));
            } else {
                $this->Session->setFlash(__('The profile could not be saved. Please, try again.', true));
            }
        } 
        //if (empty($this->data)) {
            $this->data = $this->User->read(null, $this->Auth->user('id'));
        //}
        $titles = $this->User->Title->find('list');
        $this->set(compact('titles'));
        $this->set('data',$this->data);
    }

    /**
     * Describe delete
     *
     * @param $id
     * @return null
     */
    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for User', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->User->del($id);
        $this->Session->setFlash(__('User deleted', true));
        $this->redirect(array('action'=>'index'));
    }
    
    function forgotpass() {
        if (!empty($this->data)) {
            $newpassword = $this->Hash->newPassword();
            $this->User->Behaviors->attach('Containable');
            $user = $this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['email']),'contain'=>array('Title'),'fields'=>'User.*,Title.*'));
            
            if ($user) {
                $user['User']['password'] = $this->Auth->password($newpassword);
                $this->User->save($user);
                $replace['name'] = $user['Title']['long_name'].' '.$user['User']['name'];
                $replace['newpassword'] = $newpassword;
                
                $t = $this->Template->find('first',array('conditions'=>array('type'=>'forgot password','model'=>'SystemOnly')));
                $n = $this->Notification->create();
                $n['Notification']['type'] = $t['Template']['type'];
                $n['Notification']['message_title'] = $t['Template']['title'];
                $n['Notification']['notification_date'] = date('Y-m-d H:i:s');
                $n['Notification']['notification_sent'] = '0';
                $n['Notification']['message'] = $this->User->replacetemplate($t['Template']['template'],$replace);
                $n['Notification']['to'] = $this->data['User']['email'];
                $this->Notification->save($n);
                
                $this->Session->setFlash(__('Your new password has been generated. Please check your email.', true));
                $this->redirect(array('action'=>'login'));
            } else {
                $this->Session->setFlash(__('The email is not registered in the system.', true));
            }
        }
    }
    
    function forgotuser() {
        if (!empty($this->data)) {
            $this->User->Behaviors->attach('Containable');
            $user = $this->User->find('first',array('conditions'=>array('email'=>$this->data['User']['email']),'contain'=>array('Title'),'fields'=>'User.*,Title.*'));
            
            if ($user) {
                $replace['username'] = $user['User']['username'];
                $replace['name'] = $user['Title']['long_name'].' '.$user['User']['name'];
                
                $t = $this->Template->find('first',array('conditions'=>array('type'=>'forgot username','model'=>'SystemOnly')));
                $n = $this->Notification->create();
                $n['Notification']['type'] = $t['Template']['type'];
                $n['Notification']['message_title'] = $t['Template']['title'];
                $n['Notification']['notification_date'] = date('Y-m-d H:i:s');
                $n['Notification']['notification_sent'] = '0';
                $n['Notification']['message'] = $this->User->replacetemplate($t['Template']['template'],$replace);
                $n['Notification']['to'] = $this->data['User']['email'];
                $this->Notification->save($n);
                $this->Session->setFlash(__('Your username has been sent to your email.', true));
                $this->redirect(array('action'=>'login'));
            } else {
                $this->Session->setFlash(__('The email is not registered in the system.', true));
            }
        }
    }
}


?>
