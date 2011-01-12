<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Matchbox Config Class
 * Copyright 2007, 2008, 2009 Zacharias Knudsen
 * Documentation: http://codeigniter.com/wiki/Matchbox/
 *
 * This file is part of Matchbox.
 *
 * Matchbox is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Matchbox is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public
 * License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Matchbox.  If not, see <http://www.gnu.org/licenses/>.
 */

class MY_Config extends CI_Config {

	// {{{ Matchbox

	function module_load($module = FALSE, $file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
	{
		return $this->load($file, $use_sections, $fail_gracefully, $module);
	}

	// }}}

	function load($file = '', $use_sections = FALSE, $fail_gracefully = FALSE, $module = FALSE)
	{
		$file = ($file == '') ? 'config' : str_replace(EXT, '', $file);

		if (in_array($file, $this->is_loaded, TRUE))
		{
			return TRUE;
		}

		// {{{ Matchbox

		$CI =& get_instance();

		if ( ! $mb_file = $CI->load->_mb_load('config/'.$file, $module))
		{
			if ($fail_gracefully === TRUE)
			{
				return FALSE;
			}
			show_error('Matchbox: The configuration file '.$file.EXT.' does not exist.');
		}

		include($mb_file);

		// }}}

		if ( ! isset($config) OR ! is_array($config))
		{
			if ($fail_gracefully === TRUE)
			{
				return FALSE;
			}

			// {{{ Matchbox

			show_error('Matchbox: Your '.$file.EXT.' file does not appear to contain a valid configuration array.');

			// }}}
		}

		if ($use_sections === TRUE)
		{
			if (isset($this->config[$file]))
			{
				$this->config[$file] = array_merge($this->config[$file], $config);
			}
			else
			{
				$this->config[$file] = $config;
			}
		}
		else
		{
			$this->config = array_merge($this->config, $config);
		}

		$this->is_loaded[] = $file;
		unset($config);

		// {{{ Matchbox

		log_message('debug', 'Matchbox: Config file loaded: config/'.$file.EXT);

		// }}}

		return TRUE;
	}

}

/* End of file MY_Config.php */
/* Location: ./system/application/libraries/MY_Config.php */