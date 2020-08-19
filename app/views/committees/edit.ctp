<?php
echo $this->element('tinymce',array('preset'=>'basic'));
?>
<div class="committees form">
<h2><?php  __('Edit Committee');?></h2>
<?php echo $form->create('Committee');?>
    <fieldset>
        <legend><?php  __('Edit Committee');?></legend>
<?php
$note = __('Note',true).'<br/>';
$note.= __('%xxxx refers to meeting number',true).' - ('.__('Meeting Num Template',true).')<br/>';
$note.= __('%yyyy refers to year',true).' - ('.__('Meeting Num Template',true).')<br/>';
$note.= __("%committeeshort refers to committee's short name",true).' - ('.__('Meeting Title Template',true).')<br/>';
$note.= __("%committeelong refers to committee's long name",true).' - ('.__('Meeting Title Template',true).')<br/>';
echo $html->div('note',$note);   


echo $form->input('parent_id', array(
    'type'=>'select',
    'options'=>$mycommittees, 
    'default'=>$this->data['Committee']['parent_id'], 
    'empty'=> __('Top level',true),
    'class'=>'required','label'=>__('Parent',true)
    ));
echo $form->input('name',array('error'=>__('This field cannot be left blank',true),'size'=>'50'));       
echo $form->input('short_name',array('error' => array(
    'required' => __('This field cannot be left blank',true),
    'unique' => __('The short name already taken',true),
    'alphaNumeric' => array(
        'rule' => 'alphaNumeric',
        'message' => __('Alphabets and numbers only',true))
)));
echo $form->input('meeting_num_template',array('error'=>__('This field cannot be left blank',true),'label'=>__('Meeting Num Template',true)));  
echo $form->input('meeting_title_template', array('size'=>'30','label'=>__('Meeting Title Template',true)));
echo $form->input('item_name', array('size'=>'30', 'label'=>__('Item name',true)));
echo $form->input('minute_template', array('label'=>__('Minute Template',true),'row'=>'7','cols'=>'7'));
echo $form->input('id');
?>

    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

