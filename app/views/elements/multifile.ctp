<?php
        if(isset($multifiles)){
            if(isset($title)) {
                echo "<h4>".__($title,true)."</h4>";
            }
            foreach($multifiles as $mfd){
                echo "<li>";
                echo $html->link($mfd['Attachment']['filename'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'attachment',$mfd['Attachment']['id']));
                echo "</li>";
            }
        }
?>
