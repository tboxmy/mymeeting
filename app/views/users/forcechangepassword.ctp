<h2><?php __("Change Password")?></h2>
<fieldset>
<legend><?php __('Change Password');?></legend>
    <div class="fieldset-inside">
    <?php echo $form->create(array('action'=>"forcechangepassword"));?>

    <p class="instructions">
    <?php __("Please reset your password.")?> 
    <?php __("Password can not be the same as your username.")?>
    </p>

    <div class="input text">
    <label for="newpassword"><?php __('New Password');?></label>
    <?php echo $form->password('newpassword',array('class'=>'required','error'=>array(
        'alphaNumeric'=>__("Alphabets and numbers only",true),
        'minLength'=>__("Minimum length is 4",true)
        ))); ?> 
    </div>

    <div class="input text">
    <label for="confirmpassword"><?php __('Confirm Password');?></label>
    <?php echo $form->password('confirmpassword', array('class'=>'required','error'=>array(
        'alphaNumeric'=>__("Alphabets and numbers only",true),
        'minLength'=>__("Minimum length is 4",true)
        ))); ?> 
    </div>
    </div>
</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</form>


