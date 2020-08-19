<?php
$item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';

function cleanstyle($text){
    return $text;
}
?>
<fieldset id="leftcolumn" class="nobullet">
    <legend>
        <?php __('List of decisions');?>
        <?php echo count($decisions)? ': '.count($decisions) : '' ?>
    </legend>
    <div class="fieldset-inside">
    
    <?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>
    
<?php
//echo "<pre>".htmlentities(print_r($this,true))."</pre>";
if(count($decisions)){
    echo "<ul>";
    foreach($decisions as $decision){
?>
    <li><?php
        if($auth_user['User']['superuser']||(isset($permission['edit']) && $permission['edit'])){
            $singular=strtolower(Inflector::singularize($this->params['controller']));
            echo $html->link($html->image('icons/edit.gif'),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'edit',$singular.'id'=>$decision['Decision'][$singular.'_id'],'id'=>$decision['Decision']['id']),null,null,false);
            echo $html->link($html->image('icons/delete.gif'),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'delete',$singular.'id'=>$decision['Decision'][$singular.'_id'],'id'=>$decision['Decision']['id']),null,sprintf(__('Are you sure you want to delete # %s?', true), $decision['Decision']['id']),false);
            echo $html->link($html->image('icons/go-up.png'),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'promote',$singular.'id'=>$decision['Decision'][$singular.'_id'],'id'=>$decision['Decision']['id']),null,null,false);
            echo $html->link($html->image('icons/go-down.png'),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'demote',$singular.'id'=>$decision['Decision'][$singular.'_id'],'id'=>$decision['Decision']['id']),null,null,false);
            echo $html->link($html->image('icons/email.png'),array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'decisions','action'=>'announcedecision',$singular.'id'=>$decision['Decision'][$singular.'_id'],'id'=>$decision['Decision']['id']),null,null,false);
        }
?>
    <span class="viewtitle">
    <?php if (strtolower($this->params['controller']) == 'meetings'):?>
        <?php echo ucwords($item_name);?>: </span>
        <?php echo $html->link($decision['Item']['name'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'items','action'=>'view',$decision['Item']['id']));?>
    <?php elseif (strtolower($this->params['controller']) == 'items'):?>
        <?php __('Meeting');?>:</span>
        <?php echo $html->link($decision['Meeting']['meeting_num'],array('committee'=>$dcommittee['Committee']['short_name'],'controller'=>'meetings','action'=>'view',$decision['Meeting']['id']));?>
    <?php endif;?>
    </li>
    <li><span class="viewtitle"><?php __('Deadline');?>: </span><?php echo date(Configure::read('date_format'),strtotime($decision['Decision']['deadline']));?></li>
    <li><span class="viewtitle"><?php __('Description');?>: </span><?php echo $html->div('decision_text',cleanstyle($decision['Decision']['description']));?></li>
<?php
        if(isset($decision['MultiFile']['additionalfiles'])){
?>
    <li><span class="viewtitle"><?php __('Additional Files');?>: </span><?php echo $this->element('multifile',array('multifiles'=>$decision['MultiFile']['additionalfiles']));?></li>
<?php
        }
?>
<?php 
        if(count($decision['User'])):
?>
<li><span class="viewtitle"><?php __('Individual Implementor');?>: </span><?php echo "<ul>"; foreach($decision['User'] as $user) echo "<li>".$user['name']."</li>"; echo "</ul>"; ?></li>
<?php
            endif;
?>
<?php 
        if(count($decision['Group'])):
?>
    <li><span class="viewtitle"><?php __('Group Implementor');?>: </span><?php echo "<ul>"; foreach($decision['Group'] as $user) echo "<li>".$user['name']."</li>"; echo "</ul>"; ?></li>
<?php
            endif;
?>
    <li>
<?php 
            echo __('Comments',true).': ';
        echo $html->link($comment->no_of_comments('Decision',$decision),array(
            'controller'=>'decisions',
            'action'=>'view',
            'committee'=>$dcommittee['Committee']['short_name'],
            $decision['Decision']['id']."#comments"));
        echo ' | ';
        $to_echo_status = count($decision['Groupstatus'])||count($decision['Userstatus']) ? __("Updated",true) : __("No update",true);
        echo __('Status',true).': ';
        echo $html->link($to_echo_status,array(
            'controller'=>'decisions',
            'action'=>'view',
            'committee'=>$dcommittee['Committee']['short_name'],
            $decision['Decision']['id']."#status"));
?>
    </li>
<hr><br />
<?php
    }
    echo "</ul>";
} else { __('No decisions found'); }
?>
    </div>
</fieldset>
