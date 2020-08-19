<div class="meetings form">
<h2><?php __('Add Meeting');?></h2>
<?php echo $form->create('Meeting',array('url'=>array('action'=>'add','controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name']),'type'=>'file')); ?>
<fieldset>
    <legend><?php __('Add Meeting');?></legend>
    <div class="fieldset-inside">
<?php
echo $form->input('committee_id', array('type'=>'hidden','value'=>$dcommittee['Committee']['id']));
echo $form->input('meeting_title',array('error'=>__('This field cannot be left blank',true), 'size'=>'40','value'=>$defaulttitle));
echo $form->input('meeting_num',array('value'=>$nextnum));
echo $datePicker->picker('meeting_date',array('showstime'=>true,'class'=>'required','error'=>__('This field cannot be left blank',true)));
echo $html->div('input required',$form->label('Venue').$ajax->autoComplete('venue','getvenue'));
echo $form->input('allow_representative',array('label'=>__('Allow representatives',true)));
echo $multiFile->input('agenda',array('label'=>__('Agenda Files',true)));
echo $multiFile->input('minutes',array('label'=>__('Minutes Files',true)));
echo $multiFile->input('presentations',array('label'=>__('Presentation Files',true)));
?>
<div id="userlist">
    <?php echo $this->element('userlist',array('users'=>$users,'groups'=>$groups));  ?>
</div>
</div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
