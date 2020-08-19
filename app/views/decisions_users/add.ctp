<div class="decisionsUsers form">
<?php echo $form->create('DecisionsUser');?>
	<fieldset>
 		<legend><?php __('Add DecisionsUser');?></legend>
	<?php
		echo $form->input('decision_id');
		echo $form->input('user_id');
	?>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

