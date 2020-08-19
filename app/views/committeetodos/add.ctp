<div class="committeesTodos form">
<h2><?php __("Add new committee's To-do");?></h2>

<?php echo $form->create('Committeetodo',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')));?>
    <fieldset>
        <legend><?php __('Add To-do');?></legend>

    <?php
    echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
    //echo $html->div('input',$form->label(__('Committee',true))."<strong>".$dcommittee['Committee']['name']."</strong>");

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

