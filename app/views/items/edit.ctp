<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
?>
<div class="items form">
<h2>
<?php echo __('Edit',true).' '.$item_name;?>
</h2>

<fieldset>
<legend><?php echo __('Edit',true).' '.$item_name;?></legend>
    <div class="fieldset-inside">
    <p class="note"><?php __('Short name must be unique within this committee.')?></p>
    <?php echo $form->create('Item',array('url'=>array('action'=>'edit','controller'=>'items','committee'=>$dcommittee['Committee']['short_name']))); ?>
    <?php
    echo $form->input('id');
    echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
    echo $form->input('name', array('error'=>__('This field cannot be left blank',true),'size'=>'30'));
    echo $form->input('short_name', array('error'=>array(
            'required'=>__('This field cannot be left blank',true),
            'alphaNumeric'=>__('Alphabets and numbers only',true),
            'unique'=>__('This name already taken in this committee',true)
        )));
    echo $form->input('description');
    ?>
    </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

