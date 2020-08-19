<?php
if(isset($javascript)):
    // load script in <head> section
    $javascript->link('scriptaculous/lib/prototype', false);
    $javascript->link('scriptaculous/src/scriptaculous', false);
    $javascript->link('modalbox/modalbox', false);
    echo $html->css('modalbox');
endif;
__('Decisions',true); //for translation
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? __($dcommittee['Committee']['item_name'],true) : __('Project',true);
?>
<p class='contentmenu'>
<?php if(isset($allow_add_user_status)) :?>
[ <?php echo $html->link(__("Add new User status",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'Userstatuses','action'=>'add','decisionid'=>$decision['Decision']['id'])); ?> ]
<?php endif; ?>
<?php foreach($decision['User'] as $user) :
if(isset(${'allow_add_user_status_'.$user['id']})) :?>
[ <?php echo $html->link(sprintf(__("Add new %s user status ",true),$user['name']),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'Userstatuses','action'=>'add','decisionid'=>$decision['Decision']['id'],'user_id'=>$user['id'])); ?> ]
<?php endif; endforeach;?>
<?php foreach($decision['Group'] as $group) :
if(isset(${'allow_add_group_status_'.$group['id']})) :?>
[ <?php echo $html->link(sprintf(__("Add new %s group status ",true),$group['name']),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'Groupstatuses','action'=>'add','decisionid'=>$decision['Decision']['id'],'group_id'=>$group['id'])); ?> ]
<?php endif; endforeach;?>
</p>
<div class="decisions view">
<h2 class="double"><?php  __('Decision');?><br/><?php echo __('Meeting').' '.$decision['Meeting']['meeting_title'].' '.$decision['Meeting']['meeting_num']?></h2>

