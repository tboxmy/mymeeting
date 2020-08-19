<h1>Editing Templates</h1>
<h2><?php __('Inviation Email Preview') ?></h2>
<div id="message_preview">
<?php
echo $invite['Template']['template'];
?>
</div>
<br><br>
<h2><?php __('Change Email Preview') ?></h2>
<div id="message_preview">
<?php
echo $change['Template']['template'];
?>
</div>
<br><br>
<h2><?php __('Uninvite Email Preview') ?></h2>
<div id="message_preview">
<?php
echo $uninvite['Template']['template'];
?>
</div>
<?php
echo "<li>".$html->link(__('Edit emails',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'editemails','id'=>$meeting['Meeting']['id']))."</li>";
if($meeting['Meeting']['invite_date']){
$dtext=sprintf(__('Send emails on %s',true),date(Configure::read('date_format'),strtotime($meeting['Meeting']['invite_date'])));
}
else{
    $dtext=__('Send emails now',true);
}
echo "<li>".$html->link($dtext,array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'send_emails','id'=>$meeting['Meeting']['id']))."</li>";
echo "<li>".$html->link(__('Do not send emails',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'index'))."</li>";
?>
