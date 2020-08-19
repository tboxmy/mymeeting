<?php
require_once "schema.php";

uses('Folder','File','model'.DS.'connection_manager');

class InstallShell extends Shell {
    var $tasks = array('DbConfig');
    /**
     * Outputs to the stdout filehandle.
     *
     * @param string $string String to output.
     * @param boolean $newline If true, the outputs gets an added newline.
     * @access public
     */
    function stdout($string, $newline = true) {
        if ($newline) {
            fwrite($this->stdout, $string . "\n");
        } else {
            fwrite($this->stdout, $string);
        }
    }
    /**
     * Prompts the user for input, and returns it.
     *
     * @param string $prompt Prompt text.
     * @param mixed $options Array or string of options.
     * @param string $default Default input value.
     * @return Either the default value, or the user-provided input.
     * @access public
     */
    function getInput($prompt, $options = null, $default = null) {
        if (!is_array($options)) {
            $print_options = '';
        } else {
            $print_options = '(' . implode('/', $options) . ')';
        }

        if ($default == null) {
            $this->stdout($prompt . " $print_options \n" . '> ', false);
        } else {
            $this->stdout($prompt . " $print_options \n" . "[$default] > ", false);
        }
        $result = fgets($this->stdin);

        if ($result === false){
            exit;
        }
        $result = trim($result);

        if ($default != null && empty($result)) {
            return $default;
        } else {
            return $result;
        }
    }
    /**
     * Removes first argument and shifts other arguments up
     *
     * @return boolean False if there are no arguments
     * @access public
     */
    function shiftArgs() {
        if (empty($this->args)) {
            return false;
        }
        unset($this->args[0]);
        $this->args = array_values($this->args);
        return true;
    }

    function main(){
        $this->stdin = fopen('php://stdin', 'r');
        $this->stdout = fopen('php://stdout', 'w');
        $this->stderr = fopen('php://stderr', 'w');

        $install=$this->in(__('This will install MyMeeting on your system. Would you like to continue?'),array('y','n'),'y');
        switch(strtoupper($install)){
        case 'Y':
            $this->out(__('Installing...'));
            $this->install();
            break;
        case 'N':
            $this->out(__('Quiting..'));
            break;
        }
        }
    /**
     * Displays a header for the shell
     *
     * @access protected
     */
    function _welcome() {
        $this->hr();
        $this->out(__('Welcome to the MyMeeting installer'));
        $this->out("---------------------------------------------------------------");
        $this->out('App : '. $this->params['app']);
        $this->out('Path: '. $this->params['working']);
        $this->out('CakePHP: '. Configure::version());
        $this->hr();
    }

    function install(){

        if(file_exists(CONFIGS . DS . 'database.php')){
            $db =@ConnectionManager::getDataSource('default');
            if($db->connected){
                $setupdb=$this->in(__('Database is already set. Do you want to reconfigure it?'),array('y','n'),'n');
                if(strtoupper($setupdb)=='Y'){
                    $this->DbConfig->execute($db);
                    $this->out(__('New settings have been written. Please run the installation script again'));
                    exit();
                }
            }
            else{
                $this->out(__('There is a problem connecting to the database. Please make sure that the database '));
                $this->out(' '.$db->config['database'].' ');
                $this->out(__('exists and that the mysql user'));
                $this->out(' '.$db->config['login'].' ');
                $this->out(__('has proper access to it. You can run `cake createdb` to do it for you and then run this script again.'));
                $setupdb=$this->in(__('Or do you want to create a new configuration?'),array('y','n'));
                if(strtoupper($setupdb)=='Y'){
                    $this->DbConfig->execute($db);
                    $this->out(__('New settings have been written. Please run the installation script again'));
                }
                exit();
            }
        }
        else{
            $this->DbConfig->execute();
            $db =@ConnectionManager::getDataSource('default');
            if(!$db->connected){
                
                $this->out(__('There is a problem connecting to the database. Please make sure that the database '));
                $this->out(' '.$db->config['database'].' ');
                $this->out(__('exists and that the mysql user'));
                $this->out(' '.$db->config['login'].' ');
                $this->out(__('has proper access to it. You can run `cake createdb` to do it for you and then run this script again.'));
                exit();
            }
        }

        $schema=& new SchemaShell($this);
        $schema->startup();
        $schema->args[0]='create';
        $schema->run();

        Configure::write('debug', 0); 

        $this->systemsettings();
        $this->setmymeeting();
        $this->installdata();
    }

