<div class="wfstatuses index">
<?php if(isset($allow_add_wfstatus)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new workflow status",true),array('action'=>'add')); ?> ]</p>
<?php endif; ?>
<h2><?php __('Wfstatuses');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('model');?></th>
	<th><?php echo $paginator->sort('foreign_key');?></th>
	<th><?php echo $paginator->sort('workflow_id');?></th>
	<th><?php echo $paginator->sort('level');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($wfstatuses as $wfstatus):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $wfstatus['Wfstatus']['id']; ?>
		</td>
		<td>
			<?php echo $wfstatus['Wfstatus']['model']; ?>
		</td>
		<td>
			<?php echo $wfstatus['Wfstatus']['foreign_key']; ?>
		</td>
		<td>
			<?php echo $html->link($wfstatus['Workflow']['name'], array('controller'=> 'workflows', 'action'=>'view', $wfstatus['Workflow']['id'])); ?>
		</td>
		<td>
			<?php echo $wfstatus['Wfstatus']['level']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $wfstatus['Wfstatus']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $wfstatus['Wfstatus']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $wfstatus['Wfstatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wfstatus['Wfstatus']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
