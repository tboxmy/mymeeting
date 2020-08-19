<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
if(isset($javascript)):
    // load script in <head> section
    $javascript->link('scriptaculous/lib/prototype', false);
$javascript->link('scriptaculous/src/scriptaculous', false);
$javascript->link('modalbox/modalbox', false);
echo $html->css('modalbox');
endif;
?>
<script>
function newitem(decision){
    $('Decision['+decision+'][ItemShortName]').disabled=false;
    $('Decision['+decision+'][ItemName]').disabled=false;
    $('Decision['+decision+'][Item]').disabled=true;
}

function existitem(decision){
    $('Decision['+decision+'][ItemShortName]').disabled=true;
    $('Decision['+decision+'][ItemName]').disabled=true;
    $('Decision['+decision+'][Item]').disabled=false;
}
function reloaditems(){
    var url='<?php echo $html->url(array('controller'=>'ajaxes','action'=>'latestitem'))?>/'+<?php echo $dcommittee['Committee']['id']; ?>;
    var dajax=new Ajax.Request(url,{onSuccess:refreshitems});
}
function refreshitems(response){
    items=response.responseText.split(',');
    dselector=$$('.itemlist');
    for(var ssindex=0,sslen=dselector.length; ssindex<sslen; ++ssindex){
        dselector[ssindex].options[dselector[ssindex].options.length]=new Option(items[1],items[0]);
    }
}
</script>
<div class="decisions form">
<?php
echo $this->element('tinymce',array('preset'=>'basic'));
echo $form->create('Decision',array('type'=>'file','url'=>array('meetingid'=>$meeting['Meeting']['id'],'committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit')));?>
    <fieldset>
        <legend><?php __('Edit Decision');?></legend>
<?php
if(isset($returnpage)){
    echo $form->hidden('returnpage',array('value'=>$returnpage));
}
echo $form->input('id');
echo $html->div('input','<label>'.__('Meeting',true)."</label>".$meeting['Meeting']['meeting_num']);
echo $form->input('item_id',array('label'=>ucwords($item_name),'class'=>'itemlist','after'=>' '.$html->link('Add',array('action'=>'try'),array('onclick'=>'Modalbox.show("'.$html->url(array('controller'=>'items','action'=>'add_dialog','committee'=>$dcommittee['Committee']['short_name'])).'",{title:this.title,width:600});return false;'))));
echo $form->input('description');

echo $multiFile->input('additionalfiles',array('label'=>'Additional Files'));
echo $datePicker->picker('deadline');
echo '<div class="fieldset-inside">';
echo $this->element('usergrouplist',array('users'=>$users,'groups'=>$groups));
?>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

