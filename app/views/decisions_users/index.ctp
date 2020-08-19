<div class="decisionsUsers index">
<h2><?php __('DecisionsUsers');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('decision_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($decisionsUsers as $decisionsUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $decisionsUser['DecisionsUser']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($decisionsUser['Decision']['id'], array('controller'=> 'decisions', 'action'=>'view', $decisionsUser['Decision']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($decisionsUser['User']['name'], array('controller'=> 'users', 'action'=>'view', $decisionsUser['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $decisionsUser['DecisionsUser']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $decisionsUser['DecisionsUser']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $decisionsUser['DecisionsUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $decisionsUser['DecisionsUser']['id'])); ?>
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

