<div class="users form">
<p class='contentmenu'>[<?php echo $html->link(__('Change Password', true),array('controller'=>'users','action'=>'changepassword'))?>]</p>
<h2><?php __('Edit Profile');?>: <?php echo $data['User']['username']?></h2>


<?php echo $form->create('User',array('url'=>array('action'=>'profile')));?>
<fieldset>
<legend><?php __('Edit Profile');?></legend>
<div class="fieldset-inside">
<span class="note"><?php __('Changes here will take effect after you login next time.')?></span>
<?php
    echo $form->input('id');      
    echo $form->input('title_id').$form->input('name', array('size'=>'40','class'=>'required'));
    echo $form->input('job_title', array('size'=>'40', 'label'=>__('Post',true)));
    echo $form->input('bahagian', array('size'=>'40','label'=>__('Section/Division',true)));
    echo $form->input('grade');
    echo $form->input('email', array('size'=>'30','error'=>array(
        'email'=>__('Invalid email format',true)
        )));
    echo $form->input('address', array('rows'=>'4','cols'=>'6'));
    echo $form->input('telephone');
    echo $form->input('fax', array('error'=>array(
        'format'=>__('Please supply valid fax number eg: 03-6667777',true),
        )));
    echo $form->input('mobile', array('error'=>array(
        'rule'=>__('Please supply valid mobile number eg: 013-1234521312',true),
        )));
?>
</div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
