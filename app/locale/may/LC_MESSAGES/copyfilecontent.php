<?php
$txt = file("default.po");
$txt_new = fopen("new.po","w");
for($i=0;$i<10;$i++)
{
$output.=$txt[$i];
}
fwrite($txt_new,$output);

function getmsg($filename){
$txt = file($filename);
$curout=array();
for($i=11;$i<count($txt);$i++)
{
        if(strlen($txt[$i])>3)
        {
        $curout[]=$txt[$i];
                if(strpos($txt[$i],"msgid")!==false)
                {
                        $key=substr($txt[$i],7,strlen($txt[$i])-9);

                }
        }
        else{
        $wrap[$key]=$curout;
        unset($curout);
        }
}
return $wrap;
}

$defaultpo=getmsg("default.po");
$defaultpot=getmsg("../../default.pot");
//print_r($defaultpot);
foreach($defaultpot as $key=>$data)
{
        if ($key=="Rules"){
        //echo $key;
        }
        
        if(!isset($defaultpo[$key]))
        {       
        $defaultpo[$key]=$data;
        //echo $data;
        }
}
foreach($defaultpo as $data){
fwrite($txt_new,"\n");
        foreach($data as $line)
        {
             fwrite($txt_new, $line);  
        }
}
fclose($txt_new);
?>
