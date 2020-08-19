<div class="logs report">
<h2><?php __('Statistics');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>

<br/>
<?php if ($report == 'USERS') {?>
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php __('No');?></th>
        <th><?php __('User');?></th>
        <th><?php __('Post');?></th>
        <th><?php __('No. of logins');?></th>
        <th><?php __('No. of status update');?></th>
        <th><?php __('No. of comments');?></th>
    </tr>
    <?php
    if(!count($result)) 
        echo "<tr><td colspan='6'>".__('No record found',true)."</td></tr>";

    $i =0;
    foreach ($result as $r):
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
                <?php echo isset($r['t']['long_name']) && $r['t']['long_name']!='' ? $r['t']['long_name'] : '' ?>
                <?php echo $r['u']['name']; ?>
            </td>
            <td>
                <?php echo isset($r['u']['job_title']) && $r['u']['job_title']!='' ? $r['u']['job_title'] : '-' ?>
            </td>
            <td>
                <?php echo isset($r['0']['login']) && $r['0']['login']!='0' ? $r['0']['login'] : '-' ?>
            </td>
            <td>
                <?php echo isset($r['0']['feedback']) && $r['0']['feedback']!='0' ? $r['0']['feedback'] : '-' ?>
            </td>
            <td>
                <?php echo isset($r['0']['comment']) && $r['0']['comment']!='0' ? $r['0']['comment'] : '-' ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php } else if ($report == 'MEETINGS') {?>

    <table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php __('Meeting title');?></th>
        <th><?php __('Total meetings');?></th>
        <th><?php __('Total decisions');?></th>
        <th><?php __('Assigned to');?></th>
        <th><?php __('Total status update');?></th>
        <th><?php __('Update from');?></th>
    </tr>
    <?php
    if(!count($result)) 
        echo "<tr><td colspan='6'>".__('No record found',true)."</td></tr>";

    $i =0; $k=0;
    $committee = '';
    $meeting_title = '';
    foreach ($result as $r):
        
        if ($committee != $r['c']['name'] || empty($committee)) {
    ?>
            <tr class="altrow header">
                <td colspan='6'>
                    <?php echo ++$i.'. '.__('Committee',true).': '.$r['c']['name']; ?>
                </td>
            </tr>
    <?php
        } 
        if (empty($r['m']['meeting_title'])) {
    ?>
            <tr>
                <td colspan='6'>
                    <?php __('No record found'); ?>
                </td>
            </tr>
    <?php
        }
        if ($meeting_title != $r['m']['meeting_title']) {
            $class = '';
            if ($k++ % 2 == 0) {
                $class = ' class="altrow"';
            }
    ?>
        <tr <?php echo $class;?>>
            <td>
                <?php echo $r['m']['meeting_title']; ?>
            </td>
            <td>
                <?php echo $r['0']['kuantiti']; ?>
            </td>
            <td>
                <?php echo isset($r['0']['numofdec']) && $r['0']['numofdec']!='0' ? $r['0']['numofdec'] : '-'; ?>
            </td>
            <td>
                <?php __('Individual:');?>
                <?php echo isset($r['0']['numofdec_assg_usr']) && $r['0']['numofdec_assg_usr']!='0' ? $r['0']['numofdec_assg_usr'] : '-' ;?>
                <br/><?php __('Group:');?>
                <?php echo isset($r['0']['numofdec_assg_grp']) && $r['0']['numofdec_assg_grp']!='0' ? $r['0']['numofdec_assg_grp'] : '-' ;?>
            </td>
            <td>
                <?php $totalstat = intval($r['0']['numofstat_usr']) + intval($r['0']['numofstat_grp']);?>
                <?php echo isset($r['0']['numofstat_usr']) && isset($r['0']['numofstat_grp']) && $totalstat != '0' ? $totalstat : '-'; ?>
            </td>
            <td>
                <?php __('Individual:');?>
                <?php echo isset($r['0']['numofstat_usr']) && $r['0']['numofstat_usr']!='0' ? $r['0']['numofstat_usr'] : '-' ;?>
                <br/><?php __('Group:');?>
                <?php echo isset($r['0']['numofstat_grp']) && $r['0']['numofstat_grp']!='0' ? $r['0']['numofstat_grp'] : '-' ;?>
            </td>
        </tr>
            
    <?php
        }
        $committee = $r['c']['name'];
        $meeting_title = $r['m']['meeting_title'];
    ?>
    <?php endforeach; ?>
    </table>
<?php } else { ?>
    
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td><?php __('Please select type of report above to view');?>
            </td>
        </tr>
    </table>
    
<?php }?>
</div>
