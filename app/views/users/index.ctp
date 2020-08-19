<div class="users index">

<p class='contentmenu'>[ <?php echo $html->link(__("Add new user",true),array('action'=>'add')); ?> ]</p>
<h2><?php __('All Users');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<table cellpadding="0" cellspacing="0" width="100%">

<tr class="table_header">
    <th><?php __('No');?></th>
    <th><?php echo $paginator->sort('username');?></th>
    <th><?php echo $paginator->sort('name');?></th>
    <th class="actions"><?php __('Actions');?></th>
</tr>
<?php 

if(!count($users)) {
    echo "<tr><td colspan='4'>".__('No record found',true)."</td></tr>";
}

if($paginator->current() == '1') {
    $i = 0;
}
elseif(isset($this->params['paging'][Inflector::classify($this->params['controller'])])) {
    $i = ($paginator->current() - 1)* $this->params['paging'][Inflector::classify($this->params['controller'])]['options']['limit'];
}
else{
    $i=0;
}

foreach ($users as $user):
    $class = null;
if ($i++ % 2 == 0) {
    $class = ' class="table_info"';
}
?>
    <tr<?php echo $class;?>>
        <td>
            <?php echo $i.'. '; ?>
        </td>
        <td>
            <?php echo $user['User']['username']; ?>
        </td>
        <td>
            <?php echo ($user['Title']['long_name'] && array_key_exists('Title',$user)) ? $user['Title']['long_name']:'&nbsp;'; ?> 
            <?php echo $user['User']['name'] ?  $user['User']['name']: "&nbsp;"; ?>
        </td>
        <td class="actions">
            <?php echo $html->link($html->image('icons/view.gif',array('alt'=>__('View User',true),'title'=>__('View User',true))), array('action'=>'view', $user['User']['id']),null,null,false); ?>
            <?php echo $html->link($html->image('icons/edit.gif',array('alt'=>__('Edit User',true),'title'=>__('Edit User',true))), array('action'=>'edit', $user['User']['id']),null,null,false); ?>
            <?php echo $html->link($html->image('icons/delete.gif',array('alt'=>__('Delete User',true),'title'=>__('Delete User',true))), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete %s?', true), $user['User']['username']),false); ?>
            <?php echo $html->link($html->image('icons/icon_reset.jpg',array('alt'=>__('Reset Password',true),'title'=>__('Reset Password',true))), array('action'=>'resetpass', $user['User']['id']),null,sprintf(__('Are you sure you want to reset password for %s?', true).'\n'.__("Password will be reset to the username.",true),$user['User']['username']),false); ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
<?php if(isset($dcommittee)) { ?>
    <?php echo $paginator->prev('<< '.__('previous', true), array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers(array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
    <?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
<?php } else { ?>
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers(array());?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
<?php } ?>
</div>
