<div class="todos form">
<h2><?php __('Add System-wide To-do')?></h2>
<?php echo $form->create('Systemtodo');?>
    <fieldset>
        <legend><?php __('Add System-wide To-do');?></legend>
        <div class="fieldset-inside">
<?php

        echo $form->input('name',array('error'=>__('This field cannot be left blank',true)));
        echo $form->input('priority');
?>
        </div>
    </fieldset>
    <br />
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

