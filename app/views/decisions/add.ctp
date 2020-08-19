<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : __('Project',true);
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
<h2>
<?php __('Add Decision');?>
<?php 
echo $this->element('tinymce',array('preset'=>'basic'));
if (isset($this->params['named']['meeting_id'])) {
    __(' for Meeting: ');
    echo $meetings[$this->params['named']['meeting_id']];
} 
if (isset($this->params['named']['item_id'])) {
    echo sprintf(__(' for %s: ',true),$item_name);
    echo $items[$this->params['named']['item_id']];
} 
?>
</h2>

<?php if (isset($meeting)) { ?>
    <div class="contentsummary">
        <ul>
        <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $meeting['Committee']['name']; ?></li>
        <li><span class="viewtitle"><?php __('Meeting No'); ?>: </span><?php echo $meeting['Meeting']['meeting_num'];?></li>
        <li><span class="viewtitle"><?php __('Meeting Date'); ?>: </span><?php echo date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>
        &nbsp;<?php echo date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date'])); ?></li>
        <li><span class="viewtitle"><?php __('Venue'); ?>: </span><?php echo $meeting['Meeting']['venue']; ?></li>
        </ul>
    </div>
<?php }?>

<?php if (isset($item)) { ?>
    <div class="contentsummary">
        <ul>
        <li><span class="viewtitle"><?php __('Committee'); ?>:</span> <?php echo $item['Committee']['name'];?></li>
        <li><span class="viewtitle"><?php echo sprintf(__('%s Name',true),$item_name); ?>:</span> <?php echo $item['Item']['name'];?></li>
        <li><span class="viewtitle"><?php echo sprintf(__('%s Short Name',true),$item_name); ?>:</span> <?php echo $item['Item']['short_name']; ?></li>
        <li><span class="viewtitle"><?php __('Description'); ?>:</span> <?php echo $item['Item']['description']; ?></li>
        </ul>
    </div>
<?php }?>

<?php echo $form->create('Decision',array('type'=>'file','url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
<fieldset>
    <div class="fieldset-inside">
    <legend><?php __('Add Decision');?></legend>
    <?php
    if(isset($meeting)){
        echo $form->hidden('meeting_id',array('value'=>$meeting['Meeting']['id']));
    }
    else{
        echo $form->input('meeting_id');
    }
    if(isset($item)){
        echo $form->hidden('item_id',array('value'=>$item['Item']['id']));
    }
    else{
        echo $form->input('item_id',array('label'=>ucwords($item_name),'class'=>'itemlist','after'=>' '.$html->link(__('Add',true),array('action'=>'try'),array('onclick'=>'Modalbox.show("'.$html->url(array('controller'=>'items','action'=>'add_dialog','committee'=>$dcommittee['Committee']['short_name'])).'",{title:this.title,width:600});return false;'))));
    }
    if(isset($returnpage)){
        echo $form->hidden('returnpage',array('value'=>$returnpage));
    }
    echo $form->input('description',array('class'=>'decision'));
    echo $multiFile->input('additionalfiles',array('label'=>'Additional Files'));
    echo $datePicker->picker('deadline');   
    echo '<div class="fieldset-inside">';
    echo $this->element('usergrouplist',array('users'=>$users,'groups'=>$groups));
    echo '</div>';
    ?>
    </div>
</fieldset>
<br />
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>

