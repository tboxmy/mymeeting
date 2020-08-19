<?php
/* SVN FILE: $Id: default.ctp 6311 2008-01-02 06:33:52Z phpnut $ */
/**
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
* @subpackage        cake.cake.libs.view.templates.layouts
* @since            CakePHP(tm) v 0.10.0.1076
* @version            $Revision: 6311 $
* @modifiedby        $LastChangedBy: phpnut $
* @lastmodified    $Date: 2008-01-02 14:33:52 +0800 (Wed, 02 Jan 2008) $
* @license            http://www.opensource.org/licenses/mit-license.php The MIT License
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            <?php echo Configure::read('agency_name')." | "; ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $html->charset();
        echo $html->meta('icon');
        echo $html->css('mymeeting');
        echo $scripts_for_layout;
        ?>
        <!--[if IE]>
            <?php echo $html->css('ie'); ?>
        <![endif]-->
    </head>

    <body>
        <div id="container">
            <table border="0" cellpadding="0" cellspacing="0" class="maintable">
            <tr>
                <td class="left">&nbsp;</td>
                <td class="middle" width="100%">
                    <div id="header">
                        <?php echo $html->image($img_path, array('class'=>'floatleft')); ?>
                        <p>&nbsp;</p>
                        <h1>
                        <?php echo $html->link(Configure::read('agency_name'),array("controller"=>"users","action"=>"alert")) ?>
                        </h1>
                    </div>
                    
                    <div id="top">
                    <?php if(isset($auth_user) && $this->params['action']!='login') :?>
                        <div id="topright"><?php echo $this->element('personal_links');  ?></div>
                        <?php if($show_adminmenu) :?>
                        <div id="topleft"><?php echo $this->element('adminmenu'); ?></div>
                        <?php endif;?>
                    <?php endif; ?>
                    </div>

                    <div id="content">
                        <?php if($show_sidemenu) :?>
                            <div id="rightside">
                            <?php echo $this->element('rightside'); ?>
                            </div>
                            <div id="middlehasright">
                                <?php if ($session->check('Message.flash')) $session->flash(); ?>
                                <?php echo $content_for_layout; ?>
                            </div>
                        <?php else: ?>
                            <div id="middle">
                                <?php if ($session->check('Message.flash')) $session->flash(); ?>
                                <?php echo $content_for_layout; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div id="footer">
                        <?php __('Powered by MyMeeting')?>
                        <?php echo Configure::read('version') ?> &nbsp;
                    </div>

                </td>
                <td class="right">&nbsp;</td>
            </tr>
            <tr>
                <td class="bottomleft">&nbsp;</td>
                <td class="bottom">
                    <div class="bright">&nbsp;</div>
                    <div class="bleft">&nbsp;</div>
                </td>
                <td class="bottomright">&nbsp;</td>
            </tr>
            </table>
        </div>

    </body>

</html>
