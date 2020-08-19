
<div class="settings form">
<h2><?php __('Change logo');?></h2>
<?php echo $form->create('Settings', array('action'=>'logo','type'=>'file'));?>
    <fieldset>
        <legend><?php __('Change logo');?></legend>
         <div class="fieldset-inside">
        <?php
        
        echo $form->label(__('Current logo', true)) . '<br />';
        echo $html->image($img_path);
        echo $html->div('', $form->input('Image.upload_logo', array('type'=>'file','label'=>__('Logo to upload',true))));
        
        __('Suitable logo size to upload is 155x80 px');
        ?>  
        
        </div>
    </fieldset>
    <br/>
<?php echo $form->button(__('Submit',true), array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel',true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
