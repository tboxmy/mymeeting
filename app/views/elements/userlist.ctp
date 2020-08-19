<?php
if(isset($javascript)):
// load script in <head> section
$javascript->link('scriptaculous/lib/prototype', false);
endif;
?>
<script>
function selectusers(group){
    groupid=group.id.gsub('<?php echo $this->model ?>Group','');
    var url='<?php echo $html->url(array('controller'=>'ajaxes','action'=>'groupusers'))?>/'+groupid;
    var dajax=new Ajax.Request(url,{onSuccess:function doit(response){doselectusers(response,group)}});
}

function doselectusers(response,group){
    users=response.responseText.split(',');
    for(var index=0,len=users.length; index<len; ++index){
        var user=users[index];
        if($('UserUser'+user)){
            $('UserUser'+user).checked=group.checked;
        }
    }
}

function unselectgroup(user){
    userid=user.id.gsub('UserUser','');
    var url='<?php echo $html->url(array('controller'=>'ajaxes','action'=>'usergroups'))?>/'+userid;
    var dajax=new Ajax.Request(url,{onSuccess:dounselectgroups});
}

function dounselectgroups(response){
    groups=response.responseText.split(',');
    for(var index=0,len=groups.length; index<len; ++index){
        var group=groups[index];
        if($('<?php echo $this->model ?>Group'+group)){
            $('<?php echo $this->model ?>Group'+group).checked=false;
        }
    }
}
</script>
<?php
if (!isset($from) || $from != 'meetings/edit') {
?>
    <table cellpadding='0' cellspacing='0' width='100%'><tr>
    <?php
    if(count($groups)){

        echo "<td width='50%'>".$html->div('radio',$form->input('group',array('label'=> __('Select by group', true),'options'=>$groups,'multiple'=>'checkbox','onChange'=>'selectusers(this)')))."</td>";
    }
    echo "<td width='50%'>".$html->div('radio',$form->input('User.User',array('options'=>$users,'onClick'=>'unselectgroup(this)','multiple'=>'checkbox')))."</td>";
    ?>
    </tr></table>

<?php
} else {
?>

    <table cellpadding='0' cellspacing='0' width='100%'><tr>
    <?php 
    if(count($groups))
        echo "<td width='50%'>".$html->div('radio',$form->input('group',array('label'=> __('Select by group', true),'options'=>$groups,'multiple'=>'checkbox','onChange'=>'selectusers(this)')))."</td>";
    
    $temp = array();
    foreach ($users2 as $att) 
        $att['Attendance']['deleted']==0 ? array_push($temp, $att['Attendance']['user_id']) : '';
    $output = "<td width='50%'>";
    $output.= $form->label('User.User',__("Members",true));
    $i = 0;
    foreach ($users as $key=>$user) {
        in_array($key, $temp) ? $checked = 'checked': $checked = ''; // if invited previouly, check the box
        $output.= $html->div('input checkbox',
                    $form->checkbox('User.User.'.$i++,array('value'=>$key,'id'=>'UserUser'.$key,'checked'=>$checked,'onClick'=>'unselectgroup(this)')).$form->label('User.User',$user)
                    );
    }
    $output.="</td>";
    echo $html->div('radio',$output);

    ?>
    </tr></table>
<?php } ?>
