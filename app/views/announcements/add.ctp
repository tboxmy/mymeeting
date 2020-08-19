


<div class="announcements form">
<h2><?php __('Announcements')?></h2>
<?php echo $this->renderElement('tinymce',array('preset' => 'basic')); ?> 
<?php echo $form->create('Announcement',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')));?>
    <fieldset>
        <legend><?php __('Add Announcement');?></legend>
        <div class="fieldset-inside">
    <?php
        echo $form->input('description');
    ?>
        </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
