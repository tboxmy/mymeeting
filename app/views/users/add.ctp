<div class="users form">

<h2><?php __('Add User')?></h2>
<?php echo $form->create('User');?>
<fieldset>
    <legend><?php __('Add User');?></legend>
    <div class="fieldset-inside">
    <?php
    echo $form->input('username',array('class'=>'required'));
    echo $form->input('password',array('class'=>'required'));
    echo $form->input('superuser');     
    echo $form->input('title_id');
    echo $form->input('name', array('size'=>'40','class'=>'required'));
    echo $form->input('job_title',array('maxlength'=>'225','size'=>'40', 'label'=>__('Post',true)));
    echo $form->input('bahagian', array('size'=>'40','label'=>__('Section/Division',true)));
    echo $form->input('grade');
    echo $form->input('email', array('size'=>'30'));
    echo $form->input('address', array('rows'=>'4','cols'=>'6'));
    echo $form->input('telephone');
    echo $form->input('fax');
    echo $form->input('mobile');
    echo $form->input('Committee',array('multiple'=>'checkbox'));
    ?>
    </div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
