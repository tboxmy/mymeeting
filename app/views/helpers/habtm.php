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

class HabtmHelper extends HtmlHelper {
    /**
     * Returns a list of checkboxes.
     *
     * @param string $fieldName Name attribute of the SELECT
     * @param array $options Array of the elements (as 'value'=>'Text' pairs)
     * @param array $selected Selected checkboxes
     * @param string $inbetween String that separates the checkboxes.
     * @param array $htmlAttributes Array of HTML options
     * @param  boolean $return         Whether this method should return a value
     * @return string List of checkboxes
     */ 
    function checkboxMultiple($fieldName, $options, $selected = null, $inbetween = null, $htmlAttributes = null, $return = false)
    {
        $checkboxmultiple = '<input type="checkbox" name="data[%s][%s][]" %s/>%s';
        $hiddenmultiple = '<input type="hidden" name="data[%s][%s][]" %s/>';

        $this->setFormTag($fieldName);
        if ($this->tagIsInvalid($this->model(), $this->field())) {
            if (isset($htmlAttributes['class']) && trim($htmlAttributes['class']) != "") {
                $htmlAttributes['class'] .= ' form_error';
            } else {
                $htmlAttributes['class'] = 'form_error';
            }
        }
        if (!is_array($options)) {
            return null;
        }

        if (!isset($selected)) {
            $selected = $this->tagValue($fieldName);
        }
        foreach($options as $name => $title) {
            $optionsHere = $htmlAttributes;
            if (($selected !== null) && ($selected == $name)) {
                $optionsHere['checked'] = 'checked';
            } else if (is_array($selected) && array_key_exists($name, $selected)) {
                $optionsHere['checked'] = 'checked';
            }
            $optionsHere['value'] = $name;
            $checkbox[] = "<li>" . sprintf($checkboxmultiple, $this->model(), $this->field(), $this->_parseAttributes($optionsHere), $title) . "</li>\n";
        }
        return "\n" . sprintf($hiddenmultiple, $this->model(), $this->field(), null, $title) . "\n<ul class=\"checkboxMultiple\">\n" . $this->output(implode($checkbox), $return) . "</ul>\n";

    } /// checkboxMultiple() 
}
?>