<table cellspacing='0' cellpadding='0' border='0' id="noborder">
<tr>
    <td class="leftcolumn">
        <div class="contentsummary">
        <ul>
            <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $decision['Committee']['name']; ?></li>
            <li><span class="viewtitle"><?php __('Meeting Title'); ?>: </span><?php echo $decision['Meeting']['meeting_title'];?></li>
            <li><span class="viewtitle"><?php __('Meeting No');?>:</span> <?php echo $html->link(strlen($decision['Meeting']['meeting_num'])?$decision['Meeting']['meeting_num']:$decision['Meeting']['meeting_title'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view',$decision['Meeting']['id']));?></li>
            <li><span class="viewtitle"><?php __('Venue'); ?>: </span><?php echo $decision['Meeting']['venue']; ?></li>
            <li><span class="viewtitle"><?php __('Meeting Date'); ?>: </span><?php echo date(Configure::read('date_format'),strtotime($decision['Meeting']['meeting_date'])); ?>
            &nbsp;<?php echo date(Configure::read('time_format'),strtotime($decision['Meeting']['meeting_date'])); ?></li>
            
        </ul>
        </div>
        
        <fieldset id="decision">
            <legend><?php __('Decision'); ?></legend>
            <div class="fieldset-inside">
            <span class="viewtitle"><?php echo ucwords($item_name);?>:</span> <?php echo $html->link($decision['Item']['short_name'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'items','action'=>'view',$decision['Item']['id']));?><br/>
            <span class="viewtitle"><?php __('Deadline');?>:</span> <?php echo date(Configure::read('date_format',strtotime($decision['Decision']['deadline'])));?><br/>
            <span class="viewtitle"><?php __('Description');?>:</span>
            
            <?php echo $html->div('decision_text',$decision['Decision']['description']);?>
            
            <?php
            if(count($decision['User'])):
            ?>
                <span class="viewtitle"><?php __('Individual Implementor');?>:</span> <?php echo "<ul>"; foreach($decision['User'] as $user) echo "<li>".$user['name']."</li>"; echo "</ul>"; ?>
            <?php
            endif;
            if(count($decision['Group'])):
            ?>
                <span class="viewtitle"><?php __('Group Implementor');?>:</span> <?php echo "<ul>"; foreach($decision['Group'] as $group) echo "<li>".$group['name']."</li>"; echo "</ul>"; ?>
            <?php
            endif;
            ?>
            
            </div>
        </fieldset>
    </td>
    <td class="rightcolumn">
        
        <?php if(isset($decision['MultiFile'])){?>
        <fieldset id="dfiles">
        <legend><?php __('Files for this decision');?></legend>
            <div class="fieldset-inside">
        <?php
            if(isset($decision['MultiFile']['additionalfiles'])){
                echo $this->element('multifile',array('multifiles'=>$decision['MultiFile']['additionalfiles']));
            }
        ?>
            </div>
        </fieldset>
        <?php
        }
        ?>
        
        <a name="comments"></a>
        <fieldset>
            <legend><?php __('Comments for this decision'); ?></legend>
            <div class="fieldset-inside">
            <?php
            echo $comment->disp_comment('Decision',$decision);
            ?>
            </div>
        </fieldset>
    </td>
</tr>
</table>


<a name="status"></a>
<span class="viewtitle"><?php __('List of status')?></span>
<?php $i=0?>
<table cellpadding='0' cellspacing='0' border='0' id="statuses">
    <tr>
        <th width="10%"><?php __('Implementor')?></th>
        <th width="50%"><?php __('Status')?></th>
        <th width="10%"><?php __('Action Date')?></th>
        <th width="25%"><?php __('Comments')?></th>
        <th width="5%"><?php __('History')?></th>
    </tr>
    <?php if(!count($decision['User']) && !count($decision['Group'])):?>
    <tr><td colspan='5'><?php __('Decision has not assigned to anyone')?></td></tr>
    <?php endif;?>
    
    <?php 
    //================USER========================
    $user_with_status = array_unique(Set::extract('/user_id',$decision['Userstatus']));
    foreach ($decision['User'] as $key=>$user) {
        if (in_array($user['id'],$user_with_status)) unset($decision['User'][$key]);
    } 
    ?>
    
    <?php foreach($decision['Userstatus'] as $status): ?>
    <?
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
    <tr<?php echo $class;?>>
        <td><?php echo "<a name=\"user".$status['id']."\"></a>";?><?php echo $status['User']['name']?></td>
        <td><?php echo nl2br($status['description'])?><br/>
        <?php
            if(isset($status['MultiFile']['additionalfiles'])) {
                echo "<span class='bold'>".__('Additional Files',true).": </span>"; 
                echo $this->element('multifile',array('multifiles'=>$status['MultiFile']['additionalfiles']));
            }
        ?>
        </td>
        <td><?php echo date(Configure::read('date_format'),strtotime($status['action_date']));?></td>
        <td>
        <?php if(isset($javascript)):?>
        [ <a href="#" onclick="Effect.SlideDown('<?php echo 'formUser'.$status['id']?>'); return false;"><?php __('Leave comment')?></a> ] &nbsp;
        [ <a href="#" onclick="$('<?php echo 'formUser'.$status['id']?>').hide(); return false;"><?php __('Cancel')?></a> ]
        <?php 
            echo "<div id=formUser".$status['id']." style='display:none'>".$comment->add_form('Userstatus',$status).'</div><br/>';
            echo $comment->list_comment('Userstatus',$status);
         ?>
        <?php else:?>
        <?php 
            echo "<div>".$comment->add_form('Userstatus',$status).'</div><br/>';
            echo $comment->list_comment('Userstatus',$status);
         ?>
        <?php endif;?>
        </td>
        <td>
        <?php 
            $historycount = 0;
            foreach ($user_history_status as $history) {
                if ($status['User']['id'] == $history['Userstatus']['user_id']) $historycount++;
            }
            echo $historycount.' &nbsp; [';
            echo $html->link(__('View',true),
                array('controller'=>'userstatuses','action'=>'view_history','committee'=>$dcommittee['Committee']['short_name'],'decisionid'=>$decision['Decision']['id'],'id'=>$status['user_id']),
                array('onclick'=>'Modalbox.show(this.href, {title:this.title,width:800});return false;','Title'=>__('View history',true))
                );
            echo ']';
        ?>
        </td>
    </tr>
    <?php endforeach;?>
    <?php foreach($decision['User'] as $user): ?>
    <?
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
    <tr<?php echo $class;?>>
        <td><?php echo $user['name']?></td>
        <td><span class="merah"><?php __('Has not submitted status yet')?></span></td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <?php endforeach;?>
    
    
    
    <?php //debug($decision['Groupstatus']);
    //================GROUP========================
    $group_with_status = array_unique(Set::extract('/group_id',$decision['Groupstatus']));
    foreach ($decision['Group'] as $key=>$group) {
        if (in_array($group['id'],$group_with_status)) unset($decision['Group'][$key]);
    }
    ?>
    
    <?php foreach($decision['Groupstatus'] as $status): ?>
    <?
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
    <tr<?php echo $class;?>>
        <td><?php echo "<a name=\"user".$status['id']."\"></a>";?><?php echo $status['Group']['name']?>
        </td>
        <td>
        <?php
            echo nl2br($status['description']).'<br/>';
            if(isset($status['MultiFile']['additionalfiles'])) {
                echo "<span class='bold'>".__('Additional Files',true).": </span>"; 
                echo $this->element('multifile',array('multifiles'=>$status['MultiFile']['additionalfiles']));
            }
        ?>
        </td>
        <td><?php echo date(Configure::read('date_format'),strtotime($status['action_date']));?></td>
        <td>
        <?php if(isset($javascript)):?>
        [ <a href="#" onclick="Effect.SlideDown('<?php echo 'formGroup'.$status['id']?>'); return false;"><?php __('Leave comment')?></a> ] &nbsp;
        [ <a href="#" onclick="$('<?php echo 'formGroup'.$status['id']?>').hide(); return false;"><?php __('Cancel')?></a> ]
        <?php 
            echo "<div id=formGroup".$status['id']." style='display:none'>".$comment->add_form('Groupstatus',$status).'</div><br/>';
            echo $comment->list_comment('Groupstatus',$status);
         ?>
        <?php else:?>
        <?php 
            echo "<div>".$comment->add_form('Groupstatus',$status).'</div><br/>';
            echo $comment->list_comment('Groupstatus',$status);
         ?>
        <?php endif;?>
        </td>
        <td>
        <?php 
            $historycount = 0;
            foreach ($group_with_status as $history) {
                if ($status['Group']['id'] == $history) $historycount++;
            }
            echo $historycount.' &nbsp; [';
            echo $html->link(__('View',true),
                array('controller'=>'groupstatuses','action'=>'view_history','committee'=>$dcommittee['Committee']['short_name'],'decisionid'=>$decision['Decision']['id'],'id'=>$status['group_id']),
                array('onclick'=>'Modalbox.show(this.href, {title:this.title,width:800});return false;','Title'=>__('View history',true))
                );
            echo ']';
        ?>
        </td>
    </tr>
    <?php endforeach;?>
    <?php foreach($decision['Group'] as $group): ?>
    <?
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}?>
    <tr<?php echo $class;?>>
        <td><?php echo $group['name']?></td>
        <td><span class="merah"><?php __('Has not submitted status yet')?></span></td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <?php endforeach;?>
</table>
</div>
