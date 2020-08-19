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
<?php
echo $this->element('tinymce',array('preset'=>'basic'));
echo $form->create('Decision',array('url'=>array('meetingid'=>$meeting['Meeting']['id'],'committee'=>$dcommittee['Committee']['short_name'],'action'=>'doaddmany')));
$deccount=1;

foreach($decisions as $decision){
	echo "<fieldset>";
	echo "<legend>".__('Decision',true)." ".$deccount."</legend>";

	/* Items list */
	if(isset($itemlist)) unset($itemlist);
	foreach($decision['Item'] as $item){
		$itemlist[$item['id']]=$item['short_name'];
	}
	if(isset($decision['noitem'])){
		$dkey=null;
	}
	else{
		$dkey=key($itemlist);
	}
	if(!isset($itemlist)) $itemlist[]='';
	echo $html->div('input',$form->label('['.$deccount.'][Item]',ucwords($item_name)).$form->select('['.$deccount.'][Item]',$itemlist,$dkey,array('class'=>'itemlist')).$html->link('Add',array('action'=>'try'),array('onclick'=>'Modalbox.show("'.$html->url(array('controller'=>'items','action'=>'add_dialog','committee'=>$dcommittee['Committee']['short_name'])).'",{title:this.title,width:600});return false;')));

	/* Users list */
	if(isset($decision['User']) && count($decision['User'])){
		$i=1;
		foreach($decision['User'] as $cuid=>$curuser) {
			if(isset($userlist)) unset($userlist);
			foreach($curuser as $user) {
				$userlist[$user['id']]=$user['name'];
			}
			if(isset($decision['nouser'][$cuid])){
				$dkey=null;
			}
			else{
				$dkey=key($userlist);
			}
			echo $html->div('input',$form->label('['.$deccount.'][User]['.$i.']',__('User',true).' '.$i++).$form->select('['.$deccount.'][User]['.$i.']',$userlist,$dkey));
		}
	}

	/* Group list */
	if(isset($decision['Group']) && count($decision['Group'])){
		$i=1;
		foreach($decision['Group'] as $cuid=>$curgroup) {
			if(isset($grouplist)) unset($grouplist);
			foreach($curgroup as $group) {
				$grouplist[$group['id']]=$group['name'];
			}
			if(isset($decision['nogroup'][$cuid])){
				$dkey=null;
			}
			else{
				$dkey=key($grouplist);
			}
			echo $html->div('input',$form->label('['.$deccount.'][Group]['.$i.']',__('Group',true).' '.$i++).$form->select('['.$deccount.'][Group]['.$i.']',$grouplist,$dkey));
		}
	}

	if($decision['Dateline']){
		echo $datePicker->picker('['.$deccount.'][Deadline]',array('label'=>'Dateline','value'=>$decision['Dateline']));
	}

	echo $form->textarea('['.$deccount.'][Decision]',array('rows'=>15,'value'=>$decision['Decision']));
	echo $form->hidden('['.$deccount.'][OriDecision]',array('value'=>$decision['OriDecision'])); 

	echo "</fieldset>";
	$deccount++;
}
echo $form->hidden('meeting_id',array('value'=>$meeting['Meeting']['id'])); 
echo $form->submit();
echo $form->end();
?>
