<div id="flashMessage">
<?php
__('Missing Controller',true); // for translation
?>
<p class="error">
<?php __('MyMeeting has encountered a problem accessing the page right now.')?><br/>
<?php echo $html->link(__('Go to MyCommittees',true),array('controller'=>'committees','action'=>'mainpage'))?> 
<?php __('and start again.')?>
</p>
</div>
