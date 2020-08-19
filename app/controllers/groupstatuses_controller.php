<?php
class GroupstatusesController extends AppController {

    /**
     * Define $name
     *
     */
    var $name = 'Groupstatuses';
    /**
     * Define $helpers
     *
     */
    var $helpers = array('Html', 'Form', 'DatePicker','Comment','MultiFile');
    /**
     * Define $components
     *
     */
    var $components = array('MultiFile');
    /**
     * Define $uses
     *
     */
    var $uses = array ('Notification','Comment','Template','Groupstatus','Attachment');

    /**
     * Describe index
     *
     * @param $committee
     * @return null
     */
    function index($committee) {
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        $this->Groupstatus->recursive = 0;
        $this->set('groupStatuses', $this->paginate());
    }

    /**
     * Describe view
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function view($committee,$id = null) {
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid Groupstatus.', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->set('groupStatus', $this->Groupstatus->read(null, $id));
    }

    /**
     * Describe add
     *
     * @param $committee
     * @return null
     */
    function add($committee) {
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!empty($this->data)) {
            $this->Groupstatus->create();
            $this->data['Groupstatus']['user_id']=$this->Auth->user('id');
            $this->data['Groupstatus']['committee_id']=$dcommittee['Committee']['id'];
            if ($this->Groupstatus->save($this->data)) {
                $this->Session->setFlash(__('The Groupstatus has been saved', true));
                if(isset($this->data['Groupstatus']['returnpage'])){
                    $this->redirect($this->data['Groupstatus']['returnpage'].'#group'.$this->Groupstatus->getLastInsertID());
                }
                else{
                    $this->redirect(array('committee'=>$committee,'decisionid'=>$this->data['Groupstatus']['decision_id'],'action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Groupstatus could not be saved. Please, try again.', true));
            }
        }
        $oldstatus=$this->Groupstatus->find('first',array(
            'conditions'=>array(
                'decision_id'=>$this->params['decisionid'],
                'group_id'=>$this->params['group_id'],
                'Groupstatus.deleted'=>0,
            ),
            'order'=>array(
                'Groupstatus.updated desc',
            ),
        ));
        $this->set('oldstatus',$oldstatus);
        $this->data = $this->Groupstatus->read(null, $oldstatus['Groupstatus']['id']);
        $users = $this->Groupstatus->User->find('list');
        $groups = $this->Groupstatus->Group->find('list');
        $this->set(compact('users', 'groups'));
        $this->set('returnpage',$this->referer(null,true));
        
        $decision = $this->Groupstatus->Decision->find('first',array(
            'conditions'=>array('Decision.id'=>$this->params['decisionid']),
            'order'=>'Decision.created DESC'
            ));
        $this->set('decision',$decision);
    }

    /**
     * Create notifications when comments are made to the status
     *
     * @param $status_id 
     * @param $comment_id
     * @return null
     */
    function sendcomment($status_id,$comment_id){
        $status=$this->Groupstatus->read(null,$status_id);
        $decision=$this->Groupstatus->Decision->read(null,$status['Groupstatus']['decision_id']);
        $dmeeting=$this->Groupstatus->Decision->Meeting->read(null,$decision['Decision']['meeting_id']);
        $comment=$this->Comment->read(null,$comment_id);
        $notification['Notification']['meeting_id']=$decision['Decision']['meeting_id'];
        $notification['Notification']['type']='new status comment';
        $notification['Notification']['message_title']=sprintf(__("New comments for %s meeting status",true),$dmeeting['Meeting']['meeting_title']);
        $notification['Notification']['notification_date']=date('Y-m-d H:i:s');
        $users=$this->Groupstatus->Decision->Meeting->User->find('first',array('fields'=>array('name','job_title'),'conditions'=>array('id'=>$comment['Comment']['user_id'])));
        $heading=sprintf(__("For the status: %s\n\n",true),strip_tags($status['Groupstatus']['description']));
        $notification['Notification']['message']=$heading.sprintf(__("%s commented: %s",true),$users['User']['name'],$comment['Comment']['description']);
        $groups=Set::extract($status,"GroupstatusComment.{n}.Comment.user_id");
        $groups[]=$status['Groupstatus']['group_id'];
        $groups=array_unique($groups);
        $this->Notification=ClassRegistry::init('Notification','model');
        foreach($groups as $group){
            $gusers=$this->Groupstatus->Decision->Meeting->User->Group->find('first',array('conditions'=>array('id'=>$group)));
            foreach($gusers['User'] as $dguser){
                $usersids[]=$dguser['id'];
            }
        }
        $usersids=array_unique($usersids);
        foreach($usersids as $userid){
            $user=$this->Groupstatus->Decision->Meeting->User->find('first',array('fields'=>array('name','email'),'conditions'=>array('id'=>$userid)));
            $notification['Notification']['to']=$user['User']['email'];
            $this->Notification->create();
            $this->Notification->save($notification);
        }
    }

