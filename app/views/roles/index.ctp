<div class="roles index">
<?php if(isset($allow_add_roles)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new role",true), array('action'=>'add')); ?> ]</p>
<?php endif; ?>
<h2><?php __('Roles');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No')?></th>
    <th><?php echo $paginator->sort('name');?></th>
    <th class="actions"><?php __('Actions');?></th>
</tr>

<?php
if(!count($roles)) 
    echo "<tr><td colspan='3'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Role']['options']['limit'] - $this->params['paging']['Role']['options']['limit']; 

foreach ($roles as $role):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr <?php echo $class;?>>
        <td>
            <?php echo $i.'. '; ?>
        </td>
        <td>
            <?php echo $role['Role']['name']; ?>
        </td>
        <td class="actions">
            <?php //echo $html->link($html->image('icons/view.gif',array('alt'=>'View Item','title'=>'View Item')), array('action'=>'view', $role['Role']['id']),null,null,false); ?>
            <?php echo $html->link($html->image('icons/edit.gif',array('alt'=>'Edit Item','title'=>'Edit Item')), array('action'=>'edit', $role['Role']['id']),null,null,false); ?>
            <?php echo $html->link($html->image('icons/delete.gif',array('alt'=>'Delete Item','title'=>'Delete Item')), array('action'=>'delete', $role['Role']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $role['Role']['id']),null,null,false); ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>

<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

