<div class="titles form">
<h2><?php __('Add Title')?></h2>
<?php echo $form->create('Title');?>
    <fieldset>
        <legend><?php __('Add Title');?></legend>
        <div class="fieldset-inside">
    <?php
        echo $form->input('short_name',array('error' => array(
        'required' => __('This field cannot be left blank',true),
        'unique' => __('The short name already taken',true)
    )));
        echo $form->input('long_name',array('required'=>__('This field cannot be left blank',true)));

    ?>
        </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

