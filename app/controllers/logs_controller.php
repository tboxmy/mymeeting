<?php
class LogsController extends AppController {

    var $name = 'Logs';
    var $helpers = array('Html', 'Form');
    var $paginate = array(
        'order'=>array(
            'timestamp desc',
        ),
    );

    function index() {
        $this->Log->recursive = 0;
        
        // get the search terms
        if(!empty($this->data['Search']['user'])) $cursearch_user = $this->data['Search']['user'];
        elseif($this->Session->check('Search.user')) $cursearch_user = $this->Session->read('Search.user'); 
        else $cursearch_user = '';
        
        // construct queries
        $filters = array();
        if(isset($cursearch_user) && $cursearch_user!='') {
            array_push($filters,"User.name  like '%".$cursearch_user."%'");
            //$filters['User.username'] = 'LIKE %'.$cursearch_user.'%';
            $this->Session->write('Search.username', $cursearch_user);        
        }
        
        $this->set('logs', $this->paginate('Log', $filters));
    }

    function report() {
        
        
        $result=array();
        $report='';
        if(!empty($this->data['Search']['report'])) {
            $this->set('report',$this->data['Search']['report']);
            $result = $this->Log->getReport($this->data['Search']['report']);
            $report=$this->data['Search']['report'];
        }
        //debug($result);
        $reporttype = array('USERS'=>__('Users activity',true),'MEETINGS'=>__('No of meetings',true));
        $this->set('reporttype', $reporttype);
        $this->set('result',$result);
        $this->set('report',$report);
    }

    function delete_6_months() {
        ini_set("memory_limit","220M"); //if query too big
        set_time_limit ( 120 ) ; //give it more time to execute
        
        $logs = $this->Log->find('all',array('conditions'=>array("Log.timestamp <" => date('Y-m-d', strtotime("-24 weeks")))));
        foreach ($logs as $log) {
            $this->Log->del($log);
        }
        if (count($logs))
            $this->Session->setFlash(__('Logs have been deleted', true));
        else 
            $this->Session->setFlash(__('No logs older than 6 months found', true));
        $this->redirect(array('action'=>'index'));
    }
    
    function delete_1_year() {
        ini_set("memory_limit","220M"); //if query too big
        set_time_limit ( 120 ) ; //give it more time to execute
        
        $logs = $this->Log->find('all',array('conditions'=>array("Log.timestamp <" => date('Y-m-d', strtotime("-1 year")))));
        foreach ($logs as $log) {
            $this->Log->del($log);
        }
        if (count($logs))
            $this->Session->setFlash(__('Logs have been deleted', true));
        else 
            $this->Session->setFlash(__('No logs older than 1 year found', true));
        $this->redirect(array('action'=>'index'));
    }
}
?>