    /**
     * Describe edit
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function edit($committee,$id = null) {
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid Groupstatus', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            $this->data['Groupstatus']['committee_id']=$dcommittee['Committee']['id'];
            if ($this->Groupstatus->save($this->data)) {
                if(!isset($this->data['Groupstatus']['id'])){
                    $newid=$this->Groupstatus->getLastInsertID();
                    $oldstatus=$this->Groupstatus->find('first',array(
                        'conditions'=>array(
                            'decision_id'=>$this->data['Groupstatus']['decision_id'],
                            'group_id'=>$this->data['Groupstatus']['group_id'],
                            'Groupstatus.deleted'=>0,
                            'Groupstatus.id<'.$newid,
                        ),
                        'order'=>array(
                            'Groupstatus.updated desc',
                        ),
                    ));
                    $attachments=$this->Attachment->find('all',array(
                        'conditions'=>array(
                            'foreign_key'=>$oldstatus['Groupstatus']['id'],
                            'model'=>'Groupstatus',
                        ),
                    ));
                    foreach($attachments as $attachment){
                        $attachment['Attachment']['foreign_key']=$newid;
                        $this->Attachment->save($attachment);
                    }
                }
                else{
                    $newid=$this->data['Groupstatus']['id'];
                }
                $this->Session->setFlash(__('The Groupstatus has been saved', true));
                if(isset($this->data['Groupstatus']['returnpage'])){
                    if(isset($this->data['GroupstatusComment']['Comment'])){
                        $this->Comment=ClassRegistry::init('Comment','model');
                        $this->sendcomment($this->data['Groupstatus']['id'],$this->Comment->getLastInsertID());
                    }
                    $this->redirect($this->data['Groupstatus']['returnpage'].'#group'.$newid);
                }
                else{
                    $this->redirect(array('action'=>'index'));
                }
            } else {
                $this->Session->setFlash(__('The Groupstatus could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Groupstatus->read(null, $id);
        }
        $decisions = $this->Groupstatus->Decision->find('list');
        $users = $this->Groupstatus->User->find('list');
        $groups = $this->Groupstatus->Group->find('list');
        $this->set(compact('decisions','users','groups'));
    }

    /**
     * Describe delete
     *
     * @param $committee
     * @param $id
     * @return null
     */
    function delete($committee,$id = null) {
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Groupstatus', true));
            $this->redirect(array('action'=>'index'));
        }
        $this->Groupstatus->del($id);
        $this->Session->setFlash(__('Groupstatus deleted', true));
        $this->redirect(array('action'=>'index'));
    }


    function view_history($committee,$decisionid = null,$id=null) {
        
        $dcommittee=$this->Groupstatus->Decision->Meeting->Committee->findByShortName($committee);
        $this->set('dcommittee',$dcommittee);

        Configure::write('debug', 0); // dont want debug in ajax returned html
        $this->layout="popup";
        
        $statuses = $this->Groupstatus->find('all',array('conditions'=>array('Committee.id'=>$dcommittee['Committee']['id'],'Decision.id'=>$decisionid,'Group.id'=>$id),'order'=>'Groupstatus.created DESC'));
        
        foreach($statuses as $sid=>$status){
            $comment=$this->Comment->find('all',array('conditions'=>array('model'=>'Groupstatus','foreign_key'=>$status['Groupstatus']['id']),'order'=>'updated desc'));
            
            if(count($comment)){
                foreach($comment as $cid=>$curcomment){
                    $users=$this->Groupstatus->User->find('first',array('fields'=>array('name','job_title'),'conditions'=>array('User.id'=>$curcomment['Comment']['user_id'])));
                    $comment[$cid]['Comment']['user_name']=$users['User']['name'];
                    $comment[$cid]['Comment']['job_title']=$users['User']['job_title'];
                }
                $statuses[$sid]['Groupstatus']['GroupstatusComment']=$comment;
            }
        }
        $this->set('statuses',$statuses);
    }
}
?>
