<div class="todos index">
<p class='contentmenu'>[ <?php echo $html->link(__("Add new system-wide to-do",true),array('action'=>'add')); ?> ]</p>

<h2><?php __('To-do\'s');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No')?></th>
    <th><?php echo $paginator->sort('name');?></th>
    <th><?php echo $paginator->sort('priority');?></th>
    <th class="actions"><?php __('Actions');?></th>
</tr>
<?php if (!count($todos)):?>
<tr>
    <td colspan='4'><?php __('No record found')?></td>
</tr>
<?php endif;?>
<?php
if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Systemtodo']['options']['limit'] - $this->params['paging']['Systemtodo']['options']['limit']; 

foreach ($todos as $todo):
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
            <?php echo $todo['Systemtodo']['name']; ?>
        </td>
        <td>
            <?php echo $priorities[$todo['Systemtodo']['priority']]; ?>
        </td>          
        <td class="actions">
            <?php //echo $html->link($html->image('icons/view.gif'), array('action'=>'view', $todo['Systemtodo']['id']),null,null,false); ?>
            <?php echo $html->link($html->image('icons/edit.gif',array('alt'=>'Edit Item','title'=>'Edit Item')), array('action'=>'edit', $todo['Systemtodo']['id']),null,null,false); ?>




            <?php echo $html->link($html->image('icons/delete.gif',array('alt'=>'Delete Item','title'=>'Delete Item')), array('action'=>'delete', $todo['Systemtodo']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $todo['Systemtodo']['id']),null,null,false); ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |  <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

