<div class="meetingtodos view">
<h2><?php  __('Meetingtodo');?></h2>
<fieldset>
    <legend><?php __('To-do list');?></legend>
 		<div class="fieldset-inside">
    <ul>
    <li><span class="viewtitle"><?php __('Todo'); ?>:</span> <?php echo $meetingsTodo['Meetingtodo']['name']; ?></li>    
     <li><span class="viewtitle"><?php __('Priority'); ?>:</span> <?php echo $priorities[$meetingsTodo['Meetingtodo']['priority']];?></li>
    <li><span class="viewtitle"><?php __('User'); ?>:</span> <?php echo $meetingsTodo['User']['name']; ?></li>
    <li><span class="viewtitle"><?php __('Done'); ?>:</span> <?php $meetingsTodo['Meetingtodo']['done'] ? __('Yes',true): __('Not done'); ?></li>
    <li><span class="viewtitle"><?php __('Date Done'); ?>:</span> 
        <?php
        if ($meetingsTodo['Meetingtodo']['date_done'] == NULL) {
            echo '-';
        }else {
            echo date(Configure::read('date_format'),strtotime($meeting['Meetingtodo']['date_done'])); 
            echo '&nbsp';
            echo date(Configure::read('time_format'),strtotime($meeting['Meetingtodo']['date_done'])); 
        }
        ?>
    </li>
    </ul>
    </div>
</fieldset>
<br/>
<?php echo $form->button(__('Back', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
</div>

