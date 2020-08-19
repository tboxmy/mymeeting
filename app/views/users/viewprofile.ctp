<?php echo $form->create(array('action'=>"viewprofile"));?>
<fieldset>
 	<legend><?php __('Edit Profile');?></legend>
<?php   echo $form->input('username');
	echo $form->input('password');
 	echo $form->input('name');
	echo $form->input('job_title');
	echo $form->input('email');
	echo $form->input('telephone');
	echo $form->input('mobile');
	echo $form->input('fax');
	echo $form->input('address');?>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>


