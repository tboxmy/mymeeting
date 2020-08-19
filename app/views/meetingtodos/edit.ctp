<div class="meetingtodos form">

<h2><?php __("Meeting's To-do")?></h2>
	<fieldset>
 		<legend><?php __('Edit Meetingtodo');?></legend>
 		<div class="fieldset-inside">
<?php echo $form->create('Meetingtodo',array('url'=>array('committee'=>$this->params['committee'],'action'=>'edit')));?>
	<?php
        if(isset($returnpage)) echo $form->hidden('returnpage',array('value'=>$returnpage));
		echo $form->input('id');
		echo $form->input('name',array('size'=>'30','class'=>'required'));
		echo $form->input('priority');
		echo $form->input('user_id');
	?>
	    </div>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

