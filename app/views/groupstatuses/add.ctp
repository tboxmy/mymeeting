<div class="groupStatuses form">

<h2><?php __('Status')?></h2>

<?php $item_name = strlen($dcommittee['Committee']['item_name'])>2 ? __($dcommittee['Committee']['item_name'],true) : __('Project',true);?>

<span class="viewtitle"><?php echo ucwords($item_name);?>:</span> <?php echo $html->link($decision['Item']['short_name'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'items','action'=>'view',$decision['Item']['id']));?><br/>
<span class="viewtitle"><?php __('Deadline');?>:</span> <?php echo date(Configure::read('date_format',strtotime($decision['Decision']['deadline'])));?><br/>
<span class="viewtitle"><?php __('Description');?>:</span>

<?php echo $html->div('decision_text',$decision['Decision']['description']);?>

<?php
if(count($decision['User'])):
?>
    <span class="viewtitle"><?php __('Individual Implementor');?>:</span> <?php echo "<ul>"; foreach($decision['User'] as $user) echo "<li>".$user['name']."</li>"; echo "</ul>"; ?>
<?php
endif;
if(count($decision['Group'])):
?>
    <span class="viewtitle"><?php __('Group Implementor');?>:</span> <?php echo "<ul>"; foreach($decision['Group'] as $group) echo "<li>".$group['name']."</li>"; echo "</ul>"; ?>
<?php
endif;
?>
            

<?php echo $form->create('Groupstatus',array('type'=>'file','url'=>array('committee'=>$dcommittee['Committee']['short_name'],'decisionid'=>$this->params['decisionid'])));?>
    <fieldset>
        <legend><?php __('Add Groupstatus');?></legend>
<?php
echo $form->hidden('decision_id',array('value'=>$this->params['decisionid']));
echo $form->hidden('group_id',array('value'=>$this->params['group_id']));
echo $form->input('description');
echo $datePicker->picker('action_date',array('value'=>date('Y-m-d')));
echo $multiFile->input('additionalfiles',array('label'=>'Additional Files'));
if(isset($returnpage)){
    echo $form->hidden('returnpage',array('value'=>$returnpage));
}
?>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
