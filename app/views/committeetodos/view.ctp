<div class="committeesTodos view">
<h2><?php __("View committee's To-do");?></h2>
<div class="contentsummary">
    <ul>
    <li><?php echo $html->div('viewtitle',__('Task',true)); ?>: 
    <?php echo $committeesTodo['Committee']['name']?>
    
    <li><?php echo $html->div('viewtitle',__('Priority',true)); ?>: 
    <?php echo $priorities[$committeesTodo['Committeetodo']['priority']];?></li>
    </ul>
</div>

<?php echo $form->button(__('Back',true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
</div>

