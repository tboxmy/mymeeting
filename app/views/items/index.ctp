<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
?>
<div class="items index">
<?php if(isset($allow_add_item)): ?>
<p class='contentmenu'>[ <?php echo $html->link(sprintf(__("Add new %s",true),$item_name),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]</p>
<?php endif; ?>
<h2><?php echo ucwords($item_name);?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
    
    <th width="3%"><?php __('No')?></th>
    <th width="20%"><?php echo $paginator->sort('short_name',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('name',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th class="actions" colspan='3'><?php __('Actions');?></th>
</tr>

<?php if (!count($items)):?>
<tr>
    <td colspan="5">No record found</td>
</tr>
<?php endif;?>

<?php
$i = 0;
foreach ($items as $item):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        
        <td><?php echo $i.'.'?></td>
        <td>
            <?php echo $html->link($item['Item']['short_name'],array('controller'=>'items','action'=>'view','id'=>$item['Item']['id'],'committee'=>$dcommittee['Committee']['short_name'])); ?>
        </td>
        <td>
            <?php echo $item['Item']['name']; ?>
        </td>
<?php 
    echo $this->element('crud',array('crudid'=>$item['Item']['id'],'permission'=>$item['auth']));
?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers(array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
    <?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
</div>

