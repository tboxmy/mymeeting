<div class="workflows index">
<?php if(isset($allow_add_workflow)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new workflow",true),array('action'=>'add')); ?> ]</p>
<?php endif; ?>
<h2><?php __('Workflows');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('committee');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($workflows as $workflow):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $workflow['Workflow']['id']; ?>
		</td>
		<td>
			<?php echo $workflow['Workflow']['name']; ?>
		</td>
		<td>
			<?php echo $workflow['Committee']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $workflow['Workflow']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $workflow['Workflow']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $workflow['Workflow']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workflow['Workflow']['id'])); ?>
		<?php echo $html->link(__('Rules', true), array('controller'=>'wfrules','action'=>'index', 'workflow_id'=>$workflow['Workflow']['id'])); ?>
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

