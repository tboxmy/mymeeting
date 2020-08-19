<div class="meetings view">
<h2 class="minutetitle"><?php  __('Report for Meeting');?></h2>
<h2 class="minutetitle"><?php echo __('')?></span><?php echo $meeting['Meeting']['meeting_title'];
echo __(', ')?></span><?php echo $meeting['Meeting']['meeting_num'];?>
</h2><br/>

    <table cellpadding="0" cellspacing="0">
    <tr>
    <th width=70%><?php echo __('Decision');?></th>
    <th width=30%><?php echo __('Status');?></th>
    </tr>
<?php if (count($decisions)){
    $i = 0;
    foreach ($decisions as $decision){
        $class='decisionrow';
        if ($i++ % 2 == 0) {
            $class .= ' altrow';
        }
?>
    <tr class="<?php echo $class;?>">          
        <td>
<?php echo $decision['Decision']['description'] ?>
<?php if($decision['Decision']['deadline']>'0000-00-00'){
    echo "<span class=\"deadline\">".sprintf(__('Deadline : %s',true),date(Configure::read('date_format'),strtotime($decision['Decision']['deadline'])))."</span>";
}
?>
        </td>            
         <td><!-- display user status-->
       <!-- display individual implementer-->

    <?php if (count($decision['User'])){?>
     <b><?php echo __('Individual Implementor')?>:</b>
<ul>
        <?php foreach ($decision['User'] as $users){?>
            <li><?php echo $users['name']; ?></li>
<?php
$done=false;
foreach($decision['Userstatus'] as $userstatus ){
    if($userstatus['user_id']==$users['id']){
        echo "<ul>";
        echo "<li>";
        echo __('Status : '); 
        echo $userstatus['description']."<br>";
        if(isset($userstatusfiles)){
            echo "<br>".__('Files Uploaded : ');     
            foreach($userstatusfiles as $userstatusfile){
                if ($userstatus['description'] == $userstatusfile['Userstatus']['description']){
                    echo $html->link($userstatusfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'userstatuses','action'=>'attachment','id'=>$userstatusfile['Attachment']['id']))."<br>";          }               
            }
        }
        echo "</li>";
        echo "</ul>";
        $done=true;
    }
}
if(!$done){
    echo "<ul>";
    echo "<li>";
    echo __('No status update yet',true);
    echo "</li>";
    echo "</ul>";
}
?>
        <?php }?>
</ul>
    <?php }?>

      <!-- display Group implementer-->
    <?php if (count($decision['Group'])){?>
     <b><?php echo __('Group Implementor')?>:</b> 
<ul>
        <?php foreach ($decision['Group'] as $gusers){?>
            <li><?php echo $gusers['name'];  ?></li>

<?php
$done=false;
foreach($decision['Groupstatus'] as $groupstatus ){
    if($groupstatus['group_id']==$gusers['id']){
        echo "<ul>";
        echo "<li>";
        echo __('Status : '); 
        echo $groupstatus['description']."<br>";
        if(isset($groupstatusfiles)){
            echo "<br>".__('Files Uploaded : ');     
            foreach($groupstatusfiles as $groupstatusfile){
                if ($groupstatus['description'] == $groupstatusfile['Groupstatus']['description']){
                    echo $html->link($userstatusfile['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'groupstatuses','action'=>'attachment','id'=>$groupstatusfile['Attachment']['id']))."<br>";          }               
            }
        }
        echo "</li>";
        echo "</ul>";
        $done=true;
    }
    if(!$done){
        echo "<ul>";
        echo "<li>";
        echo __('No status update yet',true);
        echo "</li>";
        echo "</ul>";
    }
}
        }
    }?>
</ul>
    </td>
        </tr>
       <?php }?>
          <?php }?>
         </table>  
