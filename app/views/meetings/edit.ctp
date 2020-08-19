<?php
if(!$session->check('CurCommittee')){
    if(isset($javascript)):
        // load script in <head> section
        $javascript->link('scriptaculous/lib/prototype', false);
endif;
}
?>
<div class="meetings form">
<h2><?php echo __('Edit Meeting').': '.$data['Meeting']['meeting_num'];?></h2>
<?php echo $form->create('Meeting',array('type'=>'file','url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
    <fieldset>
        <legend><?php __('Edit Meeting');?></legend>
        <div class="fieldset-inset">
<?php
echo $form->input('id');
echo $form->input('committee_id', array('type'=>'hidden','value'=>$dcommittee['Committee']['id']));
echo $form->hidden('parent_id');
echo $form->input('meeting_title');
echo $form->input('meeting_num');
echo $datePicker->picker('meeting_date',array('showstime'=>true,'class'=>'required','error'=>__('This field cannot be left blank',true)));
echo $html->div('input required',$form->label('Venue').$ajax->autoComplete('venue','getvenue'));
echo $form->input('allow_representative',array('label'=>__('Allow representatives',true)));
echo $form->input('agenda');
echo $multiFile->input('agenda',array('label'=>__('Agenda Files',true)));
echo $multiFile->input('minutes',array('label'=>__('Minutes Files',true)));
echo $multiFile->input('presentations',array('label'=>__('Presentation Files',true)));
?>
        <fieldset>
        <legend><?php __('Select Members');?></legend>
<div id="userlist">
    <?php //echo $this->requestAction(array('controller'=>'Ajaxes','action'=>'userlist','committee'=>$dcommittee['Committee']['short_name']),array($this->data));  ?>
    <?php echo $this->element('userlist',array('users'=>$users,'groups'=>$groups,'from'=>'meetings/edit'));  ?>
        </fieldset>
        </div>
</div>

    </fieldset>

    <br />
   <?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
