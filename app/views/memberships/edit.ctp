<div class="memberships form">
<h2><?php __('Edit Committee Member')?></h2>
<?php echo $form->create('Membership',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit')));?>
    <fieldset>
        <legend><?php __('Edit Committee Member');?></legend>
        <div class="fieldset-inside">
    <?php
        echo $form->input('id');
        echo $html->div('',$form->label('','Name').$membership['User']['name']);
        echo $form->input('role_id');
    ?>
        </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

