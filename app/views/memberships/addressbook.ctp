<div class="memberships form">
<?php echo $crumb->getHtml('addressbook', null, 'auto' ) ;  ?>
<h2><?php  __('Address Book');?></h2>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Name','User.name').$paginator->sort('Job Title','User.job_title');?></th>	
	<th><?php echo "Address";?></th>	
	<th><?php echo "Telephone/Mobile/Fax";?></th>
	<th><?php echo "Email";?></th>
</tr>
<?php
$i = 0;
foreach ($memberships as $addressbook):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<ul><li><?php echo $addressbook ['User']['name']; ?></li>
			<li><?php echo $addressbook ['User']['job_title']; ?></li></ul>
			
		</td>		
		<td>
			<ul><li><?php echo $addressbook ['User']['address']; ?></li></ul>
		</td>		
		<td>
			<ul><li><?php echo $addressbook['User']['telephone']; ?></li>
			<li><?php echo $addressbook['User']['mobile']; ?></li>
			<li><?php echo $addressbook['User']['fax']; ?></li></ul>
		</td>
		<td>
			<ul><li><a href="mailto:<?php echo $addressbook['User']['email'];?>"><?php echo $addressbook['User']['email'];?></a></li></ul>
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
