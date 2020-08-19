<div id="flashMessage">
<?php
__('Missing View',true); // for translation
?>
<p class="error">
<?php __("The page you're looking for doesn't exist.")?><br/>
<?php echo $html->link(__('Go to MyCommittees',true),array('controller'=>'committees','action'=>'mainpage'))?> 
<?php __('and start again.')?>
</p>
</div>
