<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Table Row Spacer
 *
 * Generates a spacer row in a table
 *
 * @access	public
 * @param	integer
 * @param	integer
 * @return	string
 */	
if ( ! function_exists('table_row_spacer'))
{
	function table_row_spacer($cols = 1, $height = 1)
	{
		return "<tr height='" . $height . "'><td colspan='" . $cols . "'></td></tr>";
	}
}

// ------------------------------------------------------------------------
