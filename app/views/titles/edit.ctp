<div class="titles form">
<h2><?php __('Title')?></h2>
<?php echo $form->create('Title');?>
    <fieldset>
        <legend><?php __('Edit Title');?></legend>
        <div class="fieldset-inside">
    <?php
        echo $form->input('id');
        echo $form->input('short_name');
        echo $form->input('long_name');
        
    ?>
        </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

