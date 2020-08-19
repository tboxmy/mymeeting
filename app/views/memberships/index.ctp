<div class="memberships index">
<?php if(isset($allow_add_users)): ?>
<p class='contentmenu'>[ <?php echo $html->link(__("Add new member",true),array('committee'=>$dcommittee['Committee']['short_name'],'action'=>'add')); ?> ]</p>
<?php endif; ?>
<h2><?php __('Address Book');?></h2>

<?php echo $this->element('searchbox',array('from'=>$this->params['controller'].'/'.$this->params['action'])); ?>
    
<table cellpadding="0" cellspacing="0">
<tr>
    <th><?php __('No')?></th>
    <th><?php echo $paginator->sort('name',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('email',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('telephone',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('mobile',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('job_title',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th><?php echo $paginator->sort('role_id',null,array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?></th>
    <th class="actions" colspan='3'><?php __('Actions');?></th>
</tr>
<?php

if(!count($memberships)) 
    echo "<tr><td colspan='8'>".__('No record found',true)."</td></tr>";

if ($this->params['paging']['Membership']['page'] == '1') $i = 0;
else $i = $this->params['paging']['Membership']['options']['limit'] * $this->params['paging']['Membership']['page'] - $this->params['paging']['Membership']['options']['limit'];

foreach ($memberships as $membership):
    $class = null;
    if ($i++ % 2 == 0) {
        $class = ' class="altrow"';
    }
?>
    <tr<?php echo $class;?>>
        <td>
            <?php echo $i.'. '; ?>
        </td>
        <td>
            <?php echo isset($membership['User']['Title']['long_name']) ? $membership['User']['Title']['long_name']:'&nbsp;'; ?> 
            <?php echo $membership['User']['name'] ? $membership['User']['name']:'&nbsp;'; ?> 
        </td>
        <td>
            <?php echo $membership['User']['email'] ? '<a href="mailto:'.$membership['User']['name'].'<'.$membership['User']['email'].'>">'.$membership['User']['email'].'</a>':'&nbsp;'; ?> 
        </td>
        <td>
            <?php echo $membership['User']['telephone'] ? $membership['User']['telephone']:'&nbsp;'; ?> 
        </td>
        <td>
            <?php echo $membership['User']['mobile'] ? $membership['User']['mobile']:'&nbsp;'; ?> 
        </td>
        <td>
            <?php echo $membership['User']['job_title'] ? $membership['User']['job_title']:'&nbsp;'; ?> 
        </td>
        <td>
            <?php echo $membership['Role']['name'] ? $membership['Role']['name']:'&nbsp;'; ?> 
        </td>

<?php 
echo $this->element('crud',array('crudid'=>$membership['Membership']['id'],'permission'=>$membership['auth']));
?>

    </tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
 |     <?php echo $paginator->numbers(array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])));?>
    <?php echo $paginator->next(__('next', true).' >>', array('url'=>array('committee'=>$dcommittee['Committee']['short_name'])), null, array('class'=>'disabled'));?>
</div>
