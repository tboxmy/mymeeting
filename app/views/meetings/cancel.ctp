
<p class='contentmenu'>[ <?php echo $html->link(__("Edit message",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit_cancelation','id'=>$meeting['Meeting']['id'])); ?> ]

<h2><?php __('Cancel meeting')?></h2>
<div id="message_preview">
<?php
echo $template['Template']['template'];
?>
</div>
<br/>
<?php

echo $html->link(__('Send cancelation',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'send_cancel','id'=>$meeting['Meeting']['id']),array('class'=>'button'));
echo "&nbsp;";
echo $html->link(__('Do not send cancelation',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'index'),array('class'=>'button'));
?>
