<?php
class CronShell extends Shell {
    var $tasks = array('Email');
    var $uses = array('Notification','Meeting','Template');

    function all(){
        $this->reminders();
        $this->emails();
    }

    function emails(){
        $notifications=$this->Notification->findAll(array('notification_date<=now()','notification_sent'=>'0'));
        $this->Email->settings(array('from'=>Configure::read('email_from')));
        foreach($notifications as $notification){
            $this->Email->reset();
            if($this->Email->send($notification['Notification']['message'],array('to'=>$notification['Notification']['to'],'subject'=>$notification['Notification']['message_title'],'sendAs'=>'html'))){
                $data['id']=$notification['Notification']['id'];
                $data['notification_sent']=1;
                $this->Notification->save($data);
                echo "Send \"".$notification['Notification']['message_title']."\" email to ".$notification['Notification']['to']."\n";
            }
            else{
                echo "Failed sending email to ".$notification['Notification']['to']."\n";
            }
        }
    }

    function reminders(){
        $late=$this->Meeting->Decision->findAll(array('datediff(deadline,now())<'.Configure::read('days_to_remind'),'datediff(deadline,now())>0'));
        foreach($late as $decision){
            $userupdated=Set::extract($decision['Userstatus'],'{n}.user_id');
            $groupupdated=Set::extract($decision['Groupstatus'],'{n}.group_id');
            if(isset($tosendout)){
                unset($tosendout);
            }
            foreach($decision['User'] as $user){
                if(!in_array($user['id'],$userupdated)){
                    if(Validation::email($user['email'])){
                        $this->Notification->create();
                        $data['meeting_id']=$decision['Meeting']['id'];
                        $data['type']='status reminder';
                        $template=$this->Template->find(array('model'=>'Meeting','foreign_key'=>$decision['Meeting']['id'],'type'=>$data['type']));
                        $data['message_title']=$template['Template']['title'];
                        $data['notification_date']=date('Y-m-d H:i:s');
                        $decision['name']=$user['name'];
                        $decision['days_left']=datediff($decision['Decision']['deadline'],date('Y-m-d H:i:s'));
                        $committee=$this->Meeting->Decision->Committee->find('first',array(
                            'contain'=>false,
                            'fields'=>array(
                                'short_name',
                            ),
                            'conditions'=>array(
                                'id'=>$decision['Decision']['committee_id'],
                            ),
                        ));
                        $decision['Link']['decision']=array('committee'=>urlencode($committee['Committee']['short_name']),'controller'=>'decisions','action'=>'view','id'=>$decision['Decision']['id']);
                        $data['message']=$this->Meeting->replacetemplate($template['Template']['template'],$decision);
                        $data['to']=$user['email'];
                        $tosendout[$data['to']]=$data;
                    }
                }
            }
            foreach($decision['Group'] as $group){
                if(!in_array($group['id'],$groupupdated)){
                    $dgroup=$this->Meeting->User->Group->find('all',array('conditions'=>array('Group.id'=>$group['id'])));
                    foreach($dgroup[0]['User'] as $user){
                        if(Validation::email($user['email'])){
                            $this->Notification->create();
                            $data['meeting_id']=$decision['Meeting']['id'];
                            $data['type']='status reminder';
                            $template=$this->Template->find(array('model'=>'Meeting','foreign_key'=>$decision['Meeting']['id'],'type'=>$data['type']));
                            $data['message_title']=$template['Template']['title'];
                            $data['notification_date']=date('Y-m-d H:i:s');
                            $decision['name']=$user['name'];
                            $decision['days_left']=datediff($decision['Decision']['deadline'],date('Y-m-d H:i:s'));
                            $committee=$this->Meeting->Decision->Committee->find('first',array(
                                'contain'=>false,
                                'fields'=>array(
                                    'short_name',
                                ),
                                'conditions'=>array(
                                    'id'=>$decision['Decision']['committee_id'],
                                ),
                            ));
                            $decision['Link']['decision']=array('committee'=>urlencode($committee['Committee']['short_name']),'controller'=>'decisions','action'=>'view','id'=>$decision['Decision']['id']);
                            $data['message']=$this->Meeting->replacetemplate($template['Template']['template'],$decision);
                            $data['to']=$user['email'];
                            $tosendout[$data['to']]=$data;
                        }
                    }
                }
            }
            if(isset($tosendout)){
                foreach($tosendout as $datatosend){
                    $this->Notification->save($datatosend);
                }
            }
        }
    }
}
?>
