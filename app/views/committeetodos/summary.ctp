<div class="committeetodos view">
<h2><?php  __('CommitteeTodos');?></h2>
<ul>
<li><span class="fieldtitle">Meeting Num: </span><?php echo $meeting['Meeting']['meeting_num'];?></li>
<li><span class="fieldtitle">Meeting Date: </span><?php echo date('d/m/Y (h:i a)',strtotime($meeting['Meeting']['meeting_date'])); ?></li>
<li><span class="fieldtitle">Venue: </span><?php echo $meeting['Meeting']['venue']; ?></li>
<li><span class="fieldtitle">Committee: </span><?php echo $meeting['Committee']['name']; ?></li>
</ul>
</div>

