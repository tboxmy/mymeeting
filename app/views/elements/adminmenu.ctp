<div id="adminmenu">
<ul>
<?php 
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
$menuitems=array(array('title'=>$dcommittee['Committee']['name'],'menu'=>'committees','action'=>'alert'),array('title'=>$item_name,'menu'=>'items'),'meetings',array('title'=>'Address Book','menu'=>'memberships'),array('title'=>'Files Archive','menu'=>'attachments'),array('title'=>__('Search',true),'menu'=>'committees','action'=>'search'));

foreach($menuitems as $menu):
    if(is_array($menu)){
        if (!empty($menu['action'])) $action = $menu['action'];
        else $action = 'index';
        $title=$menu['title'];
        $menu=$menu['menu'];
    }
    else{
        $title=ucwords($menu);
        $action = 'index';
    }
if($this->params['controller']==$menu && $this->params['action']==$action): ?>
<li><?php echo $html->link(__($title,true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>$menu,'action'=>$action),array('id'=>'current'))?></li>
<?php else: ?>
<li><?php echo $html->link(__($title,true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>$menu,'action'=>$action))?></li>
<?php endif;
endforeach;
?>
</ul>
</div>
