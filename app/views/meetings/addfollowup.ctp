<div class="meetings form">
<h2><?php __('Add Follow-Up Meeting');?></h2>
<?php echo $form->create('Meeting',array('url'=>array('action'=>'addfollowup','controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name'],'meetingid'=>$meetingid['Meeting']['id']),'type'=>'file')); ?>
<fieldset>
    <legend><?php __('Add Meeting');?></legend>
<?php
echo $form->input('committee_id', array('type'=>'hidden','value'=>$dcommittee['Committee']['id']));
echo $form->input('parent_id', array('type'=>'hidden', 'value'=>$meetingid['Meeting']['id']));
echo $form->input('meeting_title');
echo $form->input('meeting_num');
echo $datePicker->picker('meeting_date',array('showstime'=>true));
echo $html->div('input',$form->label('Venue').$ajax->autoComplete('venue','getvenue'));
echo $datePicker->picker('deadline',array('showstime'=>false));
if ($session->read('Global.send_email') == 'Y') {
    echo $form->input('sendnow', array('type'=>'checkbox', 'label'=>'Send invite now OR set a date for automatic email sending below:'));
    echo $datePicker->picker('invite_date',array('showstime'=>false));
} 
echo $multiFile->input('agenda');
echo $multiFile->input('minutes');
?>

</fieldset>

<div id="userlist">
    
    <?php echo $this->element('userlist',array('users'=>$users,'groups'=>$groups));  ?>
</div>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
