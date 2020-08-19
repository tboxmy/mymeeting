
<div class="committee search">
<h2>
<?php  __('Search committee');?>: <?php echo $dcommittee['Committee']['name'];?>
</h2>
<?php echo $form->create('Committee',array('url'=>array('controller'=>'committees','action'=>'search','committee'=>$dcommittee['Committee']['short_name'])));?>

<fieldset>
    <legend>
    <?php __('Please enter your criteria below:');?>  
    </legend>
    <div class="fieldset-inside">
<?php

echo $html->div('',$form->label('Search.status', __('Action Status',true)).'&nbsp;'.
$form->select('Search.status',
    $options = array('takenontime'=>__('Taken, on time',true),
    'takenlate'=>__('Taken, late',true),
    'nottaken'=>__('Not taken, before due date',true),
    'nottakenlate'=>__('Not taken, overdue',true)),
    isset($cursearch)?$cursearch:null,'',__('--please select--',true)     
));
?> <?php echo $form->button(__('Submit',true), array('type'=>'submit'));?>&nbsp;
    </div>
</fieldset>
<?php echo $form->end();?>

<p>&nbsp;</p>
<h4><?php echo __('Individual Implementors');?></h4>

<table cellpadding="0" cellspacing="0">
<tr>
    <th width="2%"><?php __('No')?></th>
    <th><?php __('Meeting');?></th>
    <th><?php __('Project/Item');?></th>
    <th width="20%"><?php __('Decision');?></th>
    <th width="30%"><?php __('Implementors & Status');?></th>
</tr>

<?php if(!isset($results) || !count($results)):?>
<tr><td colspan="7"><?php __('No records found')?></td></tr>
<?php else: ?>
<?php
$i = 0;
foreach ($results as $result):
    $class = null;
if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
}
?>
        <tr<?php echo $class;?>>
            <td><?php echo $i.'. ' ?></td>
            <td><?php echo $html->link($result['Meeting']['meeting_title'],array('controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Meeting']['id'])); ?></td>
            <td><?php echo $html->link($result['Item']['name'],array('controller'=>'items','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Item']['id'])); ?></td>
            <td><?php echo $html->link($text->truncate($result['Decision']['description'],200),array('controller'=>'decisions','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Decision']['id']),null,false,false); ?>
            <br />Deadline: <strong><?php echo date(Configure::read('date_format'),strtotime($result['Decision']['deadline']))?></strong>
            </td>
            <td>
<?php 
if(isset($result['User']['name'])){
    echo $result['User']['name'];
    echo "<br>";
    echo isset($result['UserStatus']['description'])?$result['UserStatus']['description']:__('No status',true);
}
if(isset($result['Group']['name'])){
    echo $result['Group']['name'];
    echo "<br>";
    echo isset($result['GroupStatus']['description'])?$result['GroupStatus']['description']:__('No status',true);
}
?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif;?>
</table>

<p>&nbsp;</p>
<h4><?php echo __('Group Implementors');?></h4>

<table cellpadding="0" cellspacing="0">
<tr>
    <th width="2%"><?php __('No')?></th>
    <th><?php __('Meeting');?></th>
    <th><?php __('Project/Item');?></th>
    <th width="20%"><?php __('Decision');?></th>
    <th width="30%"><?php __('Implementors & Status');?></th>
</tr>

<?php if(!isset($results_grp) || !count($results_grp)):?>
<tr><td colspan="7"><?php __('No records found')?></td></tr>
<?php else: ?>
<?php
$i = 0;
foreach ($results_grp as $result):
    $class = null;
if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
}
?>
        <tr<?php echo $class;?>>
            <td><?php echo $i.'. ' ?></td>
            <td><?php echo $html->link($result['Meeting']['meeting_title'],array('controller'=>'meetings','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Meeting']['id'])); ?></td>
            <td><?php echo $html->link($result['Item']['name'],array('controller'=>'items','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Item']['id'])); ?></td>
            <td><?php echo $html->link($text->truncate($result['Decision']['description'],200),array('controller'=>'decisions','committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$result['Decision']['id']),null,null,false); ?>
            <br />Deadline: <strong><?php echo date(Configure::read('date_format'),strtotime($result['Decision']['deadline']))?></strong>
            </td>
            <td>
<?php 
if(isset($result['User']['name'])){
    echo $result['User']['name'];
    echo "<br>";
    echo isset($result['UserStatus']['description'])?$result['UserStatus']['description']:__('No status',true);
}
if(isset($result['Group']['name'])){
    echo $result['Group']['name'];
    echo "<br>";
    echo isset($result['GroupStatus']['description'])?$result['GroupStatus']['description']:__('No status',true);
}
?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif;?>
</table>
</div>

