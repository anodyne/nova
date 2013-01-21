<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Panel Helpers
 *
 * @package		Nova
 * @category	Helper
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

// ------------------------------------------------------------------------

/**
 * Dashboard
 *
 * Call the dashboard user panel library method
 *
 * @access	public
 * @param	boolean
 * @param	string
 * @return	string
 */	
if ( ! function_exists('panel_dashboard'))
{
	function panel_dashboard($text = TRUE, $content = '')
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		return $ci->user_panel->workflow_dashboard($text, $content);
	}
}
	
// ------------------------------------------------------------------------

/**
 * Inbox
 *
 * Call the inbox user panel library method
 *
 * @access	public
 * @param	boolean
 * @param	boolean
 * @param	boolean
 * @param	string
 * @param	string
 * @return	string
 */	
if ( ! function_exists('panel_inbox'))
{
	function panel_inbox($icon = TRUE, $text = TRUE, $count = TRUE, $count_dec = '(x)', $content = '')
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		return $ci->user_panel->workflow_inbox($icon, $text, $count, $count_dec, $content);
	}
}
	
// ------------------------------------------------------------------------

/**
 * Writing Entries
 *
 * Call the writing entries user panel library method
 *
 * @access	public
 * @param	boolean
 * @param	boolean
 * @param	boolean
 * @param	string
 * @param	string
 * @return	string
 */	
if ( ! function_exists('panel_writing'))
{
	function panel_writing($icon = TRUE, $text = TRUE, $count = TRUE, $count_dec = '(x)', $content = '')
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		return $ci->user_panel->workflow_writing($icon, $text, $count, $count_dec, $content);
	}
}
	
// ------------------------------------------------------------------------
