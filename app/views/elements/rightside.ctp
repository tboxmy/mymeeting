<div id="mainpage">

    <span class="instructions"><?php __("You have access to these:")?></span>
    <span class="content">
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><?php echo $html->link($html->image('icons/committee_add.gif'),array('controller'=>'committees','action'=>'add'),null,null,false); ?><br><?php echo $html->link(__('Add committee',true),array('controller'=>'committees','action'=>'add'));?></td>
            <td><?php echo $html->link($html->image('icons/roles.gif'),array('controller'=>'roles','action'=>'index'),null,null,false); ?><br><?php echo $html->link(__('Roles',true),array('controller'=>'roles','action'=>'index'))?></td>
        </tr>
        <tr>    
            <td><?php echo $html->link($html->image('icons/titles.gif'),array('controller'=>'titles','action'=>'index'),null,null,false); ?><br><?php echo $html->link(__('Titles',true),array('controller'=>'titles','action'=>'index'));?></td>
            <td><?php echo $html->link($html->image('icons/users2.png'),array('controller'=>'users','action'=>'index'),null,null,false); ?><br><?php echo $html->link(__('Users',true),array('controller'=>'users','action'=>'index'));?></td>
        </tr>
        <tr>
            <td><?php echo $html->link($html->image('icons/todos.gif'),array('controller'=>'systemtodos','action'=>'index'),null,null,false); ?><br><?php echo $html->link(__('To-dos',true),array('controller'=>'systemtodos','action'=>'index'));?></td>
            <td><?php echo $html->link($html->image('icons/messages.gif'),array('controller'=>'templates','action'=>'index'),null,null,false); ?><br><?php echo $html->link(__('Messages',true),array('controller'=>'templates','action'=>'index'));?></td>
            
        </tr>
        <tr>
            <td><?php echo $html->link($html->image('icons/conf2.png'),array('controller'=>'settings','action'=>'edit'),null,null,false); ?><br><?php echo $html->link(__('Global settings',true),array('controller'=>'settings','action'=>'edit'));?></td>
            <td><?php echo $html->link($html->image('icons/edit-find.png'),array('controller'=>'logs','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Logs',true),array('controller'=>'logs','action'=>'index'));?> </td>
        </tr>
        <tr>
            <td><?php echo $html->link($html->image('icons/statistics.png'),array('controller'=>'logs','action'=>'report'),null,null,false); ?><br><?php echo $html->link(__('Statistics',true),array('controller'=>'logs','action'=>'report'));?></td>
            <td>&nbsp;</td>
        </tr>
    </table>
    </span>


</div>
