<p class="contentmenu">
<?php
echo '['.$html->link(__('Edit message/Schedule invitation',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'edit_invitation','id'=>$meeting['Meeting']['id'])).']';
?>
<h2><?php __('Invitation to meeting');?></h2>
<fieldset>
    <legend><?php __('Invitation to meeting');?></legend>
    <div class="fieldset-inside">
    <div class="note"><?php __("Note:<br/>1. Below is the message that is going to be sent to all invitees.<br/>2. %name will be replaced with invitee's name.")?></div>
    <div id="message_preview">
    <?php
    echo $template['Template']['template'];
    ?>
    </div>
</div>
</fieldset>
<br />
<?php

if($meeting['Meeting']['invite_date']){
$dtext=sprintf(__('Send invitation on %s',true),date(Configure::read('date_format'),strtotime($meeting['Meeting']['invite_date'])));
}
else{
    $dtext=__('Send invitation now',true);
}
echo $html->link($dtext,array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'send_invite','id'=>$meeting['Meeting']['id']),array('class'=>'button')). "&nbsp;"; 
echo $html->link(__('Do not send invitation',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'index'),array('class'=>'button'));
?>
</p>
