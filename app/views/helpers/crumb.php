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
 
class CrumbHelper extends Helper
{
var $link_class    = 'crumb_link'    ;    // css class for anchor tags.
var $span_class    = 'crumb_span'    ;    // css class for the span element .(last label).
var $separator    = ' > '            ;    // separator between links.
var $protocol    = 'http'            ;
var $helpers     = Array("Session");

function addThisPage($title = null, $action = null , $level = null )    // add the calling page
{
    define('THIS_URL' , $this->protocol.  '://' . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI']) ;

    $controller       =    $this->params['controller']    ;
    $action            =    $this->params['action']        ;

    if (is_null($title)) {
        $title = Inflector::humanize($controller);
    }

    if ($action == 'reset' )    { // add this argument if it comes from menu.
        $this->Session->del('crumb_links') ;
        $this->Session->del('crumb_titles') ;
        $this->Session->del('crumb_levels') ;
    }
    if ( !isset($_SESSION['crumb_links'])) {
        $_SESSION['crumb_links'] = array() ;
        $_SESSION['crumb_titles'] = array() ;
        $_SESSION['crumb_levels'] = array() ;
    }
    $arr_links    = $this->Session->read('crumb_links')    ;
    $arr_titles    = $this->Session->read('crumb_titles');
    $arr_levels    = $this->Session->read('crumb_levels');

    if (is_null($level) AND $this->params['action'] != 'index' && $level != 'auto') {
        $level = $controller ;
    }
    if ( $level == 'unique'){
        $level = $controller . '_' . $action ;
    }

    // check that same level exists. if yes strip all after it.
    if ( is_array($arr_levels)) {
        $level_found_at    =    array_search($level, $arr_levels );
    }
    if (is_numeric($level_found_at)) {
        $arr_links    = $this->__stripAfter($arr_links    , $level_found_at  )        ;                // Delete items after current
        $arr_titles    = $this->__stripAfter($arr_titles    , $level_found_at  )        ;                // Delete items after current
        $arr_levels    = $this->__stripAfter($arr_levels    , $level_found_at  )        ;                // Delete items after current
        // reindex
        unset($arr_links[$level_found_at] )    ;
        unset($arr_titles[$level_found_at] );
        unset($arr_levels[$level_found_at] );
        $arr_links    = array_values( $arr_links )     ;
        $arr_titles    = array_values( $arr_titles )     ;
        $arr_levels    = array_values( $arr_levels )     ;
    }
    // check last item is current page. if not, add, else do nothing.
    if ( is_array($arr_titles)) {
        $found_at    =    array_search($title, $arr_titles);
    }
    if ( is_numeric($found_at)) {    //            ;    // already in the link, don't add
        $arr_links    = $this->__stripAfter($arr_links    , $found_at  )    ;                // Delete items after current
        $arr_titles    = $this->__stripAfter($arr_titles    , $found_at  )    ;                // Delete items after current
        $arr_links[count($arr_links) - 1]    =     THIS_URL            ;
    } else { // not in list, add
        $arr_links[]    =     THIS_URL;
        $arr_titles[]    =    $title    ;
        $arr_levels[]    =    $level    ;
    }

    //write back to session
    $_SESSION['crumb_links'] = $arr_links ;
    $_SESSION['crumb_titles'] = $arr_titles ;
    $_SESSION['crumb_levels'] = $arr_levels ;

}

/**
 * Add called page to the Bredcrumb session array and returns the new breadcrumb string.
 * @param string $title        : Title for the href tag.
 * @param string $action     : predefined actions, now supports 'reset'.
 * @param string $level        : Page level. Calling controller name by default.
 */
function getHtml($title = null, $action=null, $level = null)
{
    $this->addThisPage($title, $action, $level)    ;

    $arr_links    = $this->Session->read('crumb_links') ;
    $arr_titles    = $this->Session->read('crumb_titles') ;
    $last_index    = count($arr_titles) - 1        ;
    $string        = '' ;
    for ($i = 0  ; $i <= $last_index  ; $i++) {
        $title    =    $arr_titles[$i]    ;
        $link    =    $arr_links[$i]    ;
        if ($i < $last_index) { // no need to build link for last item
            $link = sprintf('<a href="%s" class="%s">%s</a> %s ', $link, $this->link_class, $title, $this->separator)        ;
        } else {
            $link = sprintf("<span class='%s'>%s</span>", $this->span_class, $title )                    ;     //last text, ie current page without link
        }
        $string    .=  $link                            ;
    }
    return $string;
}


 function __stripAfter($arr, $after)
{
    $count = count($arr)    ;
    for ($i = $after + 1 ; $i < $count ; $i++ ) {
        unset($arr[$i])    ;
    }
    return $arr ;
}
}
?> 
