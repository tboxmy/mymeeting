<div class="meetingsUsers index">
<h2><?php __('MeetingsUsers');?></h2>
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
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('attended');?></th>
	<th><?php echo $paginator->sort('excuse');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($meetingsUsers as $meetingsUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $meetingsUser['MeetingsUser']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($meetingsUser['Meeting']['id'], array('controller'=> 'meetings', 'action'=>'view', $meetingsUser['Meeting']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($meetingsUser['User']['name'], array('controller'=> 'users', 'action'=>'view', $meetingsUser['User']['id'])); ?>
		</td>
		<td>
			<?php echo $meetingsUser['MeetingsUser']['attended']; ?>
		</td>
		<td>
			<?php echo $meetingsUser['MeetingsUser']['excuse']; ?>
		</td>
		<td>
			<?php echo $meetingsUser['MeetingsUser']['created']; ?>
		</td>
		<td>
			<?php echo $meetingsUser['MeetingsUser']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $meetingsUser['MeetingsUser']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $meetingsUser['MeetingsUser']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $meetingsUser['MeetingsUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $meetingsUser['MeetingsUser']['id'])); ?>
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

