<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
if(isset($javascript)):
// load script in <head> section
$javascript->link('scriptaculous/lib/prototype', false);
?>
<script>
function savedata(){
}
</script>
<?php
endif;
?>
<div class="items form">
<h2>
<?php echo sprintf(__('Add %s',true),$item_name);?>
</h2>
<?php echo $ajax->form('Item','post',array('url'=>array('action'=>'add_dialog','controller'=>'items','committee'=>$dcommittee['Committee']['short_name']))); ?>
<fieldset>
<legend><?php echo sprintf(__('Add %s',true),$item_name) ;?></legend>
<?php
echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
echo $form->input('name');
echo $form->input('short_name');
echo $form->input('description');
if(isset($returnpage)){
echo $form->hidden('returnpage',array('value'=>$returnpage));
}
?>
</fieldset>
<br/>
<?php echo $form->button(__('Submit', true), array('type'=>'submit', 'onclick'=>'Modalbox.hide({afterHide:reloaditems})'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'Modalbox.hide()'));?>
<?php echo $form->end();?>
</div>