    function installdata(){
        $this->out('');
        $this->out(__('Installing default data...',true));
        App::import('Model','User');
        $this->User=& new User(null);
        $adminuser=$this->User->field('id',array('conditions'=>array('username'=>'admin')));
        if($adminuser){
            $data['id']=$adminuser;
        }
        $data['username']='admin';
        $data['name']='admin';
        $data['superuser']=1;
        $data['email']=Configure::read('email_from');
        App::import('Component','Auth');
        $this->Auth=& new AuthComponent(null);
        $data['password']=$this->Auth->password('123456');
        $this->User->save($data,false) ? $this->out(__('Creating default user admin with password 123456',true).__('..yes',true)) : $this->out(__('Creating default user admin with password 123456',true).__('..no',true));
        

        App::import('Model','Role');
        $this->Role=& new Role(null);
        $roles=array('admin','member');
        unset($data);
        foreach($roles as $drole){
            $currole=$this->Role->field('id',array('conditions'=>array('name'=>$drole)));
            if(!$currole){
                $data['name']=$drole;
                $this->Role->create();
                $this->Role->save($data);
            }
        }
        $this->out(__('Creating default roles: admin, member',true).__('..yes',true));

        App::import('Model','Title');
        $this->Title=& new Title(null);
        $titles=array(
            array('Y.Bhg Tan Sri','Y.Bhg Tan Sri'),
            array('Y.Bhg Datuk','Y.Bhg Datuk'),
            array('Y.Bhg Dato\'','Y.Bhg Dato\''),
            array('Y.Brs Dr.','Y.Brs Dr.'),
            array('Hj.','Hj.'),
            array('En.','En.'),
            array('Pn.','Pn.'),
            array('Cik','Cik'),
        );
        unset($data);
        foreach($titles as $title){
            $curtitle=$this->Title->field('id',array('conditions'=>array('short_name'=>$title[0])));
            if(!$curtitle){
                $data['short_name']=$title[0];
                $data['long_name']=$title[1];
                $this->Title->create();
                $this->Title->save($data);
            }
        }
        $this->out(__('Creating default titles',true).__('..yes',true));

        App::import('Model','Template');
        $this->Template=& new Template(null);
        $templates=array(
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
        unset($data);
        foreach($templates as $template){
            $curtemplate=$this->Template->field('id',array('conditions'=>array('model'=>'system','type'=>$template[0])));
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
        $templates2=array(
            array("forgot password","Kata laluan baru","Emel yang dihantar apabila ahli terlupa kata laluan","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>KATA LALUAN BARU<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk set semula kata laluan tuan/puan. Oleh yang demikian, kata laluan baru telah dijana untuk kegunaan tuan/puan. Kata laluan baru tuan/puan ialah %newpassword</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
            array("forgot username","Dapatkan semula kata nama","Emel yang dihantar apabila ahli terlupa kata nama","<p>ASSALAMUALAIKUM DAN SALAM SEJAHTERA</p><p>%name,</p><p><strong><span style='text-decoration: underline;'>MENDAPATKAN SEMULA KATA NAMA<br /></span></strong></p><p>Dengan segala hormatnya merujuk perkara di atas.</p><p>2. Satu permintaan telah dilakukan di MyMeeting untuk mendapatkan semula kata nama tuan/puan.&nbsp; Kata nama tuan/puan ialah %username</p><p>Harap maklum.</p><p>&nbsp;</p><p>Terima kasih.</p>"),
        );
        unset($data);
        foreach($templates2 as $template){
            $curtemplate=$this->Template->field('id',array('conditions'=>array('model'=>'SystemOnly','type'=>$template[0])));
            if(!$curtemplate){
                $data['type']=$template[0];
                $data['title']=$template[1];
                $data['description']=$template[2];
                $data['template']=$template[3];
                $data['model']='SystemOnly';
                $this->Template->create();
                $this->Template->save($data);
            }
        }
        $this->out(__('Creating default message templates',true).__('..yes',true));
        $this->hr();
        $this->out(__('Installation completed! You can now login with username admin and password 123456',true));
        $this->out('');
    }

    function setmymeeting(){
        $this->out('');
        $this->out(__('Setting agency details...',true));
        $mymeeting['agency_name']=$this->in(__('Agency name:'));
        $mymeeting['agency_address']=$this->in(__('Agency address:'));
        $mymeeting['agency_slogan']=$this->in(__('Agency slogan:'));
        $mymeeting['date_format']=$this->in(__('Date format:'),null,'d/m/Y');
        $mymeeting['time_format']=$this->in(__('Time format:'),null,'H:i a');
        $mymeeting['server_url']=$this->in(__('Server Address (eg http://www.agensi.gov.my, http://www.agensi.gov.my/mymeeting):'));
        $mymeeting['email_from']=$this->in(__('E-mail from:'));
        $mymeeting['email_from_name']=$this->in(__('E-mail from name:'));
        $mymeeting['email_host']=$this->in(__('E-mail host:'),null,'localhost');
        $mymeeting['email_port']=$this->in(__('E-mail port:'),null,'25');
        $mymeeting['days_to_remind']=$this->in(__('Days to remind:'),null,'7');
        $mymeeting['version']='v2.2';
        $mymeeting['defaultrole']='admin';
        Configure::write('email_from',$mymeeting['email_from']);
        $output="<?php\n";
        $output.="\t/* Usage: \n";
        $output.="\t * Configure::write('One.key1', 'value of the Configure::One[key1]');\n";
        $output.="\t * Configure::read('Name'); will return all values for Name\n";
        $output.="\t * Configure::read('Name.key'); will return only the value of Configure::Name[key]\n";
        $output.="\t */\n\n";
        foreach($mymeeting as $mid=>$mdata){
            $output.="\tConfigure::write('$mid','$mdata');\n";
        }
        $output.="?>\n";
        $dfile=APP_PATH . 'config' . DS . 'mymeeting.php';
        $this->out($dfile);
        $mt=fopen($dfile,'w');
        fwrite($mt,$output);
        fclose($mt);
        
        $this->out(__('Agency details set',true));
    }

    function systemsettings(){
        $this->out('');
        $this->out(__('Fixing permission...',true));
        define('UPLOAD_PATH',APP_PATH . 'webroot' . DS . 'upload');
        if(!is_dir(UPLOAD_PATH)){
            mkdir(UPLOAD_PATH);
        }
        chmod(UPLOAD_PATH,0777) ? $this->out(UPLOAD_PATH.' '.__('..yes',true)) : $this->out(UPLOAD_PATH.' '.__('..no',true));
        
        define('LOGO_PATH',APP_PATH . 'webroot' . DS . 'img' . DS . 'logo');
        if(!is_dir(LOGO_PATH)){
            mkdir(LOGO_PATH);
        }
        chmod(LOGO_PATH,0777)? $this->out(LOGO_PATH.' '.__('..yes',true)) : $this->out(LOGO_PATH.' '.__('..no',true));
        
        define('TMP_PATH',APP_PATH . 'tmp');
        if(!is_dir(TMP_PATH)){
            mkdir(TMP_PATH);
        }
        chmod(TMP_PATH,0777)? $this->out(TMP_PATH.' '.__('..yes',true)) : $this->out(TMP_PATH.' '.__('..no',true));
        
        define('CAKESESSION_PATH',TMP_PATH . DS . 'sessions');
        if(!is_dir(CAKESESSION_PATH)){
            mkdir(CAKESESSION_PATH);
        }
        chmod(CAKESESSION_PATH,0777)? $this->out(CAKESESSION_PATH.' '.__('..yes',true)) : $this->out(CAKESESSION_PATH.' '.__('..no',true));
        
        define('LOG_PATH',TMP_PATH . DS . 'logs');
        if(!is_dir(LOG_PATH)){
            mkdir(LOG_PATH);
        }
        chmod(LOG_PATH,0777)? $this->out(LOG_PATH.' '.__('..yes',true)) : $this->out(LOG_PATH.' '.__('..no',true));
        
        define('CACHE_PATH',TMP_PATH . DS . 'cache');
        if(!is_dir(CACHE_PATH)){
            mkdir(CACHE_PATH);
        }
        chmod(CACHE_PATH,0777)? $this->out(CACHE_PATH.' '.__('..yes',true)) : $this->out(CACHE_PATH.' '.__('..no',true));
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
