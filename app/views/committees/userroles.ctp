<div class="committees form">

<h2><?php __('Committee Users');?></h2>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Name', 'User.name');?></th>
	<th><?php echo $paginator->sort('Role', 'Role.name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($committeesUsers as $usersroles):

	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $usersroles['User']['name']; ?>
		</td>
		<td>
			<?php echo $usersroles['Role']['name']; ?>
		</td>
		<td class="actions">
			
			<?php echo $html->link(__('Edit Roles', true), array('controller'=>'committees_users','action'=>'editroles', $usersroles['CommitteesUser']['id'],$usersroles['CommitteesUser']['user_id'],$usersroles['CommitteesUser']['committee_id'])); ?>

			
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

</div>
