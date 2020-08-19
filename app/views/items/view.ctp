<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
if(isset($allow_add_decision)):
?>
<p class='contentmenu'>
[ <?php echo $html->link(__("Add new decision",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'add','itemid'=>$item['Item']['id'])); ?> ]
</p>
<?php
endif;
?>
<?php if(isset($prev)) { ?>[ <?php echo $html->link($prev['Item']['short_name'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'items','action'=>'view','id'=>$prev['Item']['id'])); ?> ]<?php } ?>
[ <?php echo $html->link(__("View Report",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'reports','action'=>'project','id'=>$item['Item']['id']),array('target'=>'_blank')); ?> ]
<?php if(isset($next)) { ?> [ <?php echo $html->link($next['Item']['short_name'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'items','action'=>'view','id'=>$next['Item']['id'])); ?> ]<?php } ?>
<div class="items view">
<h2>
    <?php  echo ucwords($item_name);?>: <?php echo $item['Item']['name'];?>
</h2>

<div class="contentsummary">
    <ul>
    <li><span class="viewtitle"><?php __('Committee'); ?>:</span> <?php echo $item['Committee']['name'];?></li>
    <li><span class="viewtitle"><?php echo sprintf(__('%s Name',true),$item_name); ?>:</span> <?php echo $item['Item']['name'];?></li>
    <li><span class="viewtitle"><?php echo sprintf(__('%s Short Name',true),$item_name); ?>:</span> <?php echo $item['Item']['short_name']; ?></li>
    <li><span class="viewtitle"><?php __('Description'); ?>:</span> <?php echo $item['Item']['description']; ?></li>
    </ul>
</div>


<?php echo $this->element('decision_list',array('data'=>$item,'model'=>'item')); ?>

</div>
