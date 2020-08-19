<div class="meetings form">
<?php echo $this->element('tinymce',array('preset'=>'basic')); ?>
<h2><?php __('Edit Emails'); ?></h2>
<?php echo $form->create('Template',array('url'=>array('action'=>'previewemails','controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name'],'id'=>$meeting['Meeting']['id']))); ?>
<fieldset>
    <legend><?php __('Edit Emails'); ?></legend>
<?php

echo "<h2>".__('Invitation',true)."</h2>";
echo $form->textarea('invite',array('rows'=>15,'value'=>$invite['Template']['template']));
echo "<h2>".__('Change',true)."</h2>";
echo $form->textarea('change',array('rows'=>15,'value'=>$change['Template']['template']));
echo "<h2>".__('Uninvite',true)."</h2>";
echo $form->textarea('uninvite',array('rows'=>15,'value'=>$uninvite['Template']['template']));
echo $datePicker->picker('invite_date',array('value'=>$meeting['Meeting']['invite_date']));
echo $form->hidden('Meeting.id',array('value'=>$meeting['Meeting']['id']));
?>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
