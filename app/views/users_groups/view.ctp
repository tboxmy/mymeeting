<div class="usersGroups view">
<h2><?php  __('UsersGroup');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $usersGroup['UsersGroup']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($usersGroup['User']['name'], array('controller'=> 'users', 'action'=>'view', $usersGroup['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($usersGroup['Group']['name'], array('controller'=> 'groups', 'action'=>'view', $usersGroup['Group']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit UsersGroup', true), array('action'=>'edit', $usersGroup['UsersGroup']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete UsersGroup', true), array('action'=>'delete', $usersGroup['UsersGroup']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $usersGroup['UsersGroup']['id'])); ?> </li>
		<li><?php echo $html->link(__('List UsersGroups', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New UsersGroup', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
