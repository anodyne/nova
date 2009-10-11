<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Debug Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David VanScott
 */

// ------------------------------------------------------------------------

/**
 * Print Variable
 *
 * Print out the variable fed to the helper for debugging purposes
 *
 * @access	public
 * @param	string/array/object
 * @return	string
 */	
if ( ! function_exists('print_var'))
{
	function print_var($variable = '')
	{
		if (is_array($variable))
		{
			$type = 'array';
			$title = 'Array Output';
		}
		elseif (is_object($variable))
		{
			$type = 'object';
			$title = 'Object Output';
		}
		else
		{
			$type = 'variable';
			$title = 'Variable Output';
		}
		
		echo '<div style="background:#eee; border:1px solid #888; color:#444; width:75%; margin:auto;">';
		echo '<h5 style="font-weight:bold; font-size:1.2em; line-height:1.4em;">' . $title . '</h5>';
		
		switch ($type)
		{
			case 'array':
				echo '<pre>';
				print_r($variable);
				echo '</pre>';
				
				break;
			case 'object':
				echo '<pre>';
				print_r($variable);
				echo '</pre>';
				
				break;
			case 'variable':
				echo $variable;
				
				break;
		}
		
		echo '</div>';
	}
}
	
// ------------------------------------------------------------------------

/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */