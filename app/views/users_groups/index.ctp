<div class="usersGroups index">
<h2><?php __('UsersGroups');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('group_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($usersGroups as $usersGroup):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $usersGroup['UsersGroup']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($usersGroup['User']['name'], array('controller'=> 'users', 'action'=>'view', $usersGroup['User']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($usersGroup['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $usersGroup['Group']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $usersGroup['UsersGroup']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $usersGroup['UsersGroup']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $usersGroup['UsersGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usersGroup['UsersGroup']['id'])); ?>
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
		<li><?php echo $html->link(__('New UsersGroup', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
