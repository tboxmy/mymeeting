<?php
if(isset($javascript)):
// load script in <head> section
$javascript->link('scriptaculous/lib/prototype', false);
endif;
?>
<div class="userstatuses form">

<?php __("Latest update is at the top")?>
<table cellpadding='0' cellspacing='0' border='0' id="statuses">
    <tr>
        <th width="10%"><?php __('Implementor')?></th>
        <th width="50%"><?php __('Status')?></th>
        <th width="10%"><?php __('Action Date')?></th>
        <th width="25%"><?php __('Comments')?></th>
    </tr>
    <?php 
    
	$i=0;
    foreach ($statuses as $status) {
	$class = null;
	if ($i++ % 2 == 0) $class = ' class="altrow"';
    ?>
    <tr<?php echo $class?>>
        <td><?php echo $status['User']['name']?></td>
        <td><?php echo nl2br($status['Userstatus']['description'])?><br/>
        <?php
            if(isset($status['MultiFile']['additionalfiles'])) {
                echo "<span class='bold'>".__('Additional Files',true).": </span>"; 
                echo $this->element('multifile',array('multifiles'=>$status['MultiFile']['additionalfiles']));
            }
        ?>
        </td>
        <td><?php echo date(Configure::read('date_format'),strtotime($status['Userstatus']['action_date']));?></td>
        <td><?php echo $comment->list_comment('Userstatus',$status);?></td>
    </tr>
    <?php }?>
</table>
<p>&nbsp;</p>
<?php echo $form->button(__('OK', true), array('type'=>'button', 'onclick'=>'Modalbox.hide()'));?>

</div>
