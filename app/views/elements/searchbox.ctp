<?php
if(isset($dcommittee)){
    $item_name = strlen($dcommittee['Committee']['item_name'])>2 ? $dcommittee['Committee']['item_name'] : 'Project';
}
?>
<div class="search">
    <h3><?php __('Filters') ?></h3>
    <div class="box">
    <?php echo $this->element('form_instructions', array('notefor'=>'filter')); ?>
<?php 
if ($from == 'meetings/view') {
    echo $form->create('Meeting',array('url'=>array('controller'=>'meetings','action'=>'view','committee'=>$this->params['pass'][0],'id'=>$this->params['id'])));

    echo $form->hidden('Search.meeting_id',array('value'=>$this->params['id']));
    echo $form->hidden('Search.from',array('value'=>$from));
    echo $html->div('',$form->label('Search.item', ucwords($item_name)).'&nbsp;'.
        $form->select(
            'Search.item',
            $options = $projects,
            (isset($cursearch_project) && $cursearch_project!='')?$cursearch_project:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)
        )
    );
    echo $html->div('',$form->label('Search.group', __('Group Implementor',true)).'&nbsp;'.
        $form->select('Search.group',
            $options = $groups,
            (isset($cursearch_group) && $cursearch_group!='')?$cursearch_group:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)     
        ));
    echo $html->div('',$form->label('Search.user', __('Individual Implementor',true)).'&nbsp;'.
        $form->select('Search.user',
            $options = $users,
            (isset($cursearch_user) && $cursearch_user!='')?$cursearch_user:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)     
        ));
    //echo $form->button('Submit', array('type'=>'submit'))

} else if ($from == 'items/view') {
    echo $form->create('Item',array('url'=>array('controller'=>'items','action'=>'view','committee'=>$this->params['pass'][0],'id'=>$this->params['id'])));

    echo $form->hidden('Search.item_id',array('value'=>$this->params['id']));
    echo $form->hidden('Search.from',array('value'=>$from));
    echo $html->div('',$form->label('Search.meeting', __('Meeting Num',true)).'&nbsp;'.
        $form->select('Search.meeting',
            $options = $meetings,
            //'',
            (isset($cursearch_group) && $cursearch_group!='')?$cursearch_group:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)     
        ));
    echo $html->div('',$form->label('Search.group', __('Group Implementor',true)).'&nbsp;'.
        $form->select('Search.group',
            $options = $groups,
            //'',
            (isset($cursearch_group) && $cursearch_group!='')?$cursearch_group:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)     
        ));
    echo $html->div('',$form->label('Search.user', __('Individual Implementor',true)).'&nbsp;'.
        $form->select('Search.user',
            $options = $users,
            //'',
            (isset($cursearch_user) && $cursearch_user!='')?$cursearch_user:null,
            array('onChange'=>'javascript:form.submit()'),
            __('--please select--',true)     
        ));

} else if ($from == 'users/index') { 
    echo $form->create('Users',array('url'=>array('controller'=>'users','action'=>'index')));

    echo $form->input('Search.username', array('value'=>$session->read('Search.username'),'label'=>__('Username',true)));
    echo $form->input('Search.name', array('value'=>$session->read('Search.name')));
    echo $form->input('Search.job_title', array('value'=>$session->read('Search.job_title')));
    echo $form->input('Search.email', array('value'=>$session->read('Search.email')));
    echo $html->div('',$form->label('Search.committee', __('Committee',true)).'&nbsp;'.$form->select('Search.committee',
        $options = $committee,
        $session->check('Search.committee') ? $session->read('Search.committee'):null,
        '', //attribute
        __('--please select--',true)     
    ));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'memberships/index') { 
    echo $form->create('Membership',array('url'=>array('controller'=>'memberships','action'=>'index','committee'=>$dcommittee['Committee']['short_name'])));
    echo $form->input('Search.name', array('value'=>$session->read('Search.name')));
    echo $form->input('Search.email', array('value'=>$session->read('Search.email')));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'titles/index') { 
    echo $form->create('Title',array('url'=>array('controller'=>'titles','action'=>'index')));
    echo $form->input('Search.short', array('value'=>$session->read('Search.short')));
    echo $form->input('Search.long', array('value'=>$session->read('Search.long')));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'roles/index') { 
    echo $form->create('Role',array('url'=>array('controller'=>'roles','action'=>'index')));
    echo $form->input('Search.name', array('value'=>$session->read('Search.name')));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'systemtodos/index' || $from == 'committeetodos/index') { 
    if ($from == 'committeetodos/index')  $url = array('controller'=>'committeetodos','action'=>'index','committee'=>$dcommittee['Committee']['short_name']);
    if ($from == 'systemtodos/index')  $url = array('controller'=>'systemtodos','action'=>'index');

    echo $form->create('Todo',array('url'=>$url));
    echo $form->input('Search.name', array('value'=>$session->read('Search.name')));
    echo $html->div('',$form->label('Search.priority', __('Priority',true)).'&nbsp;'.$form->select('Search.priority',
        $options = $priorities,
        $session->check('Search.priority') ? $session->read('Search.priority'):null,
        '', //attribute
        __('--please select--',true)     
    ));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'Templates/index' || $from == 'templates/index') { 
    if ($from == 'Templates/index')  $url = array('controller'=>'Templates','action'=>'index','committee'=>$dcommittee['Committee']['short_name']);
    else $url = array('controller'=>'templates','action'=>'index');

    echo $form->create('Template',array('url'=>$url));
    echo $form->input('Search.title', array('value'=>$session->read('Search.title'),'label'=>__('Message title',true)));
    echo $form->input('Search.description', array('value'=>$session->read('Search.description'),'size'=>'40'));
    echo $form->input('Search.message', array('value'=>$session->read('Search.message'),'size'=>'40','label'=>__('Message',true)));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'Groups/index') { 
    echo $form->create('Group',array('url'=>array('controller'=>'Groups','action'=>'index','committee'=>$dcommittee['Committee']['short_name'])));
    echo $form->input('Search.name', array('value'=>$session->read('Search.name')));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'logs/index') { 
    echo $form->create('Log',array('url'=>array('controller'=>'logs','action'=>'index')));
    echo $form->input('Search.user', array('value'=>$session->read('Search.name')));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

} else if ($from == 'logs/report') { 
    echo $form->create('Log',array('url'=>array('controller'=>'logs','action'=>'report')));
    echo $html->div('',$form->label('Search.report', __('Report',true)).'&nbsp;'.$form->select('Search.report',
        $options = $reporttype,
        $session->check('Search.report') ? $session->read('Search.report'):null,
        '', //attribute
        __('--please select--',true)     
    ));
    echo $html->div('',$form->button(__('Submit Criteria/s', true), array('type'=>'submit')).'&nbsp;'.$form->button(__('Cancel', true), array('type'=>'button', 'onclick'=>'history.go(-1)')));

}
?>  
    <?php echo $form->end();?>
    </div>
</div>


<p></p>
<?php 
// meeting/view, items/view have no pagination -> so no $paginator
if ($from != 'meetings/view' && $from != 'items/view' && $from != 'logs/report') 
    echo $html->div('num_of_records',__('No. of records:',true).' '.$paginator->counter(array('format'=>'%count%'))); 
?>
