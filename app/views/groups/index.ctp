<div class="groups index">
<p class='contentmenu'>[ <?php echo $html->link(__("Add new group",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]</P>
<h2><?php __('Groups');?></h2>
<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th width="3%"><?php __('No')?></th>
    <th><?php echo $paginator->sort('name');?></th>
    <th class="actions" colspan=3><?php __('Actions');?></th>
</tr>
<?php
if(!count($groups)) 
    echo "<tr><td colspan='5'>".__('No record found',true)."</td></tr>";

if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Group']['options']['limit'] - $this->params['paging']['Group']['options']['limit']; 

foreach ($groups as $group):
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
            <?php echo $group['Group']['name']; ?>
        </td>
        <?php echo $this->element('crud',array('crudid'=>$group['Group']['id'],'permission'=>$group['auth'])) ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
</div>

