<?php
$find=array('&nbsp;','&ldquo;','&rdquo;','&ndash;','&lsquo;','&rsquo;');
$replace=array('','"','"','-','"','"')
?>
<table cellpadding='0' cellspacing='0'>
<tr>
    <th><?php __('Upcoming meetings');?>
        <?php echo count($upcoming)? ': '.count($upcoming) : '' ?></th>
    <th><?php __('Upcoming deadlines');?>
           <?php echo count($upcomingdeadline)? ': '.count($upcomingdeadline) : '' ?></th>
    <th><?php __('Decisions without any status');?>
           <?php echo count($needupdating)? ': '.count($needupdating) : '' ?></th>

</tr>
<tr>
    <td width=30%>
            
    <?php if (!count($upcoming)) {
    __('No upcoming meeting found');
	}
	?>

    <ul>
    <?php foreach ($upcoming as $upcomings):?>

        <li><span class="viewtitle"><?php __('Meeting Number :')?></span><?php echo $html->link($upcomings['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view', $upcomings['Meeting']['id']));?></li>
        <li><span class="viewtitle"><?php __('Meeting Title :')?></span><?php echo $upcomings['Meeting']['meeting_title']; ?></li>
        <li><span class="viewtitle"><?php __('Meeting Date :')?></span><?php echo date(Configure::read('date_format'),strtotime($upcomings['Meeting']['meeting_date'])); ?></li>
        <li><span class="viewtitle"><?php __('Meeting Venue :')?> </span><?php echo $upcomings['Meeting']['venue']; ?></li></ul>
     
    <hr><br>
    <?php endforeach; ?>
    </ul>
    </td>
    <td width=30%>
    <?php if (!count($upcomingdeadline)){ 
    __('No upcoming deadline found');
	} ?>
    <ul>
    <?php foreach ($upcomingdeadline as $upcomingdeadlines):?>
        <li><span class="viewtitle"><?php __('Project:')?></span><?php echo $html->link($upcomingdeadlines['Item']['name'],array('controller'=>'items','action'=>'view','id'=>$upcomingdeadlines['Item']['id'],'committee'=>$dcommittee['Committee']['short_name'])); ?>
        <li><span class="viewtitle"><?php __('Meeting:')?></span><?php echo $html->link($upcomingdeadlines['Meeting']['meeting_num'],array('controller'=>'meetings','action'=>'view','id'=>$upcomingdeadlines['Meeting']['id'],'committee'=>$dcommittee['Committee']['short_name'])); ?>    </li>
    </li>
        <li><span class="viewtitle"><?php __('Decision:'); echo ($javascript->link("toggle.js")); ?></span>

    <?php echo $html->link(str_replace($find,$replace,strip_tags($text->truncate($upcomingdeadlines['Decision']['description'],150))),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'view', $upcomingdeadlines['Decision']['id'])); ?>
    </li>
        <li><span class="viewtitle"><?php __('Decision deadline :')?></span><?php echo date(Configure::read('date_format'),strtotime($upcomingdeadlines['Decision']['deadline'])); ?></li>
<li>
<?php 
        if(count($upcomingdeadlines['User'])):
?>
<li><span class="viewtitle"><?php __('Individual Implementor');?>: </span><?php echo "<ul>"; foreach($upcomingdeadlines['User'] as $user) echo "<li>".$user['name']."</li>"; echo "</ul>"; ?></li>
<?php
            endif;
?>

</li>

<li>
<?php 
        if(count($upcomingdeadlines['Group'])):
?>
<li><span class="viewtitle"><?php __('Group Implementor');?>: </span><?php echo "<ul>"; foreach($upcomingdeadlines['Group'] as $group) echo "<li>".$group['name']."</li>"; echo "</ul>"; ?></li>
<?php
            endif;
?>

</li>
    <hr>
    <?php endforeach; ?>
    </ul>
    </td>
    <td>
    <?php if (!count($needupdating)){ 
    __('No decision need updating');
    } ?>  

    <ul>
    <?php foreach ($needupdating as $needupdatings):?>
        <li><span class="viewtitle"><?php __('Project:')?></span><?php echo $html->link($needupdatings['Item']['name'],array('controller'=>'items','action'=>'view','id'=>$needupdatings['Item']['id'],'committee'=>$dcommittee['Committee']['short_name'])); ?>    </li>
        <li><span class="viewtitle"><?php __('Meeting:')?></span><?php echo $html->link($needupdatings['Meeting']['meeting_num'],array('controller'=>'meetings','action'=>'view','id'=>$needupdatings['Meeting']['id'],'committee'=>$dcommittee['Committee']['short_name'])); ?>    </li>
        <li><span class="viewtitle"><?php __('Decision:'); echo ($javascript->link("toggle.js")); ?></span>

<?php echo $html->link(str_replace($find,$replace,strip_tags($text->truncate($needupdatings['Decision']['description'],150))),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'view', $needupdatings['Decision']['id'])); ?>
    </li>
        <li><span class="viewtitle"><?php __('Decision deadline :')?></span><?php echo date(Configure::read('date_format'),strtotime($needupdatings['Decision']['deadline'])); ?></li>
<li>
<?php 
        if(count($needupdatings['User'])):
?>
<li><span class="viewtitle"><?php __('Individual Implementor');?>: </span><?php echo "<ul>"; 
foreach($needupdatings['User'] as $curuser){
echo "<li>".$curuser['name']."</li>"; 
}
echo "</ul>"; ?></li>
<?php
            endif;
?>

</li>

<li>
<?php 
        if(count($needupdatings['Group'])):
?>
<li><span class="viewtitle"><?php __('Group Implementor');?>: </span><?php echo "<ul>"; 
foreach($needupdatings['Group'] as $curgroup){
echo "<li>".$curgroup['name']."</li>"; 
}
echo "</ul>"; ?></li>
<?php
            endif;
?>

</li>
    <hr>
    <?php endforeach; ?>
    </ul>
    </td>
</tr></table>
