<div class="templates index">
<p class='contentmenu'> 

<h2><?php __('Messages');?></h2>
<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No');?></th>
    <th><?php echo $paginator->sort(__('Type',true),'type');?></th>
    <th><?php echo $paginator->sort(__('Message Title',true),'title');?></th>
    <th><?php echo $paginator->sort('description');?></th>
    <th><?php echo $paginator->sort('message');?></th>
    <th class="actions"><?php __('Actions');?></th>
</tr>

<?php if (!count($templates)): ?>
<tr>
    <td colspan='4'><?php __('No record found')?></td>
</tr>
<?php endif; ?>

<?php
if($paginator->current() == '1') $i = 0;
else $i = $paginator->current() * $this->params['paging']['Template']['options']['limit'] - $this->params['paging']['Template']['options']['limit']; 

foreach ($templates as $template):
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
            <?php echo $template['Template']['type']; ?>
        </td>
        <td>
            <?php echo $template['Template']['title']; ?>
        </td>
        <td>
            <?php echo $template['Template']['description']; ?>
        </td>
        <td>
            <?php echo $template['Template']['template']; ?>
        </td>
<td class="actions">
<?php
if(isset($template['auth'])){
    $permission=$template['auth'];
}
if($auth_user['User']['superuser']||(isset($permission['view']) && $permission['view'])){
    $link=array('controller'=>'templates','action'=>'view','id'=>$template['Template']['id']);
    if(isset($dcommittee)){
        $link=array_merge($link,array('committee'=>$dcommittee['Committee']['short_name']));
    }
    echo $html->link($html->image('icons/view.gif',array('alt'=>__('View',true),'title'=>__('View',true))),$link,null,null,false);
}
else{
    echo "&nbsp;";
}
?>
<?php
if($auth_user['User']['superuser']||(isset($permission['view']) && $permission['view'])){
    $link=array('controller'=>'templates','action'=>'edit','id'=>$template['Template']['id']);
    if(isset($dcommittee)){
        $link=array_merge($link,array('committee'=>$dcommittee['Committee']['short_name']));
    }
    echo $html->link($html->image('icons/edit.gif',array('alt'=>__('Edit',true),'title'=>__('Edit',true))),$link,null,null,false);
}
else{
    echo "&nbsp;";
}
?>
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

