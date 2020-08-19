<?php
echo $this->element('tinymce',array('preset'=>'basic'));
?>
<h4><?php __('Legend:'); ?></h4>
<ul>
<li> <?php __('### :- Every decision is separated by 3 hashes'); ?> </li>
<li> <?php __('[[ project/item ]] :- The short name or name of the project or item the decision is related to'); ?> </li>
<li> <?php __('{{ user }} :- The user or users(separated by comma) which have to take action on the decision'); ?></li>
<li> <?php __('{{ g: groupname }} :- The group or groups(separated by comma) which have to take action on the decision'); ?></li>
<li> <?php __(' (( dateline )) :- The dateline for the decision'); ?></li>
</ul>
<?php 
echo $form->create('Decision',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'verifyminutes','meetingid'=>$meeting['Meeting']['id'])));
echo $form->textarea('data',array('cols'=>70,'rows'=>30,'value'=>$meeting['Meeting']['minutes_raw']));
echo $form->hidden('meeting_id',array('value'=>$meeting['Meeting']['id'])); 
echo $form->submit();
echo $form->end(); 
?>
