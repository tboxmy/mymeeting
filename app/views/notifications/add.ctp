<div class="notifications form">
<?php echo $form->create('Notification');?>
	<fieldset>
 		<legend><?php __('Add Notification');?></legend>
	<?php
		echo $form->input('meeting_id');
		echo $form->input('notification');
		echo $form->input('notification_date');
		echo $form->input('notification_sent');
	?>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

