<div class="meetingUsers index">
	<?php echo $html->link(__("New MeetingUser",true),array("controller"=>"meetingUsers","action"=>"add")); ?>
<h2><?php __('MeetingUsers');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('meeting_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('attended');?></th>
	<th><?php echo $paginator->sort('excuse');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($meetingUsers as $meetingUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $meetingUser['MeetingUser']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($meetingUser['Meeting']['id'], array('controller'=> 'meetings', 'action'=>'view', $meetingUser['Meeting']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($meetingUser['User']['name'], array('controller'=> 'users', 'action'=>'view', $meetingUser['User']['id'])); ?>
		</td>
		<td>
			<?php echo $meetingUser['MeetingUser']['attended']; ?>
		</td>
		<td>
			<?php echo $meetingUser['MeetingUser']['excuse']; ?>
		</td>
		<td>
			<?php echo $meetingUser['MeetingUser']['created']; ?>
		</td>
		<td>
			<?php echo $meetingUser['MeetingUser']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $meetingUser['MeetingUser']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $meetingUser['MeetingUser']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $meetingUser['MeetingUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $meetingUser['MeetingUser']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
