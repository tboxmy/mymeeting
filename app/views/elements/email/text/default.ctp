httestty
<?php echo $data['emailcontent']?>

<?php if (count($agency)):?>
<?php echo $this->element('contact', array($agency))?>
<?php endif;?>
