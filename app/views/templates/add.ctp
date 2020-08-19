<div class="templates form">

<h2><?php __('Add Template');?></h2>

<?php echo $form->create('Template');?>
    <fieldset>
        <legend><?php __('Add Template');?></legend>
    <?php
        echo $form->input('title');
        echo $form->input('help');
        echo $form->input('template');
    ?>

    <p>&nbsp;</p><br>
    Note: these will be replaced when email is sent out.<br>
    %recepient% - name of the recepient<br>
    %email% - email of the recepient<br>
    %date% - date of the meeting<br>
    %time% - time of the meeting <br>
    %venue% - venue of the meeting<br>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

