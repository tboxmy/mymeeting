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
            <?php __('MyMeeting'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $html->charset();
        echo $html->meta('icon');
        echo $html->css('popup');
        echo $scripts_for_layout;
        ?>
    </head>

    <body>
        <?php
        if ($session->check('Message.flash')):
        $session->flash();
        endif;
        ?>
        <?php echo $content_for_layout; ?>
    </body>

</html>