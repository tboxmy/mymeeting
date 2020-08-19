<div class="meetings index">
<?php if(isset($allow_add_meeting)): ?>
[ <?php echo $html->link(__("Add follow-up meeting",true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'addfollowup','meetingid'=>$meetingid['Meeting']['id'])); ?> ]
<?php endif; ?>
<h2><?php __('Follow-up Meetings for :'); echo $meetingid['Meeting']['meeting_num'];?></h2>

<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No')?></th>
    <th><?php echo $paginator->sort('meeting_title');?></th>
    <th><?php echo $paginator->sort('meeting_num');?></th>
    <th><?php echo $paginator->sort('meeting_date');?></th>
    <th><?php echo $paginator->sort('venue');?></th>
    <th class="actions" colspan='7'><?php __('Actions');?></th>
</tr>

<?php if (!count($meetings)) : ?>
<tr>
    <td colspan="12">No record found</td>
</tr>
<?php endif; ?>

<?php
$i = 0;
foreach ($meetings as $meeting):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        <td>
            <?php echo $i.'.';?>
        </td>
        <td>
            <?php echo $meeting['Meeting']['meeting_title']?>
        </td>
        <td>
            <?php echo $meeting['Meeting']['meeting_num']; ?>
        </td>
        <td>
            <?php echo date($session->read('Global.date_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>&nbsp;
            <?php echo date($session->read('Global.time_format'),strtotime($meeting['Meeting']['meeting_date'])); ?>
        </td>
        <td>
            <?php echo $meeting['Meeting']['venue']; ?>
        </td>
       
        <td class="actions">
             <?php echo $html->link(__('Todo', true), array('committee'=>$committee,'controller'=>'meetings','action'=>'todo', $meeting['Meeting']['id'])); ?>
        </td>
        <td class="actions">
            <?php echo $html->link(__('Attendance', true), array('committee'=>$committee,'action'=>'attendance', $meeting['Meeting']['id'])); ?></td>
<td class="actions">
            <?php echo $html->link(__('Minutes', true), array('committee'=>$committee,'action'=>'minutes',$meeting['Meeting']['id']), array('target'=>'_blank')); ?>
        </td>
        <td class="actions">
            <?php echo $html->link(__('Summary', true), array('committee'=>$committee,'action'=>'summary',$meeting['Meeting']['id']), array('target'=>'_blank')); ?>
        </td>
<?php 
    echo $this->element('crud',array('crudid'=>$meeting['Meeting']['id'],'permission'=>$meeting['auth']));
?>
    </tr>
<?php endforeach; ?>

</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

