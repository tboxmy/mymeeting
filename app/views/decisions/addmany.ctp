<?php
echo $this->element('tinymce',array('preset'=>'basic'));
if(isset($javascript)){
    function minutesave(){
        alert('hello');
    }
}
?>
<h4>Legend:</h4>
<ul>
<li> [[ project/item ]] :- The short name or name of the project or item the decision is related to </li>
<li> {{ user }} :- The user or users(separated by comma) which have to take action on the decision</li>
<li> (( dateline )) :- The dateline for the decision</li>
<li> ### :- Separator for each decision</li>
</ul>
<?php 
echo $form->create('Decision',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'verify','meetingid'=>$meeting['Meeting']['id'])));
echo $form->textarea('data',array('cols'=>70,'rows'=>30,'value'=>$meeting['Meeting']['minutes']));
echo $form->hidden('meeting_id',array('value'=>$meeting['Meeting']['id'])); 
echo $form->submit();
echo $form->end(); 
?>
