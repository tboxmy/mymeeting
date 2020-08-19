<div class="groups view">
<h2><?php  __('View Group'); ?></h2>
<ul>
<li><span class="viewtitle"><?php __('Name');?>:</span><?php echo ' '.$group['Group']['name'];?></li>
</ul>

<fieldset>
<legend><?php __('Group Membership')?></legend>
<div class="fieldset-inside">
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th width="3%"><?php __('No'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Job Title'); ?></th>
		<th><?php __('Email'); ?></th>
		<th><?php __('Telephone'); ?></th>
	</tr>
	<?php if (!empty($group['User'])):?>
	<?php
		$i = 0;
		foreach ($group['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $i.'. ';?></td>
			<td><?php echo $user['name'];?></td>
			<td><?php echo $user['job_title'];?></td>
			<td><?php echo $user['email'];?></td>
			<td><?php echo $user['telephone'];?></td>
		</tr>
	<?php endforeach; ?>
    <?php else:?>
    <tr><td colspan='4'><?php __('No record found')?></td></tr>
    <?php endif;?>
	</table>
</div>
</fieldset>

<br/>
<?php echo $form->button(__('Back', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
</div>

