<?php
uses('model'.DS.'connection_manager');

class CreatedbShell extends Shell {
    function main(){
        if(file_exists(CONFIGS . DS . 'database.php')){
            $db =@ConnectionManager::getDataSource('default');
	    if(strlen($db->config['login'])>16){
		    $this->out(__('The username for the database is too long. Has to be less than 16 characters'));
		    exit();
	    }
            $rootpass=$this->in(__('Please enter mysql root password to create database and user'));
            $rootlink=mysql_connect($db->config['host'],'root',$rootpass,true);
            if(mysql_query('create database '.$db->config['database'],$rootlink)){
                $this->out(sprintf(__('Created the %s database',true),$db->config['database']));
                if(mysql_query('grant all on '.$db->config['database'].'.* to '.$db->config['login'].'@'.$db->config['host'].' identified by "'.$db->config['login'].'"',$rootlink)){
                    $this->out(sprintf(__('Granted access to %s database for %s at %s',true),$db->config['database'],$db->config['login'],$db->config['host']));
                    if(mysql_query('update mysql.user set password=password(\''.$db->config['password'].'\') where user=\''.$db->config['login'].'\'',$rootlink)){
                        $this->out(sprintf(__('Updated %s password to %s',true),$db->config['login'],$db->config['password']));
                        mysql_query('flush privileges',$rootlink);
                        mysql_close($rootlink);
                        $this->out(__('Database is set. Please run the installation script again',true));
                    }
                }
            }
        }
        else{
            $this->out(__('The database configuration is not set yet. Please run `cake install` to create it',true));
        }
    }
}
?>
