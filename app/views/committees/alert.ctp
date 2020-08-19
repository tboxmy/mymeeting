<?php echo $this->element('announcement');?>

<h2><?php __('Your upcoming meetings')?></h2>
<?php
echo $this->requestAction(array('controller'=>'ajaxes','action'=>'calendar','committee'=>$dcommittee['Committee']['short_name']));
?>

<h2><?php __('Important Alerts')?></h2>
<?php echo $this->element('upcoming');?>
