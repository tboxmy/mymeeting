<div class="roles view">
<h2><?php  __('Role');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Role', true), array('action'=>'edit', $role['Role']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Role', true), array('action'=>'delete', $role['Role']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $role['Role']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Roles', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Role', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Committees Users', true), array('controller'=> 'committees_users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Committees User', true), array('controller'=> 'committees_users', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Committees Users');?></h3>
	<?php if (!empty($role['CommitteesUser'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Committee Id'); ?></th>
		<th><?php __('Role Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($role['CommitteesUser'] as $committeesUser):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $committeesUser['id'];?></td>
			<td><?php echo $committeesUser['user_id'];?></td>
			<td><?php echo $committeesUser['committee_id'];?></td>
			<td><?php echo $committeesUser['role_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'committees_users', 'action'=>'view', $committeesUser['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'committees_users', 'action'=>'edit', $committeesUser['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'committees_users', 'action'=>'delete', $committeesUser['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $committeesUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	
</div>
