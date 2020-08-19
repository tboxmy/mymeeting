<div class="committeesTodos form">
<h2><?php __("Edit committee's To-do");?></h2>

<?php echo $form->create('Committeetodo',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit')));?>
    <fieldset>
        <legend><?php __('Edit To-do');?></legend>
    <?php
        echo $form->input('id');
        //echo $html->div('',$form->label('','Committee').$committeesTodo['Committee']['short_name']);
        echo $form->input('name');
        echo $form->input('priority');
        echo $form->input('user_id');
    ?>
    </fieldset>
    <br />
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

