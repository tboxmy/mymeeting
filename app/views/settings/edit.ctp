<p class='contentmenu'>
    [ <?php echo $html->link(__("Reload settings",true),array('controller'=>'settings','action'=>'edit')); ?> ] 
    [ <?php echo $html->link(__("Change logo",true),array('controller'=>'settings','action'=>'logo')); ?> ]
</p>
<div class="settings form">
<h2><?php __('Edit Global Settings');?></h2>
<?php echo $form->create('Settings', array('action'=>'edit'));?>
    <fieldset>
         <legend><?php __('Edit Global Settings');?></legend>
    <?php
        //foreach (Configure::read('v') as $key => $value) {    
        foreach($user_settings as $setting){
            $value=Configure::read($setting);
            if ($setting == 'agency_address') {
                echo $html->div('', $form->input($setting, array('value'=>$value,'type'=>'textarea')));
                continue;
            }
            if ($setting == 'version' || $setting == 'defaultrole') continue;
            echo $html->div('', $form->input(__($setting,true), array('size'=>'30','value'=>$value)));
        }
        
        // for translation
        __('Agency Address',true);
        __('Agency Name',true);
        __('Agency Slogan',true);
        __('Date Format',true);
        __('Time Format',true);
        __('Email From',true);
        __('Email From Name',true);
        __('Email Host',true);
        __('Email Port',true);
        __('Days To Remind',true);
        __('Server Url',true);
        
    ?>
    </fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>
<!--div class="actions">
    <ul>
        <li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Setting.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Setting.id'))); ?></li>
        <li><?php echo $html->link(__('List Settings', true), array('action'=>'index'));?></li>
    </ul>
</div-->
