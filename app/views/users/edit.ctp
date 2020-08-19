<div class="users form">

<h2><?php __('Edit Profile');?></h2>

<?php echo $form->create('User');?>
<fieldset>
<legend><?php __('Edit User');?></legend>
    <div class="fieldset-inside">
    <?php

    echo $form->input('id');
    echo $form->input('username',array('readonly'=>'readonly'));
    echo $form->input('superuser');        
    echo $form->input('title_id').$form->input('name', array('size'=>'40','class'=>'required'));
    echo $form->input('job_title', array('size'=>'40', 'label'=>__('Post',true)));
    echo $form->input('bahagian', array('size'=>'40','label'=>__('Section/Division',true)));
    echo $form->input('grade');
    echo $form->input('email', array('size'=>'30'));
    echo $form->input('address', array('rows'=>'4','cols'=>'6'));
    echo $form->input('telephone');
    echo $form->input('fax', array('error'=>array(
        'format'=>__('Please supply valid fax number eg: 03-6667777',true),
        )));
    echo $form->input('mobile');
    echo $form->input('Committee',array('multiple'=>'checkbox'));
    ?>
    </div>
</fieldset>
<br />
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
