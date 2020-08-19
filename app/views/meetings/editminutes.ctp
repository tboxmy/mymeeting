
<h2><?php __('Edit Minutes')?></h2>
<fieldset>
    <legend><?php __('Edit Minutes')?></legend>
    <div class="fieldset-inside">
    <?php
    echo $this->element('tinymce',array('preset'=>'basic'));
    ?>
    <?php 
    echo $form->create('Meeting',array('url'=>array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'editminutes')));
    echo $form->textarea('minutes',array('cols'=>70,'rows'=>30));
    echo $form->input('id'); 
    ?>
    </div>
</fieldset>
<?php
echo $form->submit();
echo $form->end(); 

?>
