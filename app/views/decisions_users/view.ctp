<div class="decisionsUsers view">
<h2><?php  __('DecisionsUser');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $decisionsUser['DecisionsUser']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Decision'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($decisionsUser['Decision']['id'], array('controller'=> 'decisions', 'action'=>'view', $decisionsUser['Decision']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($decisionsUser['User']['name'], array('controller'=> 'users', 'action'=>'view', $decisionsUser['User']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit DecisionsUser', true), array('action'=>'edit', $decisionsUser['DecisionsUser']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete DecisionsUser', true), array('action'=>'delete', $decisionsUser['DecisionsUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $decisionsUser['DecisionsUser']['id'])); ?> </li>
		<li><?php echo $html->link(__('List DecisionsUsers', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New DecisionsUser', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Decisions', true), array('controller'=> 'decisions', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Decision', true), array('controller'=> 'decisions', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
