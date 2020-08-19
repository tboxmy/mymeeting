<div class="address book">
<h2><?php  __('Address Book');?></h2>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<table cellpadding="0" cellspacing="0">
<tr>
	
	
	<th><?php echo $paginator->sort('name').$paginator->sort('job_title');?></th>	
	<th><?php echo $paginator->sort('address');?></th>	
	<th><?php echo $paginator->sort('telephone').$paginator->sort('mobile').$paginator->sort('fax');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<ul><li><?php echo $user['Title']['short_name'].$user['User']['name']; ?></li>
			<li><?php echo $user['User']['job_title']; ?></li></ul>
			
		</td>		
		<td>
			<ul><li><?php echo $user['User']['address']; ?></li></ul>
		</td>		
		<td>
			<ul><li><?php echo $user['User']['telephone']; ?></li>
			<li><?php echo $user['User']['mobile']; ?></li>
			<li><?php echo $user['User']['fax']; ?></li></ul>
		</td>
		<td>
			<ul><li><a href="mailto:<?php echo $user['User']['email'];?>"><?php echo $user['User']['email'];?></a></li></ul>
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
