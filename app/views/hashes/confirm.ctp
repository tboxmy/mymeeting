<div class="hashes confirm">
<h2><?php __('Confirm attendance')?></h2>
<div class="contentsummary">
    <ul>
        <li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $committee['Committee']['name']; ?></li>
        <li><span class="viewtitle"><?php __('Meeting Title'); ?>: </span><?php echo $d['Meeting']['meeting_title'];?></li>
        <li><span class="viewtitle"><?php __('Meeting No'); ?>: </span><?php echo $d['Meeting']['meeting_num'];?></li>
        <li><span class="viewtitle"><?php __('Meeting Date'); ?>: </span><?php echo date(Configure::read('date_format'),strtotime($d['Meeting']['meeting_date'])); ?>
        &nbsp;<?php echo date(Configure::read('time_format'),strtotime($d['Meeting']['meeting_date'])); ?></li>
        <li><span class="viewtitle"><?php __('Venue'); ?>: </span><?php echo $d['Meeting']['venue']; ?></li>
    </ul>

</div>
<?php echo $form->create('Hash',array('url'=>'hash/'.$hash['Hash']['hash']));?>
<fieldset>
    <legend><?php __('Confirmation to attend the above meeting');?></legend>
    <div class="fieldset-inside">
        <?php 
        __('Attendance for:');
        echo ' <span class="viewtitle">'.$title1['Title']['long_name'].' '.$d['User']['name'].'</span><br/>';
        echo "<p>&nbsp;</p>";
            
        $d['Attendance']['will_attend']=='1' && isset($d['Attendance']['will_attend']) ? $willattend=true : $willattend=false;
        strtotime($hash['Hash']['due_date']) > strtotime(date('Y-m-d H:i:s')) ? $expired=false : $expired=true;
        $d['Meeting']['allow_representative'] ? $allow_rep = 1: $allow_rep = 0;
        
        if($expired) {
            echo __("You can no longer confirm attendance. It is past due date:",true).' '.date(Configure::read('date_format'),strtotime($hash['Hash']['due_date']));
            
        } else {
            echo __("Please confirm attendance before this due date:",true).' '.date(Configure::read('date_format'),strtotime($hash['Hash']['due_date']));
        }
        echo "<p>&nbsp;</p>";
        
        if ($willattend) {
            echo "<span class='hijau'>";
            echo __("You have confirmed to attend the meeting on", true).' '.date(Configure::read('date_format'),strtotime($d['Attendance']['confirm_date']));
            echo ' '.date(Configure::read('time_format'),strtotime($d['Attendance']['confirm_date']))."<br/>";
            echo "</span>";
        } else {
            if (isset($d['Attendance']['confirm_date']) && $d['Attendance']['confirm_date']!='0000-00-00 00:00:00') {
                echo "<span class='hijau'>";
                echo __("You have confirmed NOT to attend the meeting on", true).' '.date(Configure::read('date_format'),strtotime($d['Attendance']['confirm_date']));
                echo ' '.date(Configure::read('time_format'),strtotime($d['Attendance']['confirm_date'])).'. ';
                echo "<br/>";
                if ($allow_rep) {
                    if (empty($d['Attendance']['rep_name']))
                        echo __("You have appointed no one as your representative.",true);
                    else
                        echo __("You have appointed",true).' '.$d['Attendance']['rep_name'].' '.__('as your representative.',true);
                }
                echo "<br/>";
                echo "</span>";
            } else {
                echo "<span class='merah'>";
                echo __("You have not confirmed the attendance yet.",true)."<br/>";
                echo "</span>";
            }
        }
        
        if (!$expired) {
            $options = array(1=>__('Yes, I will attend',true),0=>__('No, I will not attend (please give your reason below)',true));
            $d['Meeting']['allow_representative'] ? array_push($options,__('No, I will not attend but will send a representative on behalf<br/>(please give your excuse & your representative below)',true)) : '';
            __('Please select appropriately');
            echo ': ';
            echo $html->div('input radio',
                            $form->radio('will_attend',
                                    $options,
                                    array('label'=>'1','separator'=>'&nbsp;','value'=>$d['Attendance']['will_attend'],'legend'=>'0'))
                            );
            echo "<p>&nbsp;</p>";
            echo $form->input('excuse', array('label'=>__('Excuse',true),'size'=>'40','maxlength'=>'255','value'=>$d['Attendance']['excuse']));
            echo "<p>&nbsp;</p>";
            echo $allow_rep ? $form->input('wakil',array('type'=>'text','size'=>'40','label'=>__('Representative',true),'value'=>$d['Attendance']['rep_name'])) : '';
        }
        echo "<p>&nbsp;</p>";
        echo $allow_rep ? '' : '<span class="note">'.__('This meeting does not allow you to send representatives',true).'</span>';
        ?>
    </div>
</fieldset>
<?php if($expired): ?>
    <?php echo '<br/>'.$html->link(__('OK',true),array('controller'=>'committees','action'=>'mainpage'),array('class'=>'button'));?>
<?php else: ?>
    <?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
    <?php echo $html->link(__('Cancel',true),array('controller'=>'committees','action'=>'mainpage'),array('class'=>'button'));?>
    <?php echo $form->hidden('hash_type', array('value'=>$hash['Hash']['hash_type']));?>
    <?php echo $form->hidden('meeting_id', array('value'=>$d['Meeting']['id']));?>
    <?php echo $form->hidden('user_id', array('value'=>$d['User']['id']));?>
    <?php echo $form->hidden('allow_rep', array('value'=>$d['Meeting']['allow_representative']));?>
    <?php echo $form->end();?>
<?php endif;?>
</div>
