

<div class="announcements form">
<h2><?php __('Announcements')?></h2>

<?php echo $form->create('Announcement',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit')));?>
<?php echo $this->renderElement('tinymce',array('preset' => 'basic')); ?> 
    <fieldset>
        <legend><?php __('Edit Announcement');?></legend>
    <?php
        echo $form->input('id');            
    echo $form->input('description');   
        
    ?>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

