<?php
class Log extends AppModel {

	var $name = 'Log';
	var $validate = array(
		'user_id' => array('numeric'),
		'controller' => array('notempty'),
		'action' => array('notempty'),
		'url' => array('notempty')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	
	function getReport($type) {
	    
	    if ($type == 'USERS') {
            $sql = "select u.id, u.name, u.job_title, count(c.id) as comment, t.long_name
                    from titles as t, users as u
                    left join comments as c on (c.user_id=u.id)
                    where u.deleted!='1' and t.id=u.title_id
                    group by u.id
                    order by u.name asc";
            $m = $this->query($sql);
            $sql2 = "select u.id, u.name, u.job_title, count(us.id) as feedback
                    from users as u
                    left join userstatuses as us on (us.user_id=u.id)
                    where u.deleted!='1'
                    group by u.id
                    order by u.name asc";
            $n = $this->query($sql2);
            $sql3 = "select u.id, u.name, u.job_title, count(l.id) as login
                    from users as u
                    left join logs as l on (l.user_id=u.id and l.url='/')
                    where u.deleted!='1'
                    group by u.id
                    order by u.name asc";
            $o = $this->query($sql3);
            foreach ($m as $mkey=>$mval) 
                foreach ($n as $nval) 
                    if ($nval['u']['id']==$mval['u']['id']) 
                        $m[$mkey]['0'] = array_merge($mval['0'],$nval['0']); 
                foreach ($o as $oval) 
                    if ($oval['u']['id']==$mval['u']['id']) 
                        $m[$mkey]['0'] = array_merge($mval['0'],$oval['0']); 
                
            return $m;
            
        } else if ($type == 'MEETINGS') {
            // get num of decisions for each meeting
            $sql4 = "select c.name, m.id, m.meeting_num, m.meeting_title, count(d.id) as numofdec
                    from committees as c, meetings as m, decisions as d
                    where m.deleted!='1' and c.id=m.committee_id and c.deleted!='1' and d.deleted!='1' and d.meeting_id=m.id
                    group by m.id
                   ";
            $q = $this->query($sql4);
            //debug($q);
            $meetings = array();
            foreach($q as $qval) array_push($meetings, $qval['m']['id']);
            
            // get num of meetings for each committee
            $sql = "select c.name, m.id, m.meeting_num, m.meeting_title, count(m.id) as kuantiti
                    from committees as c
                    left join meetings as m on (c.id=m.committee_id and m.deleted!='1')
                    where c.deleted!='1'
                    group by m.id
                    order by c.name asc, m.meeting_title asc
                   ";
            $r = $this->query($sql);
            //debug($r);
            
            $sql2 = "select d.id,d.meeting_id, m.meeting_title, count(us.decision_id) as numofstat_usr
                    from meetings as m, decisions as d
                    left join userstatuses as us on (us.decision_id=d.id)
                    where d.meeting_id in (".implode(',',$meetings).") and d.meeting_id=m.id and m.deleted!='1' and d.deleted!='1'
                    group by d.meeting_id
                    order by us.updated desc
                    ";
            $s = $this->query($sql2);
            //debug($s);
            
            $sql3 = "select d.id,d.meeting_id, m.meeting_title, count(gs.decision_id) as numofstat_grp
                    from meetings as m, decisions as d
                    left join groupstatuses as gs on (gs.decision_id=d.id)
                    where d.meeting_id in (".implode(',',$meetings).") and d.meeting_id=m.id and m.deleted!='1' and d.deleted!='1'
                    group by d.meeting_id
                    order by gs.updated desc
                    ";
            $t = $this->query($sql3);
            //debug($t);
            
            // get all decisions
            $decisions = array();
            foreach ($s as $sval) array_push($decisions, $sval['d']['id']); 
            foreach ($t as $tval) array_push($decisions, $tval['d']['id']); 
            array_unique($decisions);
            //debug($decisions);
            
            // get assignments
            $sql5 = "select m.id
                    from meetings as m, decisions as d
                    left join decisions_users as du on (d.id=du.decision_id)
                    where m.id=d.meeting_id and m.deleted!='1' and d.deleted!='1' and `decision_id` in (".implode(',',$decisions).")
                    group by d.id
                    ";
            $u = $this->query($sql5);
            //debug($u);
            $sql6 = "select m.id
                    from meetings as m, decisions as d
                    left join decisions_groups as dg on (d.id=dg.decision_id)
                    where m.id=d.meeting_id and m.deleted!='1' and d.deleted!='1' and `decision_id` in (".implode(',',$decisions).")
                    group by d.id
                    ";
            $v = $this->query($sql6);
            //debug($v);
            
            // decision assignments
            $assgn_usr = array();
            $assgn_grp = array();
            foreach ($u as $uval) array_push($assgn_usr, $uval['m']['id']);
            foreach ($v as $vval) array_push($assgn_grp, $vval['m']['id']);
            
            // combine all these into 1 nice array
            foreach ($r as $rkey=>$rval) {
                // make sure all index exist
                isset($r[$rkey]['0']['numofdec']) ? '' : $r[$rkey]['0']['numofdec'] = '0';
                isset($r[$rkey]['0']['numofdec_assg_usr']) ? '' : $r[$rkey]['0']['numofdec_assg_usr'] = '0';
                isset($r[$rkey]['0']['numofdec_assg_grp']) ? '' : $r[$rkey]['0']['numofdec_assg_grp'] = '0';
                isset($r[$rkey]['0']['numofstat_usr']) ? '' : $r[$rkey]['0']['numofstat_usr'] = '0';
                isset($r[$rkey]['0']['numofstat_grp']) ? '' : $r[$rkey]['0']['numofstat_grp'] = '0';
                isset($r[$rkey]['0']['kuantiti']) ? '' : $r[$rkey]['0']['kuantiti'] = '0';
                
                // populate decision assignments
                if (in_array($rval['m']['id'],$assgn_usr)) $r[$rkey]['0']['numofdec_assg_usr'] = '1';
                if (in_array($rval['m']['id'],$assgn_grp)) $r[$rkey]['0']['numofdec_assg_grp'] = '1';
                
                // merge with the rest of sql
                foreach ($s as $sval) 
                    if ($sval['d']['meeting_id']==$rval['m']['id']) 
                        $r[$rkey]['0'] = array_merge($r[$rkey]['0'],$sval['0']); 
                foreach ($t as $tval) 
                    if ($tval['d']['meeting_id']==$rval['m']['id']) 
                        $r[$rkey]['0'] = array_merge($r[$rkey]['0'],$tval['0']); 
                foreach ($q as $qval) 
                    if ($qval['m']['id']==$rval['m']['id']) 
                        $r[$rkey]['0'] = array_merge($r[$rkey]['0'],$qval['0']); 
            }
            /*
             * $r now should be like this 
             *     [22] => Array
                    (
                        [c] => Array
                            (
                                [name] => TEST
                            )
                        [m] => Array
                            (
                                [id] => 29
                                [meeting_num] => Bil 9 Tahun 2008
                                [meeting_title] => Mesyuarat TEST
                            )
                        [0] => Array
                            (                    
                                [kuantiti] => 1
                                [numofdec] => 21
                                [numofdec_assg_usr] => 0
                                [numofdec_assg_grp] => 0
                                [numofstat_usr] => 9
                                [numofstat_grp] => 0
                            )
                    )
            */
            //debug($r);
            
            // sum up numofdec + kuantiti + numofstat for each meeting_title 
            $curmeetingtitle = '';
            $curr = '';
            $temparray = '';
            $tempkey = '';
            foreach ($r as $rkey=>$rval) {
                // first occurance of each committee/meeting_title -> get the stat values
                if ($curr != $rval['c']['name'].'/'.$rval['m']['meeting_title'] || $curr == '') {
                    $temparray = $rval['0'];
                    $tempkey = $rkey;
                }
                // only add those with the same meeting_title, store it in the first occurence
                if($curmeetingtitle == $rval['m']['meeting_title']) {
                    $r[$tempkey]['0']['kuantiti'] = intval($r[$rkey]['0']['kuantiti']) + intval($r[$tempkey]['0']['kuantiti']);
                    $r[$tempkey]['0']['numofdec'] = intval($r[$rkey]['0']['numofdec']) + intval($r[$tempkey]['0']['numofdec']);
                    $r[$tempkey]['0']['numofstat_usr'] = intval($r[$rkey]['0']['numofstat_usr']) + intval($r[$tempkey]['0']['numofstat_usr']);
                    $r[$tempkey]['0']['numofstat_grp'] = intval($r[$rkey]['0']['numofstat_grp']) + intval($r[$tempkey]['0']['numofstat_grp']);
                    $r[$tempkey]['0']['numofdec_assg_usr'] = intval($r[$rkey]['0']['numofdec_assg_usr']) + intval($r[$tempkey]['0']['numofdec_assg_usr']);
                    $r[$tempkey]['0']['numofdec_assg_grp'] = intval($r[$rkey]['0']['numofdec_assg_grp']) + intval($r[$tempkey]['0']['numofdec_assg_grp']);
                }
                
                $curmeetingtitle = $rval['m']['meeting_title'];
                $curr = $rval['c']['name'].'/'.$rval['m']['meeting_title'];
            }
            //debug($r);
            
            return $r;
        }
       
    }

}
?>
