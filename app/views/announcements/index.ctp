<div class="announcements index">
<?php if(isset($allow_add_announcement)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new announcement",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]</P>
<?php endif; ?>
<h2><?php __('Announcements');?></h2>
<p></p>
<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php echo $paginator->sort('description');?></th>  
    <th class="actions" colspan=3><?php __('Actions');?></th>
</tr>

<?php if (!count($announcements)):?>
<tr>
    <td colspan='4'><?php __('No record found')?></td>
</tr>
<?php endif;?>
<?php
$i = 0;
foreach ($announcements as $announcement):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        
        <td>
            <?php echo $announcement['Announcement']['description']; ?>
        </td>
                
        
<?php echo $this->element('crud',array('crudid'=>$announcement['Announcement']['id'],'permission'=>$announcement['auth'])) ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |  <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

