<div class="meetingtodos form">

<h2><?php __("Meeting's To-do")?></h2>

	<fieldset>
 		<legend><?php __('Add Meetingtodo');?></legend>
 		<div class="fieldset-inside">
<?php echo $form->create('Meetingtodo',array('url'=>array('id'=>$meetingid,'committee'=>$this->params['committee'],'action'=>'add')));?>
	<?php
if(isset($meetingid)){
    echo $form->hidden('meeting_id',array('value'=>$meetingid));
    echo $html->div('input',$form->label(__('Meeting',true))."<strong>".$meetings[$meetingid]."</strong>");
}
else{
    echo $form->input('Meeting');
}
		echo $form->input('name');
		echo $form->input('priority');
		echo $form->input('user_id');
	?>
	    </div>
	</fieldset>
	</br/>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

