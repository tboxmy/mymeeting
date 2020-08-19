<div class="meetings view">
<h2><?php  __('Meeting');?></h2>
<ul>
	<li><span class="fieldtitle"><?php echo __('Meeting Title')?>: </span><?php echo $meeting['Meeting']['meeting_title'];?></li>
    <li><span class="fieldtitle"><?php echo __('Meeting Num')?>: </span><?php echo $meeting['Meeting']['meeting_num'];?></li>
    <li><span class="fieldtitle"><?php echo __('Meeting Date')?>: </span><?php echo date('d/m/Y (h:i a)',strtotime($meeting['Meeting']['meeting_date'])); ?></li>
    <li><span class="fieldtitle"><?php echo __('Venue')?>: </span><?php echo $meeting['Meeting']['venue']; ?></li>
    <li><span class="fieldtitle"><?php echo __('Committee')?>: </span><?php echo $meeting['Committee']['name']; ?></li>
    <li><span class="fieldtitle"><?php echo __('Meeting Invitees')?>: </span>
    <?php if (count($meeting['User'])):?>
        <ul>
        <?php foreach ($meeting['User'] as $invitee):?>
            <li>
            <?php echo $invitee['name'] ?>
            <?php echo empty($invitee['job_title']) ? '': ', '.$invitee['job_title'] ?>
            <?php echo empty($invitee['agency']) ? '': ', '.$invitee['agency'] ?>
            </li>
        <?php endforeach;?>
        </ul>
    <?php else:?>
        <?php echo __('No one has been invited for this meeting') ?>
    <?php endif;?>
    </li>
</ul>


