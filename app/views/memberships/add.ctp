<?php
if(isset($javascript)):
// load script in <head> section
$javascript->link('scriptaculous/lib/prototype', false);
endif;
?>
<script>
function checkemail(emel){
    var url='<?php echo $html->url(array('controller'=>'ajaxes','action'=>'checkemail'))?>/'+emel.value;
    var dajax=new Ajax.Request(url,{method:'post',onSuccess:doCheckEmail});
}

function doCheckEmail(response){
    if(response.responseText.length>10){
        dresponse=response.responseText;
        ddata=dresponse.toQueryParams();
        if(ddata.username.length>3) $('UserUsername').value=ddata.username;
        if(ddata.title_id.length>3) $('UserTitleId').value=ddata.title_id;
        if(ddata.name.length>3) $('UserName').value=ddata.name;
        if(ddata.job_title.length>3) $('UserJobTitle').value=ddata.job_title;
        if(ddata.address.length>3) $('UserAddress').value=ddata.address;
        if(ddata.telephone.length>3) $('UserTelephone').value=ddata.telephone;
        if(ddata.fax.length>3) $('UserFax').value=ddata.fax;
        if(ddata.mobile.length>3) $('UserMobile').value=ddata.mobile;

        $('UserUsername').disabled=true;
        $('UserTitleId').disabled=true;
        $('UserName').disabled=true;
        $('UserJobTitle').disabled=true;
        $('UserAddress').disabled=true;
        $('UserTelephone').disabled=true;
        $('UserFax').disabled=true;
        $('UserMobile').disabled=true;
    }
    else{
        $('UserUsername').disabled=false;
        $('UserTitleId').disabled=false;
        $('UserName').disabled=false;
        $('UserJobTitle').disabled=false;
        $('UserAddress').disabled=false;
        $('UserTelephone').disabled=false;
        $('UserFax').disabled=false;
        $('UserMobile').disabled=false;
    }
}

</script>
<div class="memberships form">
<h2><?php __('Add Committee Member')?></h2>
<?php echo $form->create('Membership',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')));?>
    <fieldset>
        <legend><?php __('Add Committee Member');?></legend>
        <div class="fieldset-inside">
<?php
echo $form->input('role_id');
echo $html->div('input',$form->label('Email').$form->text('User.email',array('onKeydown'=>'checkemail(this)','onChange'=>'checkemail(this)')));
echo "<span class='note'>".__('Existing email will automatically fill up all fields below.',true)."</span>";
echo $form->hidden('committee_id',array('value'=>$dcommittee['Committee']['id']));
echo $html->div('userdat',$form->inputs(array('User.username','User.title_id'=>array('options'=>$titles),'User.name','User.job_title','User.bahagian','User.grade','User.address','User.telephone','User.fax','User.mobile')));
?>
        </div>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
