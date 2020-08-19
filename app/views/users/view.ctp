<div class="users view">

<h2><span class="viewtitle"><?php  __('View User');?></h2>
    <ul>
    <li><span class="viewtitle"><span class="viewtitle"><?php __('Name');?>:</span></span> <?php echo $user['Title']['short_name'];?> <?php echo $user['User']['name'];?></li>
    <li><span class="viewtitle"><?php __('E-mail');?>:</span> <a href="mailto:<?php echo $user['User']['email'];?>"><?php echo $user['User']['email'];?></a></li>
    <li><span class="viewtitle"><?php __('Post');?>:</span> <?php echo $user['User']['job_title'];?></li>
    <li><span class="viewtitle"><?php __('Section/Division'); ?>:</span> <?php echo $user['User']['bahagian']; ?></li>
    <li><span class="viewtitle"><?php __('Grade'); ?>:</span> <?php echo $user['User']['grade']; ?></li>
    <li><span class="viewtitle"><?php __('Address'); ?>:</span> <?php echo "<br/>".nl2br($user['User']['address']); ?></li>
    <li><span class="viewtitle"><?php __('Telephone'); ?>:</span> <?php echo $user['User']['telephone']; ?></li>
    <li><span class="viewtitle"><?php __('Mobile'); ?>:</span> <?php echo $user['User']['mobile']; ?></li>
    <li><span class="viewtitle"><?php __('Fax'); ?>:</span> <?php echo $user['User']['fax']; ?></li>
    </li>
    </ul>
<fieldset>
<legend><?php __('Committees');?></legend>
<div class="fieldset-inside">
        <?php if (empty($user['Committee'])): ?>
            This user has not been registered with any committee.
        <?php endif;?>
        <ul>
        <?php foreach ($user['Committee'] as $comm): ?>
        <li><?php echo $comm['name']; ?></li>
        <?php endforeach;?>
        </ul>
</div>
</fieldset>
</div>
