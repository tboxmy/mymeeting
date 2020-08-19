<div class="groupStatuses form">
<?php echo $form->create('GroupStatus');?>
	<fieldset>
 		<legend><?php __('Edit GroupStatus');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('decision_id');
		echo $form->input('user_id');
		echo $form->input('group_id');
		echo $form->input('description');
		echo $form->input('action_date');
		echo $form->input('deleted');
		echo $form->input('deleted_date');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('GroupStatus.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('GroupStatus.id'))); ?></li>
		<li><?php echo $html->link(__('List GroupStatuses', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Decisions', true), array('controller'=> 'decisions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Decision', true), array('controller'=> 'decisions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Groups', true), array('controller'=> 'groups', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Group', true), array('controller'=> 'groups', 'action'=>'add')); ?> </li>
	</ul>
</div>
