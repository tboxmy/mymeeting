<?php
if(isset($javascript)):
// load script in <head> section
$javascript->link('scriptaculous/lib/prototype', false);
?>
<script>
function addlevel(){
    dtable=$('wflevels');
    newindex=dtable.rows.length-1;
    //var tr=new Element('tr').update(new Element('input',{'name':'data[Workflow]['+newindex+'][level]'}));
    //dtable.extend(tr);
    var tr=new Element('tr');
    tr.appendChild(new Element('input',{'name':'data[Workflow]['+newindex+'][level]','type':'hidden','value':newindex}));
    tr.appendChild(new Element('td').update(newindex));
    tr.appendChild(new Element('td').update(new Element('input',{'name':'data[Workflow]['+newindex+'][view]'})));
    tr.appendChild(new Element('td').update(new Element('input',{'name':'data[Workflow]['+newindex+'][edit]'})));
    tr.appendChild(new Element('td').update(new Element('input',{'name':'data[Workflow]['+newindex+'][delete]'})));
    tr.appendChild(new Element('td').update(new Element('input',{'name':'data[Workflow]['+newindex+'][approve]'})));
    tr.appendChild(new Element('td').update(new Element('input',{'name':'data[Workflow]['+newindex+'][disapprove]'})));
    dtable.appendChild(tr);
}
</script>
<?php
endif;
?>

<h2><?php __('Edit model permission')?></h2>

<div class="contentsummary">
    <ul>
        <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $dcommittee['Committee']['name']; ?></li>
        <li><span class="viewtitle"><?php __('Model'); ?>: </span><?php __($this->data['Wfmodel']['model']); ?></li>
    </ul>

</div>
<div class="wfmodels form">
<?php echo $form->create('Wfmodel',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
<fieldset>
<legend><?php __('Edit permission');?></legend>
<div class='fieldset-inside'>
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
echo $form->input('id');
$modeldat['Item']=__('Project',true);
$modeldat['Meeting']=__('Meeting',true);
$modeldat['Decision']=__('Decision',true);
$modeldat['Status']=__('Status',true);
echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
echo $form->input('create');
echo $form->input('view');
echo $form->input('edit');
echo $form->input('delete');
echo $form->input('approve');
echo $form->input('disapprove');
?>
    </div>
</fieldset>
<fieldset>
<legend><?php __('Levels');?></legend>
    <div class='fieldset-inside'>
    <?php
    
echo '[ '.$html->link(__('Add new level',true),'',array('onclick'=>'addlevel(); return false;')).' ]<br/>';
echo "<table id='wflevels' cellpadding='0' cellspacing='0'><tr><th>".__('Level',true)."</th><th>".__('View',true)."</th><th>".__('Edit',true)."</th><th>".__('Delete',true)."</th><th>".__('Approve',true)."</th><th>".__('Disapprove',true)."</th><tr>";
if(isset($workflows) && is_array($workflows) && count($workflows)){
    $i=0;
    foreach($workflows as $workflow){
        echo "<tr>";
        echo $form->hidden('Workflow.id',array('value'=>$workflow['Workflow']['id'],'name'=>'data[Workflow]['.$i.'][id]'));
        echo "<td>".$workflow['Workflow']['level']."</td>";
        echo "<td>".$form->text('Workflow.view',array('value'=>$workflow['Workflow']['view'],'name'=>'data[Workflow]['.$i.'][view]'))."</td>";
        echo "<td>".$form->text('Workflow.edit',array('value'=>$workflow['Workflow']['edit'],'name'=>'data[Workflow]['.$i.'][edit]'))."</td>";
        echo "<td>".$form->text('Workflow.delete',array('value'=>$workflow['Workflow']['delete'],'name'=>'data[Workflow]['.$i.'][delete]'))."</td>";
        echo "<td>".$form->text('Workflow.approve',array('value'=>$workflow['Workflow']['approve'],'name'=>'data[Workflow]['.$i.'][approve]'))."</td>";
        echo "<td>".$form->text('Workflow.disapprove',array('value'=>$workflow['Workflow']['disapprove'],'name'=>'data[Workflow]['.$i.'][disapprove]'))."</td>";
        echo "</tr>";
        $i++;
    }
}
echo "</table>";
    ?>
    </div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
