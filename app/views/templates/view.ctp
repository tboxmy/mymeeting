<div class="templates view">
<h2><?php  __('Message Template');?></h2>
<ul>
<li><span class="viewtitle"><?php __('Title');?>:</span> <?php echo $template['Template']['title'];?> </li>
<li><span class="viewtitle"><?php __('Description');?>:</span> <?php echo $template['Template']['description'];?> </li>
</ul>
<fieldset>
<legend><?php __('Message template')?></legend>
<div class="fieldset-inside">
<?php echo $template['Template']['template'];?>
</div>
</fieldset>
</div>
<br/>
<?php echo $form->button('Back', array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
