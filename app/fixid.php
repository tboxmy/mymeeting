<?php
$conn=mysql_connect('localhost','root');
mysql_select_db('mymeeting2008');

mysql_query("CREATE TABLE `logs` ( `id` int(11) NOT NULL auto_increment, `targetid` int(11) NOT NULL, `user_id` int(11) NOT NULL, `controller` varchar(50) NOT NULL, `action` varchar(50) NOT NULL, `url` varchar(255) NOT NULL, `timestamp` datetime NOT NULL, PRIMARY KEY  (`id`))");

mysql_query("RENAME TABLE `committees_users`  TO `memberships`");

mysql_query("RENAME TABLE `meetings_users` TO `attendances`");

mysql_query("ALTER TABLE `decisions` ADD `committee_id` INT NOT NULL AFTER `id`");

mysql_query("ALTER TABLE `groupstatuses` ADD `committee_id` INT NOT NULL AFTER `id`");

mysql_query("ALTER TABLE `userstatuses` ADD `committee_id` INT NOT NULL AFTER `id`");

mysql_query("ALTER TABLE `committees` ADD `minute_template` TEXT NOT NULL AFTER `short_name`");

$datas=mysql_query("select * from meetings");
while($drow=mysql_fetch_assoc($datas)){
    echo("select * from decisions where meeting_id=".$drow['id']);
    echo "<br/>";
    $decisions=mysql_query("select * from decisions where meeting_id=".$drow['id']);
    while($cdecision=mysql_fetch_assoc($decisions)){
        echo("update decisions set committee_id=".$drow['committee_id']." where id=".$cdecision['id']);
        echo "<br/>";
        echo("update groupstatuses set committee_id=".$drow['committee_id']." where decision_id=".$cdecision['id']);
        echo "<br/>";
        echo("update userstatuses set committee_id=".$drow['committee_id']." where decision_id=".$cdecision['id']);
        echo "<br/>";
        mysql_query("update decisions set committee_id=".$drow['committee_id']." where id=".$cdecision['id']);
        mysql_query("update groupstatuses set committee_id=".$drow['committee_id']." where decision_id=".$cdecision['id']);
        mysql_query("update userstatuses set committee_id=".$drow['committee_id']." where decision_id=".$cdecision['id']);
    }
}
echo("update wfmodels set `create`='role:admin,owner' where model='Userstatus'");
mysql_query("update wfmodels set `create`='role:admin,owner' where model='Userstatus'");
$datas=mysql_query("select * from committees");
$query="insert into wfmodels (`model`,`committee_id`,`create`,`view`,`edit`,`delete`) values ";
while($drow=mysql_fetch_assoc($datas)){
    $dlquery[]="('Committee',".$drow['id'].",'role:admin','role:admin','role:admin','role:admin')";
    $dlquery[]="('Membership',".$drow['id'].",'role:admin','role:admin','role:admin','role:admin')";
}
$query.=implode(',',$dlquery);
echo $query;
mysql_query($query);
mysql_close($conn);
?>
