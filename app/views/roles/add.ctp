<?php
    $first_level = $html->image('icons/tree_end.gif');
    $second_level = '&nbsp;&nbsp;&nbsp;&nbsp;'.$first_level;
    $third_level = '&nbsp;&nbsp;&nbsp;&nbsp;'.$second_level ;
?>

<div class="roles form">

<h2><?php __('Add Role');?></h2>

<?php echo $form->create('Role');?>

    <fieldset>
        <legend><?php __('Add Role');?></legend>
        <div class="fieldset-inside">
<div>
        <p class='note'><?php __('Please fill in the field and select tasks for the role. ')?></p><br>
        <?php echo $form->input('name', array('error' => array(
        'required' => __('This field cannot be left blank',true),
        'unique' => __('The name already taken',true)
    ))); ?>
</div>
    </div>
    </fieldset>
    <br />
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

