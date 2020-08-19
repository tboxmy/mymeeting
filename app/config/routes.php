<?php
/* SVN FILE: $Id: routes.php 6311 2008-01-02 06:33:52Z phpnut $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *                                1785 E. Sahara Avenue, Suite 490-204
 *                                Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright        Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link                http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package            cake
 * @subpackage        cake.app.config
 * @since            CakePHP(tm) v 0.2.9
 * @version            $Revision: 6311 $
 * @modifiedby        $LastChangedBy: phpnut $
 * @lastmodified    $Date: 2008-01-02 14:33:52 +0800 (Wed, 02 Jan 2008) $
 * @license            http://www.opensource.org/licenses/mit-license.php The MIT License
 */

function committeeitems($field_id){
    Router::connect("/:committee/project::itemid/:controller::$field_id/:action/:id/*",array(),array('pass'=>array('committee','itemid','id'),$field_id=>'[\d]+','itemid'=>'[\d]+'));
    Router::connect("/:committee/meeting::meetingid/:controller::$field_id/:action/:id/*",array(),array('pass'=>array('committee','meetingid','id'),$field_id=>'[\d]+','meetingid'=>'[\d]+'));
    Router::connect("/:committee/decision::decisionid/:controller::$field_id/:action/:id/*",array(),array('pass'=>array('committee','decisionid','id'),$field_id=>'[\d]+','decisionid'=>'[\d]+'));
    Router::connect("/:committee/project::itemid/:controller::$field_id/:action/*",array(),array('pass'=>array('committee','itemid'),$field_id=>'[\d]+','itemid'=>'[\d]+'));
    Router::connect("/:committee/meeting::meetingid/:controller::$field_id/:action/*",array(),array('pass'=>array('committee','meetingid'),$field_id=>'[\d]+','meetingid'=>'[\d]+'));
    Router::connect("/:committee/decision::decisionid/:controller::$field_id/:action/*",array(),array('pass'=>array('committee','decisionid'),$field_id=>'[\d]+','decisionid'=>'[\d]+'));
}

Router::connect('/login',array('controller'=>'users','action'=>'login'));
Router::connect('/logout',array('controller'=>'users','action'=>'logout'));
Router::connect('/calendar',array('controller'=>'committees','action'=>'calendar'));
Router::connect('/',array('controller'=>'committees','action'=>'mainpage'));
Router::connect('/profile',array('controller'=>'users','action'=>'profile'));
Router::connect('/hash/:hashstring',array('controller'=>'hashes','action'=>'hash'),array('pass'=>array('hashstring')));
Router::connect('/:committee/search/*',array('controller'=>'committees','action'=>'search'),array('pass'=>array('committee')));
Router::connect('/:controller/:action/*',array(),array('controller'=>'users|committees|ajaxes|titles|systemtodos|roles|templates|settings|logs|hashes'));

    committeeitems('group_id');
    committeeitems('user_id');

Router::connect('/:committee/project::itemid/:controller/:action/:id/*',array(),array('pass'=>array('committee','itemid','id'),'itemid'=>'[\d]+','id'=>'[\d]+'));
Router::connect('/:committee/meeting::meetingid/:controller/:action/:id/*',array(),array('pass'=>array('committee','meetingid','id'),'meetingid'=>'[\d]+','id'=>'[\d]+'));
Router::connect('/:committee/decision::decisionid/:controller/:action/:id/*',array(),array('pass'=>array('committee','decisionid','id'),'decisionid'=>'[\d]+','id'=>'[\d]+'));
Router::connect('/:committee/project::itemid/:controller/:action/*',array(),array('pass'=>array('committee','itemid'),'itemid'=>'[\d]+'));
Router::connect('/:committee/meeting::meetingid/:controller/:action/*',array(),array('pass'=>array('committee','meetingid'),'meetingid'=>'[\d]+'));
Router::connect('/:committee/decision::decisionid/:controller/:action/*',array(),array('pass'=>array('committee','decisionid'),'decisionid'=>'[\d]+'));


Router::connect('/:committee/:controller/:action/:id/*',array(),array('pass'=>array('committee','id'),'id'=>'[\d]+'));
Router::connect('/:committee/:controller/:action/*',array(),array('pass'=>array('committee')));

/* Languages settings */

Router::connect('/lang/*',array('controller'=>'p28n','action'=>'change'));
Router::connect('/eng?/*',array('controller'=>'p28n','action'=>'shuntRequest','lang'=>'eng'));
Router::connect('/bm?/*',array('controller'=>'p28n','action'=>'shuntRequest','lang'=>'may'));

?>
