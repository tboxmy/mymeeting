<?php // for translation
__('Userstatus',true); 
__('Groupstatus',true);
__('Membership',true);
__('Item',true);
__('Committeetodo',true);
?>
<div class="wfmodels index">
<?php if(isset($allow_add_wfmodels)): ?>
<p class='contentmenu'>[ <?php
    echo $html->link(__("Add new model permission",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add'));
?> ]</p>
<?php endif; ?>
<h2><?php __('Permissions');?></h2>
<table cellpadding="0" cellspacing="0">
<tr>
    <th width='3%'><?php __('No');?></th>
    <th><?php echo $paginator->sort('model');?></th>
    <th colspan='4'><?php __('Permission');?></th>
    <th class="actions" colspan='3'><?php __('Actions');?></th>
</tr>
<tr class='header'>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th><?php __('View')?></th>
    <th><?php __('Create')?></th>
    <th><?php __('Edit')?></th>
    <th><?php __('Delete')?></th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
</tr>
<?php
$i = 0;
foreach ($wfmodels as $wfmodel):
    $class = null;
if ($i++ % 2 == 0) {
    $class = ' class="altrow"';
}
?>
    <tr<?php echo $class;?>>
        <td>
            <?php echo $i.'. '; ?>
        </td>
        <td>
            <?php echo __($wfmodel['Wfmodel']['model'],true); ?>
        </td>
        <td>
            <?php echo $wfmodel['Wfmodel']['view']; ?>
        </td>
        <td>
            <?php echo $wfmodel['Wfmodel']['create']; ?>
        </td>
        <td>
            <?php echo $wfmodel['Wfmodel']['edit']; ?>
        </td>
        <td>
            <?php echo $wfmodel['Wfmodel']['delete']; ?>
        </td>
        <?php 
        echo $this->element('crud',array('crudid'=>$wfmodel['Wfmodel']['id'],'permission'=>$wfmodel['auth']));
        ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
