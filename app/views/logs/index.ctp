<div class="logs index">
[ <?php echo $html->link(__('Delete logs - 6 months ago',true),array('action'=>'delete_6_months'), null,__('Logs older than 6 months old will be deleted.', true),false) ?> ]
[ <?php echo $html->link(__('Delete logs - 1 year ago',true),array('action'=>'delete_1_year'), null,__('Logs older than 1 year old will be deleted.', true),false)?> ]
<h2><?php __('Logs');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('controller');?></th>
	<th><?php echo $paginator->sort('action');?></th>
	<th><?php echo $paginator->sort('url');?></th>
	<th><?php echo $paginator->sort('message');?></th>
	<th><?php echo $paginator->sort('timestamp');?></th>
</tr>
<?php
if(!count($logs)) 
    echo "<tr><td colspan='6'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Log']['options']['limit'] - $this->params['paging']['Log']['options']['limit']; 

foreach ($logs as $log):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $i.'. '; ?>
		</td>
		<td>
			<?php echo $log['User']['name']; ?>
		</td>
		<td>
			<?php echo $log['Log']['controller']; ?>
		</td>
		<td>
			<?php echo $log['Log']['action']; ?>
		</td>
		<td>
			<?php echo $log['Log']['url']; ?>
		</td>
		<td>
			<?php echo $log['Log']['message']; ?>
		</td>
		<td>
			<?php echo $log['Log']['timestamp']; ?>
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
