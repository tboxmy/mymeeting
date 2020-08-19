<?php
uses('Folder','File');

class FixupShell extends Shell {
    var $uses = array('Decision','Wfmodel','Committee','Notification','Meeting','Template');
    /*var $templates=array(
        array("invite","Invitation to meeting","E-mail message to issue when inviting members to meetings","<p>Dear %name,</p><p>Please attend our meeting about %Meeting.meeting_title on %Meeting.meeting_date at %Meeting.venue.</p><p>Click %Link.meeting:here for more information</p><p>Thank you for your cooperation</p>"),
        array("uninvite","Cancel invitation to meeting","E-mail message to issue when canceling invitation to meetings","<p>Dear %name,</p><p>Please be advised that you do not require to attend our meeting about %Meeting.meeting_title on %Meeting.meeting_date at %Meeting.venue anymore.</p><p>Thank you for your cooperation</p>"),
        array("change","Changes to meeting","E-mail message to issue when there are changes to meetings","<p>Dear %name,</p><p>Please be advised that the meeting about %OldMeeting.meeting_title on %OldMeeting.meeting_date at %OldMeeting.venue has been changed to meeting about %Meeting.meeting_title on %Meeting.meeting_date at %Meeting.venue.</p><p>Click %Link.meeting:here for more information</p><p>Thank you for your cooperation</p>"),
        array("cancel","Meeting canceled","E-mail message to issue when meetings are canceled","<p>Dear %name,</p><p>Please be advised that the meeting about %Meeting.meeting_title on %Meeting.meeting_date at %Meeting.venue has been canceled.</p><p>Thank you for your cooperation</p>"),
        array("meeting reminder","Meeting reminder","E-mail message to issue when sending out reminders for meetings","<p>Dear %name,</p><p>Please be reminded that there is a meeting about %Meeting.meeting_title on %Meeting.meeting_date at %Meeting.venue.</p><p>Thank you for your cooperation</p>"),
        array("status reminder","Status reminder","E-mail message to issue when sending out reminders for statuses","<p>Dear %name,</p><p>Please be reminded that you have not yet submitted the status for the decision:</p><p>%Decision.description</p><p>which has been assigned to you at the %Meeting.meeting_title meeting on %Meeting.meeting_date. You have another %days_left days left to submit the status.</p><p>Click %Link.decision:here to go to the decision</p><p>Thank you for your cooperation</p>"),
        array("meeting comment","Comment Sent To Meeting","E-mail message to issue when sending when comments are sent to a meeting","<p>Dear %name,</p><p>%Comment.user commented in the %Meeting.meeting_num meeting. The comment was:</p><p>%Comment.comment</p><p>Click %Link.meeting:here to go to the meeting</p><p>Thank you for your cooperation</p>"),
        array("decision comment","Comment Sent To Decision","E-mail message to issue when sending when comments are sent on a decision","<p>Dear %name,</p><p>%Comment.user commented on a decision made in the %Meeting.meeting_num meeting. The decision is:</p><p>%Decision.description</p><p>The comment was:</p><p>%Comment.comment</p><p>Click %Link.decision:here to go to the decision</p><p>Thank you for your cooperation</p>"),
        array("status comment","Comment Sent To Status","E-mail message to issue when sending when comments are sent on a status","<p>Dear %name,</p><p>%Comment.user commented on a status made in the %Meeting.meeting_num meeting. The decision is:</p><p>%Decision.description</p><p>The status is:</p>%Status.description</p><p>The comment was:</p><p>%Comment.comment</p><p>Click %Link.decision:here to go to the status</p><p>Thank you for your cooperation</p>"),
        array("decision assigned","Decision assigned","E-mail message to issue when sending when decisions are assigned to user","<p>Dear %name,</p><p>A decision made in the %Meeting.meeting_num meeting was assigned to you. The decision is:</p><p>%Decision.description</p><p>The deadline for the decision is: %Decision.deadline</p><p>Click %Link.decision:here to go to the decision</p><p>Thank you for your cooperation</p>"),
    );

    var $templates2=array(
        array("forgot password","New password for MyMeeting","Email to send out when user forgets his password","<p>Dear %name,</p><p>A request has been made to reset your password. MyMeeting has automatically generated the password for you.</p><p>Your new password is: %newpassword</p><p>Thanks</p>"),
        array("forgot username","Username retrieval for MyMeeting","Email to send out when user forgets his username","<p>Dear %name,</p><p>A request has been made to retrieve your username.</p><p>Your username is: %username</p><p>Thanks</p>"),
    );*/
    
