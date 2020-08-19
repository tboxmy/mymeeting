<div class="wfmodels view">
<h2><?php  __('Wfmodel');?></h2>

<ul>
<li><span class="viewtitle"><?php __('Model')?>:</span> <?php __($wfmodel['Wfmodel']['model'])?></li>
</ul>
<fieldset>
<legend><?php __('Wfmodel')?></legend>
<div class="fieldset-inside">
    <ul>
    <li><?php __('View')?>: <?php echo $wfmodel['Wfmodel']['view']?></li>
    <li><?php __('Create')?>: <?php echo $wfmodel['Wfmodel']['create']?></li>
    <li><?php __('Edit')?>: <?php echo $wfmodel['Wfmodel']['edit']?></li>
    <li><?php __('Delete')?>: <?php echo $wfmodel['Wfmodel']['delete']?></li>
    <li><?php __('Approve')?>: <?php echo $wfmodel['Wfmodel']['approve']?></li>
    <li><?php __('Disapprove')?>: <?php echo $wfmodel['Wfmodel']['disapprove']?></li>
    </ul>
</div>
</fieldset>
<br/>

<?php echo $form->button(__('Back', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
</div>
