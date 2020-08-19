<div id="mainpage">
    <div>
    <span class="head"><?php __("My committees")?></span><p>&nbsp;</p>
    <span class="instructions"><?php __("The following is a list of committees you're involved in. To call for a new meeting, update current status or add new committee member, please click on the appropriate committee name to continue:")?></span>
    </div>

    <div>
    <table  cellspacing="0" cellpadding="0" align="left" id="comm_list">

<?php
$i = 0;
$y=0;

foreach($committees as $key=>$com){
    if (strpos($key,'_details') === false) {
            
        echo "<tr>";
        echo "<td id='committee'>".$html->link($com,array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'committees','action'=>'alert')).'</td>';
        
        echo "<td>";
        if($committees[$key.'_details']['0']['add_committee']) echo $html->link($html->image('icons/committee_add1.gif', array('title'=>__('Create: Click here to create a sub-committee',true),'alt'=>__('Click here to add a sub-committee',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'committees','action'=>'addsubcomm','id'=>$key),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['edit_committee']) echo $html->link($html->image('icons/edit.gif', array('title'=>__('Edit: Click here to edit this committee',true),'alt'=>__('Click here to edit this committee',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'committees','action'=>'edit','id'=>$key),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['edit_committee']) echo $html->link($html->image('icons/delete.gif', array('title'=>__('Delete: Delete this committee',true),'alt'=>__('Click here to delete this committee',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'committees','action'=>'delete'),null,sprintf(__('Are you sure you want to delete commitee called %s?', true),$key),false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['view_wfmodels']) echo $html->link($html->image('icons/workflow.gif',array('title'=>__('Permissions: Click here to navigate to permission management',true),'alt'=>__('Click here to navigate to workflow management',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'wfmodels','action'=>'index'),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['view_announcements']) echo $html->link($html->image('icons/announcement.gif', array('title'=>__('Announcements: Click here to navigate to committee announcements',true),'alt'=>__('Click here to navigate to committee announcements',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'announcements','action'=>'index'),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['view_groups']) echo $html->link($html->image('icons/group1.gif',array('title'=>__('Groups: Click here to navigate to committee groups management',true),'alt'=>__('Click here to navigate to committee groups management',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'Groups','action'=>'index'),null,null,false);
        echo "</td>";
        echo "<td>"; 
        if($committees[$key.'_details']['0']['view_users']) echo $html->link($html->image('icons/users.png',array('title'=>__('Users: Click here to navigate to committee users management',true),'alt'=>__('Click here to navigate to committee users management',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'memberships','action'=>'index'),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['view_todos']) echo $html->link($html->image('icons/todos1.gif',array('title'=>__('To-dos: Click here to navigate to committee to-dos management',true),'alt'=>__('Click here to navigate to committee to-dos management',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'committeetodos','action'=>'index'),null,null,false);
        echo "</td>";
        echo "<td>";
        if($committees[$key.'_details']['0']['view_templates']) echo $html->link($html->image('icons/template.png', array('title'=>__('Messages: Click here to navigate to committee messages management',true),'alt'=>__('Click here to navigate to committee messages management',true))),array('committee'=>$committees[$key.'_details']['0']['short_name'],'controller'=>'Templates','action'=>'index'),null,null,false);
        echo "</tr>";
    } 
} 
if (!count($committees)) {
    echo "<tr><td colspan='2'>".__(" You are not registered under any committee yet",true)." </td></tr>";
}


if (!$i) {
    
}
?>
    </table>
    </div>
    <?php if($auth_user['User']['superuser']):?>
    <div style="clear:left">
    <span class="head"><?php __("Other tasks")?> </span><p>&nbsp;</p>
    <span class="instructions"><?php __("You have access to these:")?></span>
    <div class="content">
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="25%"><?php echo $html->link($html->image('icons/committee_add.gif'),array('controller'=>'committees','action'=>'add'),null,null,false); ?><br/><?php echo $html->link(__('Add committee',true),array('controller'=>'committees','action'=>'add'));?>
                <br /><?php __('Add a committee')?>
            </td>
            <td width="25%"><?php echo $html->link($html->image('icons/roles.gif'),array('controller'=>'roles','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Roles',true),array('controller'=>'roles','action'=>'index'))?>
                <br /><?php __('Manage roles and privileges')?>
            </td>
            <td width="25%"><?php echo $html->link($html->image('icons/titles.gif'),array('controller'=>'titles','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Titles',true),array('controller'=>'titles','action'=>'index'));?>
                <br /><?php __("Manage all titles (Y.Bhg Dato', Tuan, Puan etc)")?>
            </td>
            <td width="25%"><?php echo $html->link($html->image('icons/users2.png'),array('controller'=>'users','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Users',true),array('controller'=>'users','action'=>'index'));?>
                <BR /><?php __("Manage users & committees")?>
            </td>
        </tr>
        <tr>
            <td><?php echo $html->link($html->image('icons/todos.gif'),array('controller'=>'systemtodos','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('To-dos',true),array('controller'=>'systemtodos','action'=>'index'));?>
                <br /><?php __("Default checklist prior to a meeting")?>
            </td>
            <td><?php echo $html->link($html->image('icons/messages.gif'),array('controller'=>'templates','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Messages',true),array('controller'=>'templates','action'=>'index'));?>
                <br /><?php __("Manage the email templates")?>
            </td>
            <td><?php echo $html->link($html->image('icons/conf2.png'),array('controller'=>'settings','action'=>'edit'),null,null,false); ?><br/><?php echo $html->link(__('Global settings',true),array('controller'=>'settings','action'=>'edit'));?>
                <br /><?php __("Manage global settings")?>
            </td>
            <td><?php echo $html->link($html->image('icons/edit-find.png'),array('controller'=>'logs','action'=>'index'),null,null,false); ?><br/><?php echo $html->link(__('Logs',true),array('controller'=>'logs','action'=>'index'));?>
                <br /><?php __("View Logs")?>
            </td>
        </tr>
        <tr>
            <td><?php echo $html->link($html->image('icons/statistics.png'),array('controller'=>'logs','action'=>'report'),null,null,false); ?><br/><?php echo $html->link(__('Statistics',true),array('controller'=>'logs','action'=>'report'));?>
                <br /><?php __("Various reports")?>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>
    </div>
    </div>
    <?php endif;?>
</div>
