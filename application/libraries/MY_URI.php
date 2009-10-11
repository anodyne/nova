<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

class MY_URI extends CI_URI {
	
	/**
	 * Fetch a URI Segment
	 *
	 * This function returns the URI segment based on the number provided.
	 *
	 * @access	public
	 * @param	integer
	 * @param	bool
	 * @return	string
	 */
	function segment($n, $no_result = FALSE, $numeric = FALSE, $values = NULL)
	{
		if ($numeric === TRUE)
		{
			if (isset($this->segments[$n]))
			{
				return ( ! is_numeric($this->segments[$n])) ? $no_result : $this->segments[$n];
			}
			
			return $no_result;
		}
		
		if ($values !== NULL)
		{
			if (isset($this->segments[$n]))
			{
				if (is_array($values))
				{
					return ( ! in_array($this->segments[$n], $values)) ? $no_result : $this->segments[$n];
				}
				else
				{
					return ($this->segments[$n] != $values) ? $no_result : $this->segments[$n];
				}
			}
			
			return $no_result;
		}
		
		return ( ! isset($this->segments[$n])) ? $no_result : $this->segments[$n];
	}

	// --------------------------------------------------------------------
}

/* End of file URI.php */
/* Location: ./system/libraries/URI.php */