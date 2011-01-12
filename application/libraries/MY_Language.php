<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Matchbox Language Class
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

class MY_Language extends CI_Language
{

	// {{{ Matchbox

	function module_load($module = FALSE, $langfile = '', $idiom = '', $return = FALSE)
	{
		return $this->load($langfile, $idiom, $return, $module);
	}

	// }}}

	function load($langfile = '', $idiom = '', $return = FALSE, $module = FALSE)
	{
		$langfile = str_replace(EXT, '', str_replace('_lang', '', $langfile)).'_lang'.EXT;

		if (in_array($langfile, $this->is_loaded, TRUE))
		{
			return;
		}

		// {{{ Matchbox

		$CI =& get_instance();

		if ($idiom == '')
		{
			$deft_lang = $CI->config->item('language');
			$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		}

		if ($mb_file = $CI->load->_mb_load('language/'.$idiom.'/'.$langfile, $module, TRUE))
		{
			include($mb_file);
		}
		else
		{
			show_error('Matchbox: Unable to load the requested language file: language/'.$langfile);
		}

		if ( ! isset($lang))
		{
			log_message('error', 'Matchbox: Language file contains no data: language/'.$idiom.'/'.$langfile);
			return;
		}

		// }}}

		if ($return == TRUE)
		{
			return $lang;
		}

		$this->is_loaded[] = $langfile;
		$this->language = array_merge($this->language, $lang);
		unset($lang);

		// {{{ Matchbox

		log_message('debug', 'Matchbox: Language file loaded: language/'.$idiom.'/'.$langfile);

		// }}}

		return TRUE;
	}

}

/* End of file MY_Language.php */
/* Location: ./system/application/libraries/MY_Language.php */