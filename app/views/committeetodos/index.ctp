<div class="committeesTodos index">

<?php if(isset($allow_add_todos)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new To-do for",true).' '.$this->params['committee'],array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]</p>
<?php endif; ?>

<h2><?php __("Committee's To-do's");?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th width='3%'><?php __('No');?></th>
    <th><?php echo $paginator->sort('task',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('priority',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort(__('Assigned to',true),'user',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th class="actions" colspan='3'><?php __('Actions');?></th>
</tr>
<?php
if(!count($committeesTodos)) 
    echo "<tr><td colspan='5'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Committeetodo']['options']['limit'] - $this->params['paging']['Committeetodo']['options']['limit']; 

foreach ($committeesTodos as $committeesTodo):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        <td>
            <?php echo $i.'. ';?>
        </td>
        <td>
            <?php echo $committeesTodo['Committeetodo']['name']; ?>
        </td>
        <td>
            <?php echo $priorities[$committeesTodo['Committeetodo']['priority']]; ?>
        </td>
        <td>
            <?php echo $committeesTodo['User']['name']; ?>
        </td>
        <?php echo $this->element('crud',array('crudid'=>$committeesTodo['Committeetodo']['id'],'permission'=>$committeesTodo['auth'])); ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true),array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
 |  <?php echo $paginator->numbers(array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
    <?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
</div>

