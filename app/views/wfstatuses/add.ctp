<div class="wfstatuses form">
<?php echo $form->create('Wfstatus');?>
	<fieldset>
 		<legend><?php __('Add Wfstatus');?></legend>
	<?php
		echo $form->input('model');
		echo $form->input('foreign_key');
		echo $form->input('workflow_id');
		echo $form->input('level');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
