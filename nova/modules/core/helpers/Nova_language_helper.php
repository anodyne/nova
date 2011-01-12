<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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
if ( ! function_exists('lang_output'))
{
	function lang_output($line, $element = 'p', $class = NULL, $nl2br = TRUE)
	{
		$CI =& get_instance();
		$line = $CI->lang->line($line);
		$class_var = NULL;
		
		/* set the class variable */
		$class_var = (isset($class)) ? ' class="' . $class . '"' : NULL;
		
		/* set the content */
		$content = ($nl2br == TRUE) ? nl2br($line) : $line;
		
		/* set the elements */
		$start_element = ($element == '') ? NULL : '<'. $element . $class_var .'>';
		$end_element = ($element == '') ? NULL : '</'. $element .'>';
		
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
if ( ! function_exists('text_output'))
{
	function text_output($text = '', $element = 'p', $class = NULL, $nl2br = TRUE)
	{
		/* set the class variable */
		$class_var = (isset($class)) ? ' class="' . $class . '"' : NULL;
		
		/* set the content */
		$content = ($nl2br == TRUE) ? nl2br($text) : $text;
		
		/* set the elements */
		$start_element = ($element == '') ? NULL : '<'. $element . $class_var .'>';
		$end_element = ($element == '') ? NULL : '</'. $element .'>';
		
		/* set up the entire element */
		$retval = $start_element . $content . $end_element;
		
		/* return the element */
		return $retval;
	}
}
