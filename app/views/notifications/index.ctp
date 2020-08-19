<div class="notifications index">
<h2><?php __('Notifications');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('meeting_id');?></th>
	<th><?php echo $paginator->sort('notification');?></th>
	<th><?php echo $paginator->sort('notification_date');?></th>
	<th><?php echo $paginator->sort('notification_sent');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($notifications as $notification):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $notification['Notification']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($notification['Meeting']['id'], array('controller'=> 'meetings', 'action'=>'view', $notification['Meeting']['id'])); ?>
		</td>
		<td>
			<?php echo $notification['Notification']['notification']; ?>
		</td>
		<td>
			<?php echo $notification['Notification']['notification_date']; ?>
		</td>
		<td>
			<?php echo $notification['Notification']['notification_sent']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $notification['Notification']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $notification['Notification']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $notification['Notification']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $notification['Notification']['id'])); ?>
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

