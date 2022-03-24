<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ExiteCMS
 *
 * An open source application development framework for PHP 5+
 * ExiteCMS is based on CodeIgniter, Copyright (c) Ellislab Inc.
 *
 * Lang library extension to language lines to be loaded from modules
 *
 * @package		ExiteCMS
 * @author		WanWizard
 * @copyright	Copyright (c) 2010, ExiteCMS.org
 * @link		http://www.exitecms.org
 * @filesource
 */

// ---------------------------------------------------------------------

class MY_Lang extends CI_Lang
{
	private $CI = NULL;

	/**
	 * Fetch a single line of text from the language array
	 *
	 * Our version has support for Modular CIs language sections, which are
	 * enabled by the module config value 'use_language_array'.
	 *
	 * It also returns the requested line value if not found, instead of FALSE
	 *
	 * @access	public
	 * @param	string	$line 		the language line
	 * @param	string	$module 	the module it has to come from
	 * @return	string
	 */
	function line($line = '', $module = NULL)
	{
		// get the CI superobject
		if ( ! $this->CI )
		{
			$this->CI =& get_instance();
		}

		// check if a section name is passed
		if (is_null($module))
		{
			// No section: default CodeIgniter behaviour
			$line = ($line == '' OR ! isset($this->language[$line])) ? $line : $this->language[$line];
		}
		else
		{
			$line = ($line == '' OR ! isset($this->language[$module][$line])) ? $line : $this->language[$module][$line];
		}

		return $line;
	}

}

/* End of file MY_Language.php */
/* Location: ./application/libraries/MY_Language.php */
