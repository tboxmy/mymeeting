<div class="workflows form">
<?php echo $form->create('Workflow');?>
	<fieldset>
 		<legend><?php __('Add Workflow');?></legend>
	<?php
		echo $form->input('committee_id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

