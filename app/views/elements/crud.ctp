<td class="actions" width="3%">
<?php
if($auth_user['User']['superuser']||(isset($permission['view']) && $permission['view'])){
      echo $html->link($html->image('icons/view.gif',array('alt'=>__('View item',true),'title'=>__('View item',true))),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'view','id'=>$crudid),null,null,false);
}
else{
    echo "&nbsp;";
}
?>
</td>
<td class="actions" width="3%">
<?php
if($auth_user['User']['superuser']||(isset($permission['edit']) && $permission['edit'])){
    echo  $html->link($html->image('icons/edit.gif',array('alt'=>__('Edit item',true),'title'=>__('Edit item',true))),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'edit','id'=>$crudid),null,null,false);
}
else{
    echo "&nbsp;";
}
?>
</td>
<td class="actions" width="3%">
<?php
if($auth_user['User']['superuser']||(isset($permission['delete']) && $permission['delete'])){
  echo $html->link($html->image('icons/delete.gif', array('alt'=>__('Delete item',true),'title'=>__('Delete item',true))),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'delete','id'=>$crudid), null,sprintf(__('Are you sure you want to delete this item?', true), $crudid),false);
}
else{
    echo "&nbsp;";
}
?>
</td>
