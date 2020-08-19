<div class="meetings index">
<?php if(isset($allow_add_meeting)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new Meeting",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]
</p>
<?php endif; ?>
<h2><?php __('Meetings');?></h2>
<?php
?>
<table cellpadding="0" cellspacing="0">
<tr>
<th><?php __('No')?></th>
<th><?php echo $paginator->sort('meeting_title',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
<th><?php echo $paginator->sort('meeting_num',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
<th><?php echo $paginator->sort('meeting_date',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
<th><?php echo $paginator->sort('venue',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
<th class="actions" colspan='8'><?php __('Actions');?></th>
</tr>

<?php if (!count($meetings)) : ?>
<tr>
<td colspan="14">No record found</td>
</tr>
<?php endif; ?>

<?php
$i = 0;
foreach ($meetings as $meeting):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<tr<?php echo $class;?>>
<td>
<?php echo $i.'.';?>
</td>
<td>
<?php echo $meeting['Meeting']['meeting_title']?>
</td>
<td>
<?php 
if($auth_user['User']['superuser']||(isset($meeting['auth']['view']) && $meeting['auth']['view'])){
	echo $html->link($meeting['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$meeting['Meeting']['id']),null,null,false);
}
else{
	echo $meeting['Meeting']['meeting_num'];
}
?>
</td>
<td>
<?php echo date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>&nbsp;
<?php echo date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>
</td>
<td>
<?php echo $meeting['Meeting']['venue']; ?>
</td>
<td class="actions">
<?
$displayed = 0;
foreach ($meeting['Notification'] as $notification) {
	if ($notification['notification_sent'] && $notification['type'] == 'invite') {
		$displayed = 1;
		break;
	}
}
echo $displayed ? 'Invited': '-' ?>
</td>
<?php if(isset($can_view_todo) && $can_view_todo) {
	echo '<td class="actions">'.$html->link(__('Todo', true), array('committee'=>$committee,'controller'=>'meetingtodos','action'=>'index', $meeting['Meeting']['id'])).'</td>';
}
?>
<?php if(isset($can_view_attendance) && $can_view_attendance) {
	echo '<td class="actions">'.$html->link(__('Attendance', true), array('committee'=>$committee,'action'=>'attendance', $meeting['Meeting']['id'])).'</td>';
}
?>
<td class="actions">
<?php echo $html->link(__('Summary', true), array('committee'=>$committee,'action'=>'summary',$meeting['Meeting']['id']), array('target'=>'_blank')); ?>
</td>
<td class="actions">
<?php echo $html->link(__('Minutes', true), array('committee'=>$committee,'action'=>'minutes',$meeting['Meeting']['id']), array('target'=>'_blank')); ?>
</td>
<?php 
echo $this->element('crud',array('crudid'=>$meeting['Meeting']['id'],'permission'=>$meeting['auth']));
?>
</tr>
<?php endforeach; ?>

</table>
</div>

<div class="paging">
<?php echo $paginator->prev('<< '.__('previous', true), array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
|     <?php echo $paginator->numbers(array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
<?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
</div>
