<div id="calendardiv">
<?php
if(isset($javascript)){
    // load script in <head> section
    $javascript->link('scriptaculous/lib/prototype', false);
}
if(isset($month) && isset($year)){
    $firstday=strtotime($year.'-'.$month.'-1');
    $nextmonth=explode('-',date('Y-m-d',mktime(0,0,0,date('m',$firstday)+1,date('d',$firstday),date('Y',$firstday))));
    $prevmonth=explode('-',date('Y-m-d',mktime(0,0,0,date('m',$firstday)-1,date('d',$firstday),date('Y',$firstday))));
    echo "<div id=\"calendarnav\">";
    echo "<span id='calendarnav_r'>";
    echo $ajax->link('<< '.__('prev',true),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'ajaxes','action'=>'calendar','month'=>$prevmonth[1],'year'=>$prevmonth[0]),array('update'=>'calendardiv'));
    echo " | ";
    echo $ajax->link(__('next',true).' >>',array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'ajaxes','action'=>'calendar','month'=>$nextmonth[1],'year'=>$nextmonth[0]),array('update'=>'calendardiv'));
    echo "</span>";
    __("You're currently viewing month: ");
    echo "<h4>".date("M",mktime(0,0,0,date('m',$firstday)))." $year</h4> ";
    echo "</div>";
?>
<table id="calendar" cellpadding="0" cellspacing="0">
<tr><th><?php __('Monday')?></th><th><?php __('Tuesday')?></th><th><?php __('Wednesday')?></th><th><?php __('Thursday')?></th><th><?php __('Friday')?></th><th><?php __('Saturday')?></th><th><?php __('Sunday')?></th></tr>

<?php
    
    $daysinmonth=date('t',$firstday); // Number of days in the given month - 28 through 31
    $firstdayday=date('w',$firstday); // get number representation of the first day (0-sat thru 6-sun)
    if($firstdayday==0) $firstdayday=7;
    echo "<tr>";
    $curdaypos=1;
    foreach($meetings as $mid=>$meeting){
        $appoint[][date('j',strtotime($meeting['Meeting']['meeting_date']))]=$mid;
    }
    /* First thing is we clear the days not in the beginning of the month */
    for($i=1;$i<$firstdayday;$i++){
        $cuti = ($i==6 || $i==7) ? "class='weekend'" : ""; 
        echo "<td $cuti>&nbsp;</td>";
        $curdaypos++;
    }


    /* Then we loop for every day of the month */
    for($i=1;$i<=$daysinmonth;$i++){
	//echo date("m",mktime(0,0,0,date('m',$firstday)));
        $cuti = ($curdaypos==6 || $curdaypos==7) ? "class='weekend'" : "";         	
		if($i == date("d"))
		  {
			if(date("m")==$month && date("Y")==$year)
			{echo "<td class=\"test\" $cuti>$i</span>";}
			else
			{echo "<td $cuti><span class=\"day\">$i</span>";}
		  }			
		  else
		  {echo "<td $cuti><span class=\"day\">$i</span>";}	
        foreach ($appoint as $key=>$datearr) {
	    
            if (array_key_exists($i,$datearr)) {  // only display meetings for that date
                echo "<div class='summary'>";
                if(!isset($dcommittee)){
                echo "<span class=\"title\">".$html->link($meetings[$datearr[$i]]['Committee']['short_name'],array('controller'=>'committees','action'=>'alert','committee'=>$meetings[$datearr[$i]]['Committee']['short_name']))." - </span>";
                }
                echo "<span class=\"title\">".$html->link($meetings[$datearr[$i]]['Meeting']['meeting_num'],array('controller'=>'meetings','action'=>'view','id'=>$meetings[$datearr[$i]]['Meeting']['id'],'committee'=>$meetings[$datearr[$i]]['Committee']['short_name']))."</span>";
                echo "(<span class=\"time\">".date(Configure::read('time_format'),strtotime($meetings[$datearr[$i]]['Meeting']['meeting_date']))."</span>";
                if (isset($meetings[$datearr[$i]]['Meeting']['venue']) && $meetings[$datearr[$i]]['Meeting']['venue'] != '') 
                    echo "<span class=\"venue\">, ".$meetings[$datearr[$i]]['Meeting']['venue']."</span>";
                echo ")</div>";
            }
        }
        echo "</td>";
        if($curdaypos==7){
            echo "</tr><tr>"; //start new row
            $curdaypos=0;
        }
        $curdaypos++;
    }
    /* Finish of the row if it is not finished */
    for($i=$curdaypos;$i<=7;$i++){
        $cuti = ($i==6 || $i==7) ? "class='weekend'" : ""; 
        echo "<td $cuti>&nbsp;</td>";
    }
    echo "</tr>";
?>
</table>
<?php
}
else{
?>
Please enter a valid month and date
<?php
}
?>
</div>
