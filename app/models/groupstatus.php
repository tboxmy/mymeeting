<?php
class Groupstatus extends AppModel {

    /**
     * Defining the name of model
     *
     */
    var $name = 'Groupstatus';
    /**
     * Defining the name of the table
     *
     */
    var $useTable = 'groupstatuses';
    /**
     * Defining behavior in the model
     *
     */
    var $actsAs = array('Comment','Workflow','MultiFile');

    /**
     * Validating the fields in group status model
     *
     */
    var $validate = array(
        'decision_id' => array('numeric'),
        'user_id' => array('numeric'),
        'group_id' => array('numeric'),
        'deleted' => array('numeric'),
        'deleted_date' => array('date')
    );

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
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * Getting all the related committee for the decision defined by status_id
     * $param status_id finds all the related committee for the decision
     */
    function getCommitteeId($status_id){
        return $this->Decision->getCommitteeId($this->getDecisionId($status_id));
    }

    /**
     * Getting all the related decision defined by the groupstatus id
     * $param id finds all the related decision
     */
    function getDecisionId($id){
        $data=$this->getData(array('decision_id'),array('id'=>$id));
        return $data[0]['Groupstatus']['decision_id'];
    }

    /**
     * Finding all the related user data defined by the user_id and status_id
     * $param user_id and status_id finds all the related user data
     */
    function userData($user_id,$status_id=null){
        $decision_id=$this->getDecisionId($status_id);
        $toret=$this->Decision->userData($user_id,$decision_id);
        return $toret;
    }
    
    /**
     * Get all status for all groups for the decision
     * $param decision array
     */
    function getHistory($groups,$dec_id) {
        $status = $this->find('all',array(
            'conditions'=>array('Groupstatus.group_id'=>$groups,'Groupstatus.decision_id'=>$dec_id),
            'order'=>'Groupstatus.created DESC'
            ));
        //debug($status);
        return $status;
    }
}
?>
