<h2><?php __('list Todo');?></h2>
<fieldset>
<?php foreach ($todo as $todo):?>
<?php $todo_name = $todo['Todo']['name']?>
<?php endforeach;
echo $todo_name ?>
</fieldset>



