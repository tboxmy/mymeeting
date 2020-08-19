<div class="committees form">
<h2><?php __('Add Sub-committee');?></h2>
<ul>
<li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $dcommittee['Committee']['name']; ?></li>
</ul>

<?php echo $form->create('Committee');?>
    <fieldset>
        <legend><?php __('Add Sub-committee');?></legend>
    <?php
        $note = __('Note',true).'<br/>';
        $note.= __('%xxxx refers to meeting number',true).' - ('.__('Meeting Num Template',true).')<br/>';
        $note.= __('%yyyy refers to year',true).' - ('.__('Meeting Num Template',true).')<br/>';
        $note.= __("%committeeshort refers to committee's short name",true).' - ('.__('Meeting Title Template',true).')<br/>';
        $note.= __("%committeelong refers to committee's long name",true).' - ('.__('Meeting Title Template',true).')<br/>';
        echo $html->div('note',$note);   
        
        echo $form->hidden('parent_id',array('value'=>$dcommittee['Committee']['id']));   
        echo $form->input('name',array('error'=>__('This field cannot be left blank',true),'size'=>'50'));       
        echo $form->input('short_name',array('error' => array(
            'required' => __('This field cannot be left blank',true),
            'unique' => __('The short name already taken',true),
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'message' => __('Alphabets and numbers only',true))
        )));
        echo $form->input('meeting_num_template',array('value'=>__('No',true).' %xxxx '.__('Year',true).' %yyyy','error'=>__('This field cannot be left blank',true)));  
        echo $form->input('meeting_title_template', array('value'=>__('Meeting',true).' %committeeshort','size'=>'30'));
    ?>

    </fieldset>
    <br />

<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

