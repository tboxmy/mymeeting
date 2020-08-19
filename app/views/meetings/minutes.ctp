<?php echo $html->css('minutes'); ?>
<div class="meetings view">
<h1 class="minutetitle"><?php echo $meeting['Committee']['name'];?></h1>
<h1 class="minutetitle"><?php __(' Meeting Minutes');?></h1>
<h1 class="minutetitle"><?php echo $meeting['Meeting']['meeting_num'];?></h1>
<h1 class="minutetitle"><?php echo "<span class=\"fieldtitle\">".__('Date',true).": </span><span class=\"fielddata\">".date(Configure::read('date_format'),strtotime($meeting['Meeting']['meeting_date']));?></span></h1>
<h1 class="minutetitle"><?php echo "<span class=\"fieldtitle\">".__('Time',true).": </span><span class=\"fielddata\">".date(Configure::read('time_format'),strtotime($meeting['Meeting']['meeting_date']));?></span></h1>
<h1 class="minutetitle"><?php echo "<span class=\"fieldtitle\">".__('Venue',true).":</span><span class=\"fielddata\">".$meeting['Meeting']['venue'];?></span></h1>

    <h1 class="minutepart"><?php echo __('Present')?></h1>
    <?php if (count($attended)):?>
        <ol>
        <?php foreach ($attended as $attended):?>
            <li>
            <?php echo $titles[$attended['User']['title_id']].' '.$attended['User']['name'] ?>
            <?php echo strlen($attended['User']['job_title'])?', '.$attended['User']['job_title']:'&nbsp;' ?></li>
            <?php echo strlen($attended['Attendance']['excuse'])?'Excuse: '.$attended['Attendance']['excuse']:'&nbsp;' ?></li>
        <?php endforeach;?>
        </ol>
    <?php else:?>
    <?php echo __('No one has attended this meeting') ?>
    <?php endif;?>

    <?php if (count($notattended)):?>
     <h1 class="minutepart"><?php echo __('Absent with apologies')?></h1>
        <ol>
        <?php foreach ($notattended as $notattended):?>
            <li>
            <?php echo $titles[$attended['User']['title_id']].' '.$notattended['User']['name'] ?>
            <?php echo strlen($notattended['User']['job_title'])?', '.$notattended['User']['job_title'].'.':'&nbsp;' ?>
            <?php echo strlen($notattended['Attendance']['excuse'])?'Excuse: '.$notattended['Attendance']['excuse']:'&nbsp;' ?></li>
        <?php endforeach;?>
        </ol>
    <?php endif;?>
<br />
<?php echo $meeting['Meeting']['minutes']; ?>
