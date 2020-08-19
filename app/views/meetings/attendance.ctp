<h2><?php __('Attendance');?></h2>


<ul>
<li><span class="viewtitle"><?php __('Committee'); ?>: </span><?php echo $meeting['Committee']['name']; ?></li>
<li><span class="viewtitle"><?php __('Meeting Title') ?> : </span><?php echo $meeting['Meeting']['meeting_title'];?></li>
<li><span class="viewtitle"><?php __('Meeting No') ?> : </span><?php echo $html->link($meeting['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view','id'=>$meeting['Meeting']['id']));?></li>
<li><span class="viewtitle"><?php __('Meeting Date'); ?>: </span><?php echo date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>
        &nbsp;<?php echo date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date'])); ?></li>
<li><span class="viewtitle"><?php __('Venue') ?> : </span><?php echo $meeting['Meeting']['venue']; ?></li>
</ul>

<?php echo $form->create('Attendance',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'attendance','id'=>$meeting['Meeting']['id'])));?>

    <fieldset>
        <legend><?php __('Take Attendance');?></legend>

<div class='fieldset-inside'>
    <p class='note'>
    <?php __('List of members invited for this meeting. Members who have confirmed their attendance will be shown below.') ?> 
    <?php __('You can also update their attendance on their behalf here.')?>
    <br/>
    <?php if (!$meeting['Meeting']['allow_representative']) echo __("This meeting does not allow members to send representatives",true);?>
    </p><br>

    <table cellpadding='0' cellspacing='0' width='70%'>
        <tr>
            <th><?php __('No') ?></th>
            <th width='20%'><?php __('Name') ?></th>
            <th colspan='2'><?php __('Confirmed Attendance') ?></th>
            <th colspan='2'><?php __('Attendance') ?></th>
            <th><?php __('Reason') ?></th>
            <th><?php __('Representative') ?></th>
        </tr>
        <tr class='header'>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th width="10%"><?php __('Will attend')?></th>
            <th><?php __('Confirmed on')?></th>
            <th width="10%"><?php __('Attended')?></th>
            <th><?php __('Date updated')?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <?php if (!count($invitees)): ?>
            <tr>
                <td colspan='6'><?php __('No records found') ?></td>
            </tr>
        <?php endif; ?>

        <?php 
        $i=0; 
        foreach ($invitees as $invitee) {
        ?>
        <tr>
            <td><?php echo ++$i.'. ' ?> </td>
            <td><?php echo $invitee['User']['name'] ?> </td>
            <?php
            // confirmation
            if ($invitee['Attendance']['confirm_date']!='0000-00-00 00:00:00' && $invitee['Attendance']['confirm_date']!=null) {
                $confirm_date = date(Configure::read('date_format'),strtotime($invitee['Attendance']['confirm_date'])).' '.date(Configure::read('time_format'),strtotime($invitee['Attendance']['confirm_date']));
                $has_confirmed=true;
                if($invitee['Attendance']['will_attend'] == '1') $will_attend=true;
                else $will_attend=false;
            } else { $has_confirmed=false; }
            if ($has_confirmed) {
            ?>
            <td><?php 
            echo $html->div('input radio incell',
                            $form->radio('Attendance.'.$invitee['User']['id'].'.will_attend',
                                    array(1=>__('Y',true),0=>__('N',true)),
                                    array('label'=>'1','separator'=>'&nbsp;','value'=>$will_attend,'legend'=>'0','class'=>'noborder'))
                            ); ?></td>
            <td><?php echo $confirm_date?></td>
            <?php
            } else {
            ?>
            <td><?php
            echo $html->div('input radio incell',
                            $form->radio('Attendance.'.$invitee['User']['id'].'.will_attend',
                                    array(1=>__('Y',true),0=>__('N',true)),
                                    array('label'=>'1','separator'=>'&nbsp;','legend'=>'0','class'=>'noborder'))
                            ); ?></td>
            <td><?php echo '-'?></td>
            <?php
            }
            // attendance
            if ($invitee['Attendance']['att_updated']!='0000-00-00 00:00:00' && $invitee['Attendance']['att_updated']!=null) {
                $att_updated = date(Configure::read('date_format'),strtotime($invitee['Attendance']['att_updated'])).' '.date(Configure::read('time_format'),strtotime($invitee['Attendance']['att_updated']));
                $has_attended=true;
                if($invitee['Attendance']['attended'] == '1') $attended=true;
                else $attended=false;
            } else { $has_attended=false; }
            if ($has_attended) {
            ?>
            <td><?php
            echo $html->div('input radio incell',
                            $form->radio('Attendance.'.$invitee['User']['id'].'.attended',
                                    array(1=>__('Y',true),0=>__('N',true)),
                                    array('label'=>'1','separator'=>'&nbsp;','value'=>$attended,'legend'=>'0','class'=>'noborder'))
                            ); ?></td>
            <td><?php echo $att_updated ?></td>
            <?php    
            } else {
            ?>
            <td><?php
            echo $html->div('input radio incell',
                            $form->radio('Attendance.'.$invitee['User']['id'].'.attended',
                                    array(1=>__('Y',true),0=>__('N',true)),
                                    array('label'=>'1','separator'=>'&nbsp;','legend'=>'0','class'=>'noborder'))
                            ); ?></td>
            <td><?php echo '-' ?></td>
            <?php
            }
            ?>
            <td><?php echo $form->text('Attendance.'.$invitee['User']['id'].'.excuse', array('value'=>$invitee['Attendance']['excuse'])) ?></td>
            <td><?php 
            if ($meeting['Meeting']['allow_representative']) 
                echo $form->text('Attendance.'.$invitee['User']['id'].'.rep_name', array('value'=>$invitee['Attendance']['rep_name']));
            else echo '-';
                ?></td>
            <?php echo $form->hidden('Attendance.'.$invitee['User']['id'].'.id',array('value'=>$invitee['Attendance']['id']))?>
        </tr>
        <?php } ?>
        <?php echo $form->hidden('Meeting.allow_rep',array('value'=>$invitees[0]['Meeting']['allow_representative']))?>
        <?php echo $form->hidden('Meeting.id',array('value'=>$invitees[0]['Meeting']['id']))?>
    </table>

</div>
</fieldset>
<br/>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
