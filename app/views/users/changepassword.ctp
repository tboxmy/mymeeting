<h2><?php __('Change password')?></h2>

<?php echo $form->create(array('action'=>"changepassword"));?>
<fieldset>
<legend><?php __('Change password');?></legend>
<div class="fieldset-inside">
    <div class="input text">
    <label for="oldpassword"><?php __('Old Password');?></label>
    <?php echo $form->password('oldpassword'); ?> 
    </div>

    <div class="input text">
    <label for="newpassword"><?php __('New Password');?></label>
    <?php echo $form->password('newpassword'); ?> 
    </div>

    <div class="input text">
    <label for="confirmpassword"><?php __('Confirm Password');?></label>
    <?php echo $form->password('confirmpassword'); ?> 
    </div>
</div>
</fieldset>
<br/>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</form>


