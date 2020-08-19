<div id="personallinks">
<ul>
<li><?php echo $html->link($auth_user['User']['name'],array('controller'=>'users','action'=>'profile'))?> | </li>
<li><?php echo $html->link(__('My Committees',true),array('controller'=>'committees','action'=>'mainpage'))?> | </li>
<li><?php echo $html->link(__('Calendar',true),array('controller'=>'committees','action'=>'calendar'))?> | </li>
<li><?php echo $html->link(__('Logout',true),array('controller'=>'users','action'=>'logout'))?></li>
</ul>
</div>
