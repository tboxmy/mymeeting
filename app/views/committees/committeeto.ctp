<h2><?php __('Current Committees Todo');?></h2>



<table cellpadding='0' cellspacing='0' width='70%'>
        <tr>
            <th><?php __('List Todo') ?></th>
	    <th><?php __('') ?></th>
        </tr>
<tr>
<?php
$i = 0;
foreach ($dtodo as $todos):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>


<tr<?php echo $class;?>>
        
	<td><?php echo $todos['Todo']['name']?></td>

        
    <?php endforeach;?>
</tr>
</table>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?><br><br>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Add Meeting todos', true), array('controller'=> 'committeetodo', 'action'=>'add')); ?> </li>
	</ul>
</div>

