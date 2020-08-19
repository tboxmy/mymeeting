<table cellpadding='0' cellspacing='0'>
<tr><th>
    <?php __('Announcements');?>
        <?php echo count($announcement)? ': '.count($announcement) : '' ?>
</th></tr>

<tr><td>  

<?php if (!count($announcement)) : ?>
<?php __('No announcements currently') ?>
<?php endif; ?>


<?php foreach ($announcement as $announcements):?>
    
    <span class="viewtitle"></span> <?php echo $html->div('decision_text',$announcements['Announcement']['description']);
    echo "[by ".$announcements['User']['name']." ,updated on ";
    echo date(Configure::read('date_format'),strtotime($announcements['Announcement']['updated']));?>
    &nbsp;<?php echo date(Configure::read('time_format'),strtotime($announcements['Announcement']['updated']))."]"; ?>
</div>
<?php endforeach; ?>
</td></tr>
</table>



