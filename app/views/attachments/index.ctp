
<h2><?php __('Files Archive') ?></h2>

<?php if(isset($meetingfiles)):?>
<h4><?php __('Meeting Files');?></h4>
<table cellpadding='0' cellspacing='0'>
<tr><th width='2%'>Bil.</th><th><?php __('Meeting');?></th><th><?php __('Meeting Date');?></th><th><?php __('File');?></th><th><?php __('Updated');?></th></tr>
<?php
if (!count($meetingfiles)) {
    echo "<tr><td colspan='5'>".__('No record found',true)."</td></tr>";
}
$i=1;
    foreach($meetingfiles as $meetingfile){
?>
<tr>
<td><?php echo $i++.'. ';?></td>
<td><?php echo $html->link($meetingfile['Meeting']['meeting_title'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view','id'=>$meetingfile['Meeting']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($meetingfile['Meeting']['meeting_date']));?></td>
<td><?php echo $html->link($meetingfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'attachment','id'=>$meetingfile['Attachment']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($meetingfile['Attachment']['modified']));?></td>
</tr>
<?php
    }
?>
</table>
<?php endif; ?>

<?php if(isset($decisionfiles)):?>
<h4><?php __('Decision Files');?></h4>
<table cellpadding='0' cellspacing='0'>
<tr><th width='2%'>Bil.</th><th><?php __('Decision');?></th><th><?php __('Decision Date');?></th><th><?php __('File');?></th><th><?php __('Updated');?></th></tr>
<?php
$i=1;
    foreach($decisionfiles as $decisionfile){
?>
<tr>
<td><?php echo $i++.'. ';?></td>
<td><?php echo $html->link($text->truncate(strip_tags($decisionfile['Decision']['description']),100),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'view','id'=>$decisionfile['Decision']['id']),null,null,false);?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($decisionfile['Decision']['updated']));?></td>
<td><?php echo $html->link($decisionfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'attachment','id'=>$decisionfile['Attachment']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($decisionfile['Attachment']['modified']));?></td>
</tr>
<?php
    }
?>
</table>
<?php endif; ?>

<?php if(isset($userstatusfiles)):?>
<h4><?php __('User Status Files');?></h4>
<table cellpadding='0' cellspacing='0'>
<tr><th width='2%'>Bil.</th><th><?php __('Status');?></th><th><?php __('Status Date');?></th><th><?php __('File');?></th><th><?php __('Updated');?></th></tr>
<?php
$i=1;
    foreach($userstatusfiles as $userstatusfile){
?>
<tr>
<td><?php echo $i++.'. ';?></td>
<td><?php echo $html->link($text->truncate($userstatusfile['Userstatus']['description'],100),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'view','id'=>$userstatusfile['Userstatus']['decision_id'].'#user'.$userstatusfile['Userstatus']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($userstatusfile['Userstatus']['action_date']));?></td>
<td><?php echo $html->link($userstatusfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'userstatuses','action'=>'attachment','id'=>$userstatusfile['Attachment']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($userstatusfile['Attachment']['modified']));?></td>
</tr>
<?php
    }
?>
</table>
<?php endif; ?>

<?php if(isset($groupstatusfiles)):?>
<h4><?php __('Group Status Files');?></h4>
<table cellpadding='0' cellspacing='0'>
<tr><th width='2%'>Bil.</th><th><?php __('Status');?></th><th><?php __('Status Date');?></th><th><?php __('File');?></th><th><?php __('Updated');?></th></tr>
<?php
$i=1;
    foreach($groupstatusfiles as $groupstatusfile){
?>
<tr>
<td><?php echo $i++.'. ';?></td>
<td><?php echo $html->link($text->truncate($groupstatusfile['Groupstatus']['description'],100),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'view','id'=>$groupstatusfile['Groupstatus']['decision_id'].'#group'.$groupstatusfile['Groupstatus']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($groupstatusfile['Groupstatus']['action_date']));?></td>
<td><?php echo $html->link($groupstatusfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'groupstatuses','action'=>'attachment','id'=>$groupstatusfile['Attachment']['id']));?></td>
<td><?php echo date(Configure::read('date_format'),strtotime($groupstatusfile['Attachment']['modified']));?></td>
</tr>
<?php
    }
?>
</table>
<?php endif; ?>
