<div class="users alerts">
<?php echo $crumb->getHtml('Alert', null, 'auto' ) ;  ?>
<h2><?php  __('Alerts');?></h2>
<table cellpadding="0" cellspacing="0">
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<?php
$i = 0;
foreach ($announcements as $announcement):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		
		<td>
		<ul>

			<li><?php __('Committee');?>: <?php echo $announcement['Committee']['name']; ?></li>
			<li><?php __('Announcement');?>: <?php echo $announcement['Announcement']['description'];?></li>
		</ul>
			
		</td>
		
		
		
		
		
	</tr>
<?php endforeach; ?>
</table>

</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
    <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

