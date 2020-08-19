<p class='contentmenu'>
<?php if(isset($prev)) { ?>[ <?php echo $html->link($prev['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view','id'=>$prev['Meeting']['id'])); ?> ]<?php } ?>
<?php if(isset($can_view_attendance) && $can_view_attendance) { ?> [ <?php echo $html->link(__('Attendance',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'attendance','id'=>$meeting['Meeting']['id'])); ?> ] <?php } ?>
<?php if(isset($can_view_todo) && $can_view_todo) { ?> [ <?php echo $html->link(__('Todo',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'todo','id'=>$meeting['Meeting']['id'])); ?> ] <?php } ?>
<?php if(isset($allow_add_decision)): ?>
[ <?php echo $html->link(__("Add new decision",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'add','meetingid'=>$meeting['Meeting']['id'])); ?> ]
[ <?php 
if(strlen($meeting['Meeting']['minutes_raw'])==0) {
    echo $html->link(__("Add minutes",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'addminutes','meetingid'=>$meeting['Meeting']['id']));
}
else{
    echo $html->link(__("Edit minutes",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'editminutes','meetingid'=>$meeting['Meeting']['id']));
}
?> ]
[ <?php echo $html->link(__("Announce Decisions",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'announcedecisions','meetingid'=>$meeting['Meeting']['id']),null,__('Are you sure you want to announce all of the decisions?', true)); ?> ]
<?php endif; ?>
[ <?php echo $html->link(__('View Minutes', true), array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'minutes',$meeting['Meeting']['id']), array('target'=>'_blank')); ?> ]
[ <?php echo $html->link(__("View Report",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'reports','action'=>'meeting','id'=>$meeting['Meeting']['id']),array('target'=>'_blank')); ?> ]


<?php if(isset($next)) { ?> [ <?php echo $html->link($next['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view','id'=>$next['Meeting']['id'])); ?> ]<?php } ?>
</p>
<div class="meetings view">
<h2>
<?php  __('Meeting');?> <?php echo $meeting['Meeting']['meeting_title'].' '.$meeting['Meeting']['meeting_num'];?>
</h2>

<table cellspacing='0' cellpadding='0' border='0' id="noborder">
<tr>
    <td class="leftcolumn">
        <div class="contentsummary">
        <ul>
            <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $meeting['Committee']['name']; ?></li>
            <li><span class="viewtitle"><?php __('Meeting Title'); ?>: </span><?php echo $meeting['Meeting']['meeting_title'];?></li>
            <li><span class="viewtitle"><?php __('Meeting No'); ?>: </span><?php echo $meeting['Meeting']['meeting_num'];?></li>
            <li><span class="viewtitle"><?php __('Meeting Date'); ?>: </span><?php echo date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>
            &nbsp;<?php echo date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date'])); ?></li>
            <li><span class="viewtitle"><?php __('Venue'); ?>: </span><?php echo $meeting['Meeting']['venue']; ?></li>
        </ul>
        </div>

        <?php echo $this->element('decision_list',array('model'=>'meeting','permission'=>$meeting['auth'])) ?>
    </td>
    <td class="rightcolumn">
    
        <?php if(isset($meeting['MultiFile'])) { ?>
        <fieldset id="dfiles">
        <legend><?php __('Files for this meeting');?></legend>
        <div class="fieldset-inside">
        <?php
            if(isset($meeting['MultiFile']['agenda'])){
                echo $this->element('multifile',array('multifiles'=>$meeting['MultiFile']['agenda'],'title'=>'Agenda'));
            }
            if(isset($meeting['MultiFile']['minutes'])){
                echo $this->element('multifile',array('multifiles'=>$meeting['MultiFile']['minutes'],'title'=>'Minutes'));
            }
            if(isset($meeting['MultiFile']['presentations'])){
                echo $this->element('multifile',array('multifiles'=>$meeting['MultiFile']['presentations'],'title'=>'Presentations'));
            }
        ?>
        </div>
        </fieldset>
        <?php } ?>

        <fieldset>
        <legend><?php __('Comments for this meeting');?>
        <?php echo $comment->no_of_comments('Meeting',$meeting)? ': '.$comment->no_of_comments('Meeting',$meeting) : '' ?>    
        </legend>
        <div class="fieldset-inside">
        <?php echo $comment->disp_comment('Meeting',$meeting) ?>
        </div>
        </fieldset>
        
    </td>
</tr>
</table>



</div>

