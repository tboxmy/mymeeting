<div class="wfmodels form">
<h2><?php __('Add permission')?></h2>

<div class="contentsummary">
    <ul>
        <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $dcommittee['Committee']['name']; ?></li>
    </ul>

</div>
<?php echo $form->create('Wfmodel',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>

<fieldset>
<legend><?php __('Add new model permission');?></legend>
    <div class="fieldset-inside">
<p><?php __('Each permission is separated by a comma (,). To negate a permission prefix it with a !. The list of possible permission is:');?></p>
<ul>
<li><?php __('all');?></li>
<li><?php __('owner');?></li>
<li><?php __('invited');?></li>
<li><?php __('attended');?></li>
<li><?php __('role:&lt;user role&gt;');?></li>
<li><?php __('group:&lt;user group&gt;');?></li>
</ul>
<?php
$modeldat['Committee']=__('Committee',true);
$modeldat['Meeting']=__('Meeting',true);
$modeldat['Committeetodo']=__('Committe Todo',true);
$modeldat['Meetingtodo']=__('Meeting Todo',true);
$modeldat['Group']=__('Group',true);
$modeldat['Membership']=__('User',true);
$modeldat['Decision']=__('Decision',true);
$modeldat['Userstatus']=__('User Status',true);
$modeldat['Groupstatus']=__('Group Status',true);
$modeldat['Item']=__('Project',true);
$modeldat['Announcement']=__('Announcement',true);
$modeldat['Template']=__('Template',true);
$modeldat['Attendance']=__('Attendance',true);
$modeldat['Workflow']=__('Workflow',true);
$modeldat['Wfmodel']=__('Model Workflow',true);
echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
echo $html->div('input',$form->label('Model').$form->select('model',$modeldat));
if(isset($returnpage)){
    echo $form->hidden('returnpage',array('value'=>$returnpage));
}
echo $form->input('create');
echo $form->input('view');
echo $form->input('edit');
echo $form->input('delete');
echo $form->input('approve');
echo $form->input('disapprove');
?>
    </div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
