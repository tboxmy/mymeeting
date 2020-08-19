<div class="templates form">
<?php echo $this->element('tinymce',array('preset'=>'basic')); ?>
<h2><?php __('Edit System-wide Message');?></h2>

<?php 
if(isset($dcommittee)){
    echo $form->create('Template',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));
}
else{
    echo $form->create('Template');
}
?>
    <fieldset>
        <legend><?php __('Edit System-wide Message');?></legend>
        <div class="fieldset-inside">
        <div>
        <span class="note"><?php __('Editing this message will not affect messages that has been created in committee and meeting level.')?></span>
<?php
echo $form->input('id');
echo $form->input('title');
echo $form->input('description',array('type'=>'textarea','cols'=>'6','rows'=>'5'));
echo $form->input('template',array('type'=>'textarea','cols'=>'6','rows'=>'20'));
?>
        </div>
        </div>
    </fieldset>
    <br/>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

