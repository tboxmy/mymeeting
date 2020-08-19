<fieldset>
    <legend><?php __('Select members to invite');?></legend>
    
    <?php foreach ($committees as $committee_id=>$committee_name):?>
        <?php $committee_name = $committee_name?>
        <?php break ?>
    <?php endforeach;?>

    <p class='note'><?php __('List of members for committee:')?> <strong><?php echo $committee_name ?></strong>.
    <?php __('Please select the members you would like to invite to this meeting.')?> </p><br>


    <table cellpadding='0' cellspacing='0' width='70%'>
        <tr>
            <th>Name</th>
            <th>Post</th>
            <th>&nbsp;</th>
        </tr>
        <?php if (!count($users)): ?>
            <tr>
                <td colspan='4'>No members found. Please assign members to this committee.</td>
            </tr>
        <?php endif; ?>

        <?php $prev_invited_users = ''; ?>
        <?php foreach ($users as $user):?>
        <tr>
            <td><?php echo $user['User']['name'] ?>
                <?php echo $form->hidden('UserEmail.'.$user['User']['id'], array('value'=>$user['User']['email'])) ?>
                <?php echo $form->hidden('UserName.'.$user['User']['id'], array('value'=>$user['User']['name'])) ?>
            </td>
            <td><?php echo $user['User']['job_title'] ?> </td>
           
            <?php 
            $checked = 'false';
            if (isset($data) && $user['Committee']['id'] == $data['Committee']['id']) {
                foreach ($data['User'] as $invited_user) {
                    if ($invited_user['id'] == $user['User']['id']) {
                        $checked = 'true';
                        $prev_invited_users.= $user['User']['id'].'|';
                        break;
                    } 
                }
            }
            ?>
            <td><?php echo $form->checkbox('MeetingsUser.'.$user['User']['id'], array('checked'=>$checked)) ?></td>
        </tr>
        <?php endforeach;?>
        <?php echo $form->hidden('prev_invited_users', array('value'=>rtrim($prev_invited_users,'|'))); ?>
    </table>
    
</fieldset>


<fieldset>
    <legend><?php __('Set templates');?></legend>
    <?php 
    $i=1;
    //echo "<pre>".print_r($templates,true)."</pre>";
    foreach ($templates as $template) {
        echo $i++.'. '.__($template['Template']['title'],TRUE);
        echo "<p class='note'>";
        echo __($template['Template']['description'],true);
        echo "<br>".__('Available tokens',true).': '.r('|',', ',$template['Template']['help']);
        echo $form->textarea('Meeting.'.$template['Template']['field'], array('rows'=>'10', 'value'=>$template['Template']['template']));
        echo "</p>&nbsp;<br>";
    }
    ?>
</fieldset>
