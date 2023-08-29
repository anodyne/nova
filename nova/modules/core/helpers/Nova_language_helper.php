<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Language Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/language_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Output
 *
 * Fetches a language variable and outputs that text with an HTML element
 *
 * @access	public
 * @param	string	the language line
 * @param	string	the element (P by default, can also be an H tag)
 * @return	string
 */
if (! function_exists('lang_output')) {
    function lang_output($line, $element = 'p', $class = null, $nl2br = true)
    {
        $CI =& get_instance();
        $line = $CI->lang->line($line);
        $class_var = null;

        /* set the class variable */
        $class_var = (isset($class)) ? ' class="' . $class . '"' : null;

        /* set the content */
        $content = ($nl2br == true) ? nl2br($line) : $line;

        /* set the elements */
        $start_element = ($element == '') ? null : '<'. $element . $class_var .'>';
        $end_element = ($element == '') ? null : '</'. $element .'>';

        /* set up the entire element */
        $retval = $start_element . $content . $end_element;

        /* return the element */
        return $retval;
    }
}

// ------------------------------------------------------------------------

/**
 * Text Output
 *
 * Outputs text with an HTML element
 *
 * @access	public
 * @param	string	the text
 * @param	string	the element (P by default, can also be an H tag)
 * @param	string	a class
 * @return	string
 */
if (! function_exists('text_output')) {
    function text_output($text = '', $element = 'p', $class = null, $nl2br = true)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        $content = $purifier->purify(($nl2br == true) ? nl2br($text) : $text);

        if (blank($element)) {
            return $content;
        }

        return sprintf(
            '<%s%s>%s</%s>',
            $element,
            _stringify_attributes(['class' => $class]),
            $content,
            $element
        );
    }
}

if (! function_exists('blank')) {
    function blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (! function_exists('filled')) {
    function filled($value)
    {
        return ! blank($value);
    }
}
