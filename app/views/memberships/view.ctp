<div class="memberships view">
<h2>
    <?php  __('View member');?>
</h2>
<?php isset($title['Title']['long_name']) && !empty($title['Title']['long_name']) ? $title = $title['Title']['long_name'].' ' : $title = ''; ?>
<ul>
<li><span class="viewtitle"><?php __('Name'); ?>:</span> <?php echo $title.$membership['User']['name']; ?></li>
<li><span class="viewtitle"><?php __('Email'); ?>:</span> <?php echo $membership['User']['email']; ?></li>
<li><span class="viewtitle"><?php __('Post'); ?>:</span> <?php echo $membership['User']['job_title']; ?></li>
<li><span class="viewtitle"><?php __('Section/Division'); ?>:</span> <?php echo $membership['User']['bahagian']; ?></li>
<li><span class="viewtitle"><?php __('Grade'); ?>:</span> <?php echo $membership['User']['grade']; ?></li>
<li><span class="viewtitle"><?php __('Address'); ?>:</span> <?php echo "<br/>".nl2br($membership['User']['address']); ?></li>
<li><span class="viewtitle"><?php __('Telephone'); ?>:</span> <?php echo $membership['User']['telephone']; ?></li>
<li><span class="viewtitle"><?php __('Mobile'); ?>:</span> <?php echo $membership['User']['mobile']; ?></li>
<li><span class="viewtitle"><?php __('Fax'); ?>:</span> <?php echo $membership['User']['fax']; ?></li>
</li>
</ul>

<fieldset>
<legend><?php __('Committees');?></legend>
<div class="fieldset-inside">
    <?php __("This member is involved in the following committees:")?>
    <table cellpadding="0" cellspacing="0" style="width: 700px;">
        <tr>
            <th width="3%"><?php __('No')?></th>
            <th><?php __('Committee')?></th>
            <th><?php __('Role')?></th>
        </tr>
        <?php $i=0;?>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?php echo ++$i.'. '?></td>
            <td><?php echo  $role['Committee']['name']; ?></td>
            <td><?php echo  $role['Role']['name']; ?></td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
</fieldset>
</div>
