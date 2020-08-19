<div class="wfstatuses view">
<h2><?php  __('Wfstatus');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wfstatus['Wfstatus']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Model'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wfstatus['Wfstatus']['model']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Foreign Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wfstatus['Wfstatus']['foreign_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Workflow'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($wfstatus['Workflow']['name'], array('controller'=> 'workflows', 'action'=>'view', $wfstatus['Workflow']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Level'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wfstatus['Wfstatus']['level']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Wfstatus', true), array('action'=>'edit', $wfstatus['Wfstatus']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Wfstatus', true), array('action'=>'delete', $wfstatus['Wfstatus']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wfstatus['Wfstatus']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Wfstatuses', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Wfstatus', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Workflows', true), array('controller'=> 'workflows', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Workflow', true), array('controller'=> 'workflows', 'action'=>'add')); ?> </li>
	</ul>
</div>
