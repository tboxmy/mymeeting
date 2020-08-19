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
echo "<fieldset><legend>".__('Individual Implementor',true).'</legend>';
echo $html->div('usergroups',$form->input('group',array('label'=>__('Select by group',true),'options'=>$groups,'multiple'=>'checkbox','onChange'=>'selectusers(this)')));
echo $html->div('userusers',$form->input('User.User',array('options'=>$users,'onClick'=>'unselectgroup(this)','multiple'=>'checkbox')));
echo "</fieldset>";

if(count($groups)){
echo "<fieldset><legend>".__('Group Implementor',true).'</legend>';
echo $html->div('userusers',$form->input('Group.Group',array('options'=>$groups,'multiple'=>'checkbox')));
echo "</fieldset>";
}
?>
