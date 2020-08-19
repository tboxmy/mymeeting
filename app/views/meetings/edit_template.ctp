<div class="meetings form">
<?php echo $this->element('tinymce',array('preset'=>'basic')); ?>
<h2><?php __('Edit ');
if($template_type=='invite'){
	$title=' '.__('Invitation',true);
	$action='edit_invitation';
}
elseif($template_type=='cancel'){
	$title=' '.__('Cancelation',true);
	$action='edit_cancelation';
}
echo $title;
?></h2>
<?php echo $form->create('Template',array('url'=>array('action'=>$action,'controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name'],'id'=>$meeting['Meeting']['id']))); ?>
<fieldset>
<legend><?php __('Edit '); echo ' '.$title; ?></legend>
<?php
if($template['Template']['model']=='Meeting'){
	echo $form->input('id',array('value'=>$template['Template']['id']));
}
echo $form->textarea('template',array('class'=>'fullview','rows'=>15,'value'=>$template['Template']['template']));
if($template_type!='cancel'){
    echo "<p>&nbsp;</p><span class='instructions'>".__("It is recommended to send the invitations 10 days before the meeting date.",true)."</span>";
	echo $datePicker->picker('invite_date',array('value'=>$meeting['Meeting']['invite_date']));
}
echo $form->hidden('Meeting.id',array('value'=>$meeting['Meeting']['id']));
?>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
