<?php
/*
 * Copyright (c) 2008 Government of Malaysia
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE REGENTS AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED.  IN NO EVENT SHALL THE REGENTS OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
 * OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
 * OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 * @author: Abdullah Zainul Abidin, Nuhaa All Bakry
 *          Eavay Javay Barnad, Sarogini Muniyandi
 *
 */

/* SVN FILE: $Id: autocomplete.php 2932 2006-05-23 04:25:29Z nate $ */

/**
 * Automagically handles requests for autocomplete fields
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c)    2006, Cake Software Foundation, Inc.
 *                                1785 E. Sahara Avenue, Suite 490-204
 *                                Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright        Copyright (c) 2006, Cake Software Foundation, Inc.
 * @link                http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package            cake
 * @subpackage        cake.cake.libs.controller.components
 * @since            CakePHP v 0.10.4.1076
 * @version            $Revision: 2932 $
 * @modifiedby        $LastChangedBy: nate $
 * @lastmodified    $Date: 2006-05-23 00:25:29 -0400 (Tue, 23 May 2006) $
 * @license            http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Autocomplete Handler
 *
 * @package        cake
 * @subpackage    cake.cake.libs.controller.components
 *
 */
class AutocompleteComponent extends Object {

/**
 * Define $layout
 *
 */
    var $layout = 'ajax';

/**
 * Define $enabled
 *
 */
    var $enabled = true;

/**
 * Define $components
 *
 */
    var $components = array('RequestHandler');

/**
 * Define $handles
 *
 */
    var $handles = array();

    /**
     * Startup
     *
     * @param object A reference to the controller
     * @return null
     */
/**
 * Describe startup
 *
 * @param $controller
 * @return null
 */
    function startup(&$controller) {
        exit();

        if (!$this->enabled || !$this->RequestHandler->isAjax() || !$this->RequestHandler->isPost()) {
            return true;
        }

        $data = $controller->data;
        if (empty($data) || count($data) != 1) {
            return false;
        }

        list($model) = array_keys($data);
        if (!is_array($data[$model]) || count($data[$model]) != 1 || !is_object($controller->{$model})) {
            return false;
        }

        list($field) = array_keys($data[$model]);
        $conditions = array();

        if (!empty($this->handles)) {

            $handled = false;
            $fields = array();

            foreach ($this->handles as $key => $val) {
                if (is_int($key)) {
                    $key = $val;
                    $val = array();
                }
                if ($key == $model.'.'.$field || $key == $field || $key == $model.'.*') {
                    $handled = true;
                    $conditions = $val;
                    break;
                }
            }
            if (!$handled) {
                return true;
            }
        }

        $base = array($model.'.'.$field => 'LIKE %'.$data[$model][$field].'%');
        if (!empty($conditions)) {
            $conditions = array($base, $conditions);
        } else {
            $conditions = $base;
        }

        $results = $controller->{$model}->findAll($conditions);

        if (is_array($results) && !empty($results)) {
            e("<ul>\n");
            foreach ($results as $rec) {
                if (isset($rec[$model][$field])) {
                    e("\t<li>".$rec[$model][$field]."</li>\n");
                }
            }
            e("</ul>\n");
        }
        exit();
    }
}

?> 
