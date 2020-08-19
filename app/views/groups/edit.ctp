<div class="groups form">
<h2><?php __('Groups')?></h2>
<?php echo $form->create('Group',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit')));?>
    <fieldset>
        <legend><?php __('Edit Group');?></legend>
        <div class="fieldset-inside">
    <?php
        echo $form->input('id');
        echo $form->input('name');
        echo $form->input('User',array('multiple'=>'checkbox'));
    ?>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

