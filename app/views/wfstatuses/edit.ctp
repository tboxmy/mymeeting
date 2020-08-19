<div class="wfstatuses form">
<?php echo $form->create('Wfstatus');?>
	<fieldset>
 		<legend><?php __('Edit Wfstatus');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('model');
		echo $form->input('foreign_key');
		echo $form->input('workflow_id');
		echo $form->input('level');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
