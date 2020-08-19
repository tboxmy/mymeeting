<div class="groupStatuses index">
<h2><?php __('GroupStatuses');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('decision_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('group_id');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('action_date');?></th>
	<th><?php echo $paginator->sort('deleted');?></th>
	<th><?php echo $paginator->sort('deleted_date');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('updated');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($groupStatuses as $groupStatus):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $groupStatus['GroupStatus']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($groupStatus['Decision']['id'], array('controller'=> 'decisions', 'action'=>'view', $groupStatus['Decision']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($groupStatus['User']['name'], array('controller'=> 'users', 'action'=>'view', $groupStatus['User']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($groupStatus['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $groupStatus['Group']['id'])); ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['description']; ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['action_date']; ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['deleted']; ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['deleted_date']; ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['created']; ?>
		</td>
		<td>
			<?php echo $groupStatus['GroupStatus']['updated']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $groupStatus['GroupStatus']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $groupStatus['GroupStatus']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $groupStatus['GroupStatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $groupStatus['GroupStatus']['id'])); ?>
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
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New GroupStatus', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Decisions', true), array('controller'=> 'decisions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Decision', true), array('controller'=> 'decisions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