    var $templates=array(
        array("invite","Jemputan ke mesyuarat","Emel yang dihantar untuk menjemput ahli ke mesyuarat","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>JEMPUTAN KE MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sukacita dimaklumkan bahawa satu mesyuarat  %Meeting.meeting_title akan diadakan. Maklumat adalah seperti berikut:</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>Maklumat mesyuarat: %Link.meeting:Sini</p><p>3. Tuan/puan adalah dengan segala hormatnya dijemput hadir. Pengesahan kehadiran boleh dilakukan di %Link:confirm:sini. Kerjasama dan perhatian tuan/puan didahului dengan ucapan terima kasih.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("uninvite","Tidak perlu hadir ke mesyuarat","Emel untuk dihantar sekiranya mesyuarat dibatalkan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>JEMPUTAN KE MESYUARAT DIBATALKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Adalah ini dimaklumkan bahawa tuan/puan tidak perlu menghadiri mesyuarat  %Meeting.meeting_title seperti berikut:</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("change","Perubahan mesyuarat","Emel untuk dihantar jika terdapat perubahan kepada maklumat mesyuarat","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>PERUBAHAN MASA/TEMPAT MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Adalah ini dimaklumkan bahawa terdapat perubahan untuk mesyuarat  %OldMeeting.meeting_title . Maklumat lama adalah seperti berikut:</p><p>Tarikh &amp; masa (lama): %OldMeeting.meeting_date</p><p>Tempat (lama): %OldMeeting.venue</p><p><span style='text-decoration: underline;'>Maklumat mesyuarat terkini adalah seperti berikut:</span></p><p>Mesyuarat: %Meeting.meeting_title</p><p>Tarikh &amp; masa: %Meeting.meeting_date</p><p>Tempat: %Meeting.venue</p><p>3. Maklumat mesyuarat boleh dilihat di %Link.meeting:sini. Tuan/puan adalah dengan segala hormatnya dijemput hadir. Kerjasama dan perhatian tuan/puan didahului dengan ucapan terima kasih.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("cancel","Pembatalan mesyuarat","Emel untuk dihantar sekiranya mesyuarat dibatalkan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>PEMBATALAN MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Dukacita dimaklumkan bahawa mesyuarat  %Meeting.meeting_title telah dibatalkan.</p><p>Terima kasih.</p>"),
        array("meeting reminder","Peringatan mesyuarat","Emel untuk dihantar sebagai peringatan mesyuarat yang akan datang","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>PERINGATAN UNTUK HADIR KE MESYUARAT</span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sebagai peringatan, adalah dengan ini dimaklumkan bahawa tuan/puan telah dijemput untuk menghadiri mesyuarat  %Meeting.meeting_title pada %Meeting.meeting_date di %Meeting.venue.</p><p>Terima kasih.</p>"),
        array("status reminder","Peringatan kemaskini status tindakan","Emel untuk menghantar peringatan kepada ahli mesyuarat untuk mengemaskini status tindakan.","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>PERINGATAN UNTUK MENGEMASKINI STATUS TINDAKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Sebagai peringatan, adalah dengan ini dimaklumkan bahawa tuan/puan masih belum mengemaskini status tindakan tuan/puan untuk keputusan mesyuarat seperti berikut:</p><p>=================<br /> %Decision.description<br /> =================</p><p>yang telah dipertanggungjwabkan kepada tuan/puan di dalam mesyuarat %Meeting.meeting_title pada %Meeting.meeting_date. Tuan/puan masih mempunyai %days_left hari lagi untuk membuat kemaskini.</p><p>3. Tuan/puan klik di  %Link.decision:sini untuk melihat maklumat keputusan.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("meeting comment","Komen untuk mesyuarat","Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk mesyuarat","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK MESYUARAT<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>3. Maklumat mesyuarat boleh dilihat di %Link.meeting:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("decision comment","Komen untuk keputusan","Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk keputusan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK MESYUARAT<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk keputusan yang dibuat dalam mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>Keputusan yang dirujuk adalah:</p><p>================<br /> %Decision.description<br /> ================</p><p>3. Maklumat keputusan boleh dilihat di %Link.decision:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("status comment","Komen untuk status","Emel untuk dihantar apabila terdapat komen yang ditinggalkan untuk status tindakan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MAKLUMAN TENTANG KOMEN YANG DITINGGALKAN UNTUK STATUS TINDAKAN<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. %Comment.user telah meninggalkan komen untuk status tidakan yang telah diambil bagi keputusan yang dibuat dalam mesyuarat %Meeting.meeting_num. Komennya adalah seperti berikut:</p><p>================<br /> %Comment.comment<br /> ================</p><p>Keputusan yang dirujuk adalah:</p><p>================<br /> %Decision.description<br /> ================</p><p>Status tindakan yang dirujuk adalah:</p><p>================<br /> %Status.description<br /> ================</p><p>3. Maklumat keputusan dan status tindakan boleh dilihat di %Link.decision:sini.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
    );
    var $templates2=array(
        array("forgot password","Kata laluan baru","Emel yang dihantar apabila ahli terlupa kata laluan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>KATA LALUAN BARU<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk set semula kata laluan tuan/puan. Oleh yang demikian, kata laluan baru telah dijana untuk kegunaan tuan/puan. Kata laluan baru tuan/puan ialah %newpassword</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        array("forgot username","Dapatkan semula kata nama","Emel yang dihantar apabila ahli terlupa kata nama","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MENDAPATKAN SEMULA KATA NAMA<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk mendapatkan semula kata nama tuan/puan.&nbsp; Kata nama tuan/puan ialah %username</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
    );
    /**
     * Displays a header for the shell (overwite parent's welcome message
     *
     * @access protected
     */
    function _welcome() {
        $this->hr();
        $this->out(__('Welcome to the MyMeeting console'));
        $this->out("---------------------------------------------------------------");
        $this->out('App : '. $this->params['app']);
        $this->out('Path: '. $this->params['working']);
        $this->out('CakePHP: '. Configure::version());
        $this->hr();
    }
    
    function help(){
        $this->out(__('Fixup options:',true));
        $this->out(__('defaultmessages - restore default messages for the whole system and for every committee',true));
        $this->out(__('messages - create default messages for the system and committee if the message does not yet exist',true));
        $this->out(__('defaultwfmodels - restore default permissions for all the committee for the whole system',true));
        $this->out(__('cleanminutes - remove any mymeeting tagging from the minutes',true));
        $this->out(__('database - update the database to the latest schema',true));
        $this->out(__('dumpdb - dump the database for backup',true));
        $this->out(__('resettree - build tree structure for the first time, this will bring all committees on top level',true));
        $this->out(__('fixpermission - create necessary files/folders and fix the permission',true));
        $this->out(' ');
    }

    function systemdefaultmessages($templates,$model){
        foreach($templates as $template){
            $this->out(__('Setting system message for',true).' '.$template[0]);
            $curtemplate=$this->Template->find('all',array('conditions'=>array('model'=>$model,'type'=>$template[0])));
            if($curtemplate){
                $data['id']=$curtemplate[0]['Template']['id'];
            }
            else{
                if(isset($data['id'])){
                    unset($data['id']);
                }
            }
            $data['type']=$template[0];
            $data['title']=$template[1];
            $data['description']=$template[2];
            $data['template']=$template[3];
            $data['model']=$model;
            $this->Template->create();
            $this->Template->save($data);
        }
    }

    function defaultmessages(){
        $this->Template=& new Template(null);
        $db=& $this->Template->getDataSource();
        $this->Template->query('delete from '.$db->fullTableName('templates'));
        $this->systemdefaultmessages($this->templates,'System');
        $this->systemdefaultmessages($this->templates2,'SystemOnly');
        $templates=$this->Template->find('all',array('conditions'=>array('model'=>'System')));
        foreach($templates as $template){
            $committees=$this->Committee->findAll();
            foreach($committees as $committee){
                $this->out('Setting '.$committee['Committee']['short_name'].' committee message for '.$template['Template']['type']);
                $comtemplates=$this->Template->find('all',array(
                    'conditions'=>array(
                        'model'=>'Committee',
                        'foreign_key'=>$committee['Committee']['id'],
                        'type'=>$template['Template']['type'],
                    ),
                ));
                if(count($comtemplates)){
                    $dtemplate['id']=$comtemplates[0]['Template']['id'];
                }
                else{
                    if(isset($dtemplate['id'])){
                        unset($dtemplate['id']);
                    }
                }
                $dtemplate['model']='Committee';
                $dtemplate['foreign_key']=$committee['Committee']['id'];
                $dtemplate['type']=$template['Template']['type'];
                $dtemplate['title']=$template['Template']['title'];
                $dtemplate['description']=$template['Template']['description'];
                $dtemplate['template']=$template['Template']['template'];
                $this->Template->create();
                if($this->Template->save($dtemplate)){
                    $this->out('Success');
                }
                else{
                    $this->out('Fail');
                }
            }
        }
    }

    function messages(){
        $templates=$this->templates;
        $this->Template=& new Template(null);
        foreach($templates as $template){
            $curtemplate=$this->Template->find('all',array('conditions'=>array('model'=>'System','type'=>$template[0])));
            if(!$curtemplate){
                $data['type']=$template[0];
                $data['title']=$template[1];
                $data['description']=$template[2];
                $data['template']=$template[3];
                $data['model']='System';
                $this->Template->create();
                $this->Template->save($data);
            }
        }
        $templates=$this->Template->find('all',array('conditions'=>array('model'=>'System')));
        foreach($templates as $template){
            $committees=$this->Committee->findAll();
            foreach($committees as $committee){
                $comtemplates=$this->Template->find('all',array(
                    'conditions'=>array(
                        'model'=>'Committee',
                        'foreign_key'=>$committee['Committee']['id'],
                        'type'=>$template['Template']['type'],
                    ),
                ));
                if(!count($comtemplates)){
                    $this->out('Setting '.$template['Template']['type'].' message for '.$committee['Committee']['short_name'].' committee');
                    $dtemplate['model']='Committee';
                    $dtemplate['foreign_key']=$committee['Committee']['id'];
                    $dtemplate['type']=$template['Template']['type'];
                    $dtemplate['title']=$template['Template']['title'];
                    $dtemplate['description']=$template['Template']['description'];
                    $dtemplate['template']=$template['Template']['template'];
                    $this->Template->create();
                    $this->Template->save($dtemplate);
                }
            }
        }
    }

    function cleanminutes(){
        $meetings=$this->Meeting->find('all');
        foreach($meetings as $meeting){
            $this->out('Cleaning minute for meeting '.$meeting['Meeting']['meeting_num']);
            $meeting['Meeting']['minutes']=str_replace(array('{{','}}','[[',']]','((','))','###'),'',$meeting['Meeting']['minutes']);
            $this->Meeting->save($meeting);
        }
    }

    function cleandecisions(){
        $decisions=$this->Decision->find('all',array('contain'=>false));
        $i=1;
        foreach($decisions as $decision){
            $this->out('Cleaning description for decision '.$i++.' of '.count($decisions));
            $decision['Decision']['description']=str_replace(array('{{','}}','[[',']]','((','))','###','g:','G:'),'',$decision['Decision']['description']);
            $decision['Decision']['description']=preg_replace('|<!--.*-->|','',$decision['Decision']['description']);
            $pattern='style="[^"]*"';
            $replacement='';
            $decision['Decision']['description']=eregi_replace($pattern,$replacement,$decision['Decision']['description']);
            $this->Decision->save($decision);
        }
    }

    function defaultwfmodels(){
        $models=array('Committee', 'Committeetodo', 'Group', 'Membership', 'Workflow', 'Wfmodel', 'Item', 'Announcement', 'Template', 'Meeting', 'Attendance', 'Meetingtodo', 'Decision', 'Userstatus', 'Groupstatus');
        $this->Wfmodel->deleteAll('1=1');
        $committees=$this->Committee->find('all');
        $ownercreate=array('Userstatus','Groupstatus');
        $restrictedview=array('Committee','Committeetodo','Template','Attendance','Meetingtodo','Wfmodel','Workflow');
        foreach($committees as $committee){
            $this->out('Restoring default wfmodels for '.$committee['Committee']['short_name'].' committee');
            foreach($models as $model){
                $this->out("\tRestoring ".$model." model");
                $wfmodel['Wfmodel']['model']=$model;
                $wfmodel['Wfmodel']['committee_id']=$committee['Committee']['id'];
                if(in_array($model,$ownercreate)){
                    $wfmodel['Wfmodel']['create']='role:admin,owner';
                    $wfmodel['Wfmodel']['edit']='role:admin,owner';
                }
                else{
                    $wfmodel['Wfmodel']['create']='role:admin';
                    $wfmodel['Wfmodel']['edit']='role:admin';
                }
                if(in_array($model,$restrictedview)){
                    $wfmodel['Wfmodel']['view']='role:admin';
                }
                else{
                    $wfmodel['Wfmodel']['view']='all';
                }
                $wfmodel['Wfmodel']['delete']='role:admin';
                $this->Wfmodel->create();
                $this->Wfmodel->save($wfmodel);
            }
        }
    }

    function decisionorder(){
        $meetings=$this->Meeting->find('all',array('contain'=>false));
        foreach($meetings as $meeting){
            $decisions=$this->Decision->find('all',array(
                'contain'=>false,
                'conditions'=>array(
                    'meeting_id'=>$meeting['Meeting']['id'],
                ),
                'order'=>array(
                    'updated',
                ),
            ));
            $number=0;
            foreach($decisions as $decision){
                $decision['Decision']['ordering']=$number++;
                $this->Decision->save($decision);
            }
        }
    }

    function dumpdb(){
        App::import('Model', 'Schema');
        $this->Schema =& new CakeSchema(compact('name', 'path', 'file', 'connection'));
        $db =& ConnectionManager::getDataSource($this->Schema->connection);
        $filepos='../../sql/'.date('Ymd').'dump.sql';
        if(file_exists($filepos)){
            $postfix=1;
            while(file_exists($filepos.'.'.$postfix)){
                $postfix++;
            }
            $filepos=$filepos.'.'.$postfix;
        }
        if(strlen($db->config['password'])){
            exec('mysqldump -u '.$db->config['login'].' -p'.$db->config['password'].' '.$db->config['database'].'>'.$filepos);
        }
        else{
            exec('mysqldump -u '.$db->config['login'].' '.$db->config['database'].'>'.$filepos);
        }
        $this->out('Database dumped to '.realpath($filepos));
    }

    function database(){
        $this->dumpdb();
        App::import('Model', 'Schema');
        $run=false;
        $name = null;
        if (!empty($this->params['name'])) {
            $name = $this->params['name'];
            $this->params['file'] = Inflector::underscore($name);
        }

        $path = null;
        if (!empty($this->params['path'])) {
            $path = $this->params['path'];
        }

        $file = null;
        if (empty($this->params['file'])) {
            $this->params['file'] = 'schema.php';
        }
        if (strpos($this->params['file'], '.php') === false) {
            $this->params['file'] .= '.php';
        }
        $file = $this->params['file'];

        $connection = null;
        if (!empty($this->params['connection'])) {
            $connection = $this->params['connection'];
        }
        $this->Schema =& new CakeSchema(compact('name', 'path', 'file', 'connection'));
        $db =& ConnectionManager::getDataSource($this->Schema->connection);
        $file = $this->Schema->load();

        /* Get all the table currently exists in the database to be compared to the schema */
        $rawtables=$db->query('show tables');
        foreach($rawtables as $rawtable){
            foreach($rawtable as $tablename){
                foreach($tablename as $dtable){
                    $tables[]=$dtable;
                }
            }
        }

        /* Find out if any of the tables in the schema does not exists in the database */
        foreach($file->tables as $table=>$datastruct){
            if(!in_array($table,$tables)){
                $this->out("$table does not exists in database");
                $tocreate[]=$table;
            }
        }

        /* List of all the known past names of current table */
        $pastnames = array(
            'meetingtodos'=>array('meetings_todos'),
            'committeetodos'=>array('committees_todos'),
            'systemtodos'=>array('todos'),
            'attendances'=>array('meetings_users'),
            'memberships'=>array('committees_users'),
        );

        /* Create query any tables which does not exists */
        if(isset($tocreate)){
            foreach($tocreate as $table){
                /* if the table had a past name check to see whether the said name is in the database */
                $createit=true;
                if(array_key_exists($table,$pastnames)){
                    foreach($pastnames[$table] as $prevtable){
                        if(in_array($prevtable,$tables)){
                            $operation[$table]='rename table '.$prevtable.' to '.$table;
                            $createit=false;
                        }
                    }
                }
                if($createit){
                    $operation[$table] = $db->createSchema($file, $table);
                }
            }
        }

        /* Run query to create tables */
        if(isset($operation)){
            $this->_run($operation);
            $run=true;
            unset($operation);
        }

        /* Now read the schema from the database and compare with the file */
        $database = $this->Schema->read();
        $compare = $this->Schema->compare($database, $file);

        /* Create query to alter table for every difference found */
        foreach ($compare as $table => $changes) {
            if(array_key_exists($table,$database['tables'])){
                $this->out('Will alter '.$table);
                $operation[$table] = $db->alterSchema(array($table => $changes), $table);
            }
        }

        /* Run query to alter tables */
        if(isset($operation)){
            $this->_run($operation);
            $run=true;
        }
        if(!$run){
            $this->out('Database is up to-date');
        }
    }

    function _run($contents){
        $db =& ConnectionManager::getDataSource($this->Schema->connection);
        foreach ($contents as $table=>$sql){
            $this->out('Running '.$sql);
            $db->_execute($sql);
        }
    }

    function shiftdecisions(){
        $committees=$this->Committee->find('all',array('contain'=>false));
        foreach($committees as $committee){
            $meetings=$this->Meeting->find('all',array(
                'conditions'=>array(
                    'Meeting.committee_id'=>$committee['Committee']['id'],
                ),
                'order'=>array(
                    'Meeting.meeting_date asc',
                ),
                'contain'=>false,
            ));
            foreach($meetings as $mid=>$meeting){
                if(isset($meetings[$mid+1])){
                    $decisions=$this->Decision->find('all',array(
                        'conditions'=>array(
                            'Decision.meeting_id'=>$meetings[$mid+1]['Meeting']['id'],
                        ),
                    ));
                    foreach($decisions as $decision){
                        $decision['Decision']['meeting_id']=$meeting['Meeting']['id'];
                        $this->Decision->save($decision);
                    }
                }
            }
        }
    }

    function resettree() {
        $this->Committee->displayField ='name';
        $committees = $this->Committee->find('list',array('conditions'=>array('deleted'=>array('0','1')),'order'=>'name asc'));

        $this->out(__('Preparing the data...',true));
        if (!count($committees)) $this->out(__('No committees found',true));
        else {

            // reset all to zero
            foreach($committees as $comid=>$name) {
                $c = $this->Committee->find('first',array('conditions'=>array('id'=>$comid,'deleted'=>array(0,1))));
                $c['Committee']['parent_id'] = 0;
                $c['Committee']['lft'] = '0';
                $c['Committee']['rght'] = '0';
                $c['Committee']['short_name'] = str_replace(' ','',$c['Committee']['short_name']); //strip all spaces, if not it wont save (validation)
                $this->Committee->Behaviors->detach('Tree');
                $this->Committee->unbindModel(array('hasAndBelongsToMany'=>array('User')),false);
                if ($this->Committee->save($c)) $this->out($name.' '.__('..yes',true));
                else $this->out($name.' '.__('..no',true));
            }
            $this->out('');
            $i=1;
            // then assign left n right value
            $this->out(__('Resetting committees to top level...',true));
            foreach($committees as $comid=>$name) {
                $c = $this->Committee->find('first',array('conditions'=>array('id'=>$comid,'deleted'=>array('0','1')),'contain'=>'Group'));
                //$c['Committee']['parent_id'] = 0;
                $c['Committee']['lft'] = $i++;
                $c['Committee']['rght'] = $i++;
                $this->Committee->Behaviors->attach('Tree');
                $this->Committee->unbindModel(array('hasAndBelongsToMany'=>array('User')),false);
                if ($this->Committee->save($c)) $this->out($name.' '.__('..yes',true));
                else $this->out($name.' '.__('..no',true));
            }
            $this->out('');

        }

    }
    
    function fixpermission(){
        $this->out(__("Please make sure you're running this command as the owner of the files.",true));
        $this->out(__('Fixing permission...',true));
        define('UPLOAD_PATH',APP_PATH . 'webroot' . DS . 'upload');
        if(!is_dir(UPLOAD_PATH)){
            mkdir(UPLOAD_PATH);
        }
        chmod(UPLOAD_PATH,0777) ? $this->out(UPLOAD_PATH.' '.__('..yes',true)) : $this->out(UPLOAD_PATH.' '.__('no',true));
        
        define('LOGO_PATH',APP_PATH . 'webroot' . DS . 'img' . DS . 'logo');
        if(!is_dir(LOGO_PATH)){
            mkdir(LOGO_PATH);
        }
        chmod(LOGO_PATH,0777)? $this->out(LOGO_PATH.' '.__('..yes',true)) : $this->out(LOGO_PATH.' '.__('no',true));
        
        define('TMP_PATH',APP_PATH . 'tmp');
        if(!is_dir(TMP_PATH)){
            mkdir(TMP_PATH);
        }
        chmod(TMP_PATH,0777)? $this->out(TMP_PATH.' '.__('..yes',true)) : $this->out(TMP_PATH.' '.__('no',true));
        
        define('CAKESESSION_PATH',TMP_PATH . DS . 'sessions');
        if(!is_dir(CAKESESSION_PATH)){
            mkdir(CAKESESSION_PATH);
        }
        chmod(CAKESESSION_PATH,0777)? $this->out(CAKESESSION_PATH.' '.__('..yes',true)) : $this->out(CAKESESSION_PATH.' '.__('no',true));
        
        define('LOG_PATH',TMP_PATH . DS . 'logs');
        if(!is_dir(LOG_PATH)){
            mkdir(LOG_PATH);
        }
        chmod(LOG_PATH,0777)? $this->out(LOG_PATH.' '.__('..yes',true)) : $this->out(LOG_PATH.' '.__('no',true));
        
        define('CACHE_PATH',TMP_PATH . DS . 'cache');
        if(!is_dir(CACHE_PATH)){
            mkdir(CACHE_PATH);
        }
        chmod(CACHE_PATH,0777)? $this->out(CACHE_PATH.' '.__('..yes',true)) : $this->out(CACHE_PATH.' '.__('no',true));
        
        if(stristr(PHP_OS,'WIN')){
            $this->windowsht(ROOT);
            $this->windowsht(APP_PATH);
            $this->windowsht(APP_PATH . DS . 'webroot');
        }
    }
    function windowsht($path){
        $this->out(__('Renaming .htaccess...',true));
        $this->out(__('currently at',true).' '.$path);
        if(is_file($path . DS . '.htaccess')) {
            $this->out(__('renaming at',true).' '.$path);
            rename($path . DS . '.htaccess' , $path . DS . 'htaccess.txt');
        }
    }
}
?>
