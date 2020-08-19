
<?php echo nl2br($data['emailcontent']) ?>
<p></p>

<?php if (count($agency)):?>
<?php echo nl2br($this->element('contact', array($agency))) ?>
<?php endif;?>

