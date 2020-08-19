<?php if(isset($notefor)):?>
<div class="instructions">
    <?php if($notefor == 'form'): ?>
        <?php __('Note')?>: 
        <?php __('Please fill all <span class="required">required</span> fields.')?>
    <?php elseif($notefor == 'filter'):?>
        <?php __('Please select your filter criteria/s')?>
    <?php endif;?>
</div>
<?php endif;?>