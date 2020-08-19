<div class="memberships form">
<h2><?php __('User Role Per Committee');?></h2>

<?php echo $form->create('CommitteesUser',array('action' => 'editroles'));?>
	<fieldset>
 		<legend><?php __('Edit User role per committee');?></legend>

	<?php
                
                 
	    echo "<ul><li>Committee Name: ".$membership ['Committee']['name']."</li>";	
        echo "<li> User Name: ".$membership['User']['name']."</li>";
        echo "<li>".$form->input('id')."</li>";
        echo "<li>".$form->hidden('user_id')."</li>";
        echo "<li>".$form->hidden('committee_id')."</li>";
        echo "<li>".$form->input('role_id')."</li></ul>";
	?>
	</fieldset>
<?php echo $form->button(__('Submit', true),array('type'=>'submit'));?>&nbsp;
<?php echo $form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)'));?>
<?php echo $form->end();?>
</div>




