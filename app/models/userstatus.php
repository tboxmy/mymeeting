<?php
class Userstatus extends AppModel {

/**
 * Defining the name of model
 *
 */
    var $name = 'Userstatus';
/**
 * Defining the name of the table
 *
 */
    var $useTable = 'userstatuses';
/**
 * Defining behavior in the model
 *
 */
    var $actsAs = array('Comment','Workflow','MultiFile');

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
        'Decision' => array(
            'className' => 'Decision',
            'foreignKey' => 'decision_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''),
        'Updater' => array(
            'className' => 'User',
            'foreignKey' => 'updater',
            'conditions' => '',
            'fields' => '',
            'order' => '')
        );

/**
 * Fetching all the user data which has the valid user id
 * $param id finds all the user data which has the valid user id
 */
    function getUser($id){
        $ddat=mysql_fetch_assoc(mysql_query("select name, job_title from users where id=$id"));
        return $ddat;
    }

/**
 * Finding all the related decision which is defined by the userstatus id
 * $param id finds all the related decision which is defined by the userstatus id
 */
    function getDecisionId($id){
        $data=$this->getData(array('decision_id'),array('id'=>$id));
        return $data[0]['Userstatus']['decision_id'];
    }

/**
 * Finding all the related decision which is defined by the userstatus id
 * $param id finds all the related decision which is defined by the userstatus id
 */
    function getCommitteeId($status_id){
        return $this->Decision->getCommitteeId($this->getDecisionId($status_id));
    }

/**
 * Finding all the related user data which is defined by the user id and status id
 * $param user_id, status_id  finds all the user data
 */
    function userData($user_id,$status_id=null,$statususerid=null){
        $decision_id=$this->getDecisionId($status_id);
        $toret=$this->Decision->userData($user_id,$decision_id);
        if($statususerid!==null && $user_id==$statususerid){
            $toret['owner']=true;
        }
        return $toret;
    }
    
    function getHistory($users,$dec_id) {
        $status = $this->find('all',array(
            'conditions'=>array('Userstatus.user_id'=>$users,'Userstatus.decision_id'=>$dec_id),
            'order'=>'Userstatus.created DESC',
            //'contain'=>'Userstatus'
            ));
        //debug($status);
        return $status;
    }
}
?>
