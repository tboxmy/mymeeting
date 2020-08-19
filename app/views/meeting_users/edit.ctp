<div class="meetingUsers form">
<?php echo $form->create('MeetingUser');?>
	<fieldset>
 		<legend><?php __('Edit MeetingUser');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('meeting_id');
		echo $form->input('user_id');
		echo $form->input('attended');
		echo $form->input('excuse');
	?>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
