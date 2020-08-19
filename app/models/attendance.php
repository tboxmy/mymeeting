<?php
class Attendance extends AppModel {
    var $name = "Attendance";
    var $belongsTo = array("Meeting","User");
    
    function saveInvitees($meetingid,$old,$new) {
        
        $remove = array_diff($old,$new); // TO REMOVE
        $add = array_diff($new,$old); // TO ADD
        //debug($remove);
        //debug($add);
        if(!isset($this->Meeting)){
            App::import('Model','Meeting');
            $this->Meeting=& ClassRegistry::init('Meeting');
        }
        if(!isset($this->Hash)){
            App::import('Model','Hash');
            $this->Hash=& ClassRegistry::init('Hash');
        }
        $meeting = $this->Meeting->findById($meetingid);
        if (!empty($remove)) {
            $r = $this->find('all',array('conditions'=>array('meeting_id'=>$meetingid,'user_id'=>$remove)));
            foreach ($r as $rval) { 
                $s = $this->findById($rval['Attendance']['id']);
                $s['Attendance']['deleted'] = 1;
                $s['Attendance']['deleted_date'] = date('Y-m-d H:i:s');
                $this->save($s);
                
                // remove from hash
                $this->Hash->removeData('confirm',$rval['Attendance']['id']);
            }
        }
        if (!empty($add)) {
            foreach ($add as $val) {
                $r = $this->find('first',array('conditions'=>array('meeting_id'=>$meetingid,'user_id'=>$val,'Attendance.deleted'=>'1')));
                if ($r) { // change deleted => 0
                    $r['Attendance']['deleted'] = 0;
                    $r['Attendance']['deleted_date'] = '0000-00-00 00:00:00';
                    $this->save($r);
                    $e[0]['Attendance']['id'] = $r['Attendance']['id'];
                } else { // add new
                    $this->create();
                    $data['meeting_id'] = $meetingid;
                    $data['user_id'] = $val;
                    $data['created'] = date('Y-m-d H:i:s');
                    $this->save($data);
                    $e[0]['Attendance']['id'] = $this->id;
                }
                
                // save into hash
                $e[0]['Meeting']['meeting_date'] = $meeting['Meeting']['meeting_date'];
                $this->Hash->insertToHashTable('confirm',$e);
            }
        }
    }
    
    function saveData($data) {
        $m = $this->findAllByMeetingId($data['Meeting']['id']);
        // confirmation
        $old = array();
        foreach ($m as $key=>$val) {
            $old['Attendance'][$val['Attendance']['user_id']]['will_attend'] = $val['Attendance']['will_attend'];
            $old['Attendance'][$val['Attendance']['user_id']]['attended'] = $val['Attendance']['attended'];
            $old['Attendance'][$val['Attendance']['user_id']]['excuse'] = $val['Attendance']['excuse'];
            $old['Attendance'][$val['Attendance']['user_id']]['id'] = $val['Attendance']['id'];
        }
        //debug($old);
        //($data);
        foreach ($data['Attendance'] as $key=>$val) {
            // compare with old data
            if ($val['will_attend']!='' && $val['will_attend'] !== $old['Attendance'][$key]['will_attend']) {
                $att = $this->findById($val['id']);
                if (!empty($val['rep_name']) && $data['Meeting']['allow_rep'] == '1' && $val['will_attend']=='0') {
                    $val['will_attend'] = '2'; // set to not attend but send a rep
                } 
                $att['Attendance']['will_attend'] = $val['will_attend'];
                $att['Attendance']['confirm_date'] = date('Y-m-d H:i:s');
                if (isset($val['rep_name']) && !empty($val['rep_name'])) 
                    $att['Attendance']['rep_name'] = $val['rep_name']; 
                if (isset($val['rep_name']) && !empty($val['excuse'])) 
                    $att['Attendance']['excuse'] = $val['excuse']; 
                $this->save($att);
                //debug($att);
            }
            
            if ($val['attended']!='' && $val['attended'] !== $old['Attendance'][$key]['attended']) {
                $att = $this->findById($val['id']);
                if (!empty($val['rep_name']) && $data['Meeting']['allow_rep'] == '1' && $val['attended']=='0') {
                    $val['attended'] = '2'; // set to not attend but send a rep
                } 
                $att['Attendance']['attended'] = $val['attended'];
                $att['Attendance']['att_updated'] = date('Y-m-d H:i:s');
                if (isset($val['rep_name']) && !empty($val['rep_name'])) 
                    $att['Attendance']['rep_name'] = $val['rep_name']; 
                if (isset($val['rep_name']) && !empty($val['excuse'])) 
                    $att['Attendance']['excuse'] = $val['excuse']; 
                $this->save($att);
                //debug($att);
            }
        }
    }
}
?>
