<div class="users forgotpass">

<h2><?php __('Forgot your password?')?></h2>
<?php echo $form->create('User',array('controller'=>'users','action'=>'forgotpass'));?>
<fieldset>
    <legend><?php __('Password reset');?></legend>
    <div class="fieldset-inside">
    <span class="note"><?php __("Please fill in your email address to reset your password")?></span>
    <?php
    echo $form->input('email', array('label'=>__('Email',true),'size'=>'40','maxlength'=>'255'));
    ?>
    </div>
</fieldset>
    <?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
    <?php echo $html->link(__('Cancel',true),array('controller'=>'committees','action'=>'mainpage'),array('class'=>'button'));?>
    <?php echo $form->end();?>
</div>
