<?php 
__('Meetingtodos',true); //for translation
?>
<div class="meetingtodos index">

<?php if(isset($allow_add_meetingtodo)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new Meeting Todo",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add','controller'=>'meetingtodos','id'=>$meeting['Meeting']['id'])); ?> ]</p>
<?php endif; ?>

<h2><?php __("Meeting's To-do List");?></h2>

<div class="contentsummary">
<ul>
<li><span class="viewtitle"><?php __('Meeting title') ?> : </span><?php echo $meeting['Meeting']['meeting_title'];?></li>
<li><span class="viewtitle"><?php __('Meeting no') ?> : </span><?php echo $html->link($meeting['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view','id'=>$meeting['Meeting']['id']));?></li>
<li><span class="viewtitle"><?php __('Meeting date') ?> : </span>
<?php
    echo date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date'])); 
    echo '&nbsp';
    echo date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date'])); 
?></li>
<li><span class="viewtitle"><?php __('Venue') ?> : </span><?php echo $meeting['Meeting']['venue']; ?></li>
</ul>
</div>
<fieldset>
    <legend><?php __('To-do list');?></legend>
    <div class="fieldset-inside">
        <?php
        echo $form->create('Meetingtodo',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'todo','id'=>$meeting['Meeting']['id'])));
        ?>
        <p class='note'>
        <?php __('This is the todo list for this meeting.') ?> </p><br>

        <table cellpadding='0' cellspacing='0' width='70%'>
        <tr><th width='3%'><?php __('No')?></th><th width='30%'><?php __('Task')?></th><th width='3%'><?php __('Done')?></th><th><?php __('Done by')?></th><th><?php __('Date done')?></th><th colspan='3'><?php __('Actions')?></th></tr>
        <?php
        if (!count($todos)) echo "<td colspan ='5'>".__('No record found',true)."</td>";
        
        $i=0;$j=1;
        foreach($todos as $tddata){
            echo "<tr>";
            echo "<td>".$j++.". </td>";
            echo "<td>".$tddata['Meetingtodo']['name'];
            echo $form->hidden('Meetingtodo.'.$i.'.id',array('value'=>$tddata['Meetingtodo']['id']));
            echo "</td>";
            if($tddata['Meetingtodo']['done']){
                $done=true;
            }
            else{
                $done=false;
            }
            echo "<td>".$form->checkbox('Meetingtodo.'.$i.'.done',array('checked'=>$done,'class'=>'noborder'))."</td>";
            if($done){
                echo "<td>".$tddata['User']['name']."</td>";
                echo "<td>".$tddata['Meetingtodo']['date_done']."</td>";
            }
            else{
                echo "<td>".$tddata['User']['name']."</td>";
                echo "<td>".__('Not done',true)."</td>";
            }
            echo $this->element('crud',array('crudid'=>$tddata['Meetingtodo']['id'],'permission'=>$tddata['auth']));
            
            $i++;
        }
        ?>
        </table>
</fieldset>
<br/>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
