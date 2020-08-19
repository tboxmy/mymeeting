<center>
<div id="login">
<h2><?php __('Login'); ?></h2>
	<?php echo $form->create('User', array('action' => 'login','class'=>'login')); ?>
	<?php echo $form->input('username',array('label'=>__('Username',true),'value'=>$session->read('login_username'))); ?>
	<?php echo $form->input('password',array('label'=>__('Password',true))); ?>
    <?php if($displaycaptcha):?>
    <div class="input text" align="center">
    <?php __('You have exceeded more than allowed login attempts.Please fill in the numbers and alphabets you see below.')?>
    <br/>
	<?php echo "<img src='".$html->url(array('action'=>'captcha'))."'>";?>
    </div>
    <?php echo $form->input('captcha',array('label'=>__('Code',true))); ?>
    <?php endif; ?>
	<?php echo $form->submit(__('Login',true), array('class'=>'button')); ?>
	<?php echo $form->end(); ?>
</div>
	<?php 
	echo $html->link(__("Forgot your password?",true),array('controller'=>'users','action'=>'forgotpass'));
	echo '<br/>';	
	echo $html->link(__("Forgot your username?",true),array('controller'=>'users','action'=>'forgotuser'));
	?>
</center>
