<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Utility Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Utility
{
	public function __construct()
	{
		Kohana_Log::Instance()->add('debug', 'Auth library initialized.');
	}
	
	public static function get_image_index($skin = '')
	{
		// load the base image index
		$common_index = Kohana::find_file('views', '_common/image_index');
		
		// load the skin's image index
		$skin_index = Kohana::find_file('views', $skin.'/image_index');
		
		// merge the files into an array
		$files = array_merge((array)$common_index, (array)$skin_index);
		
		// create the empty array
		$image_index = array();
		
		foreach ($files as $f)
		{
			//include $f;
			
			//$image_index = array_merge($image_index, $images);
		}
		
		return $image_index;
	}
	
	public static function print_character_name($value = '', $print_rank = TRUE, $short_rank_name = FALSE)
	{
		// load the core model
		$mCore = new Model_Core;
		
		if (is_array($value))
		{
			return self::_parse_name($value);
		}
		else
		{
			$args = array(
				'join'	=> array(
					array('ranks_'.Kohana::config('nova.genre'), 'ranks_'.Kohana::config('nova.genre').'.rank_id', 'characters.rank'),
				),
				'where' => array(
					array(
						'field' => 'charid',
						'value' => $value
					),
				),
			);
			$char = $mCore->get('characters', $args);
			
			if ($print_rank === TRUE)
			{
				$rank = ($short_rank_name === FALSE) ? $char->rank_name : $char->rank_short_name;
			}
			else
			{
				$rank = FALSE;
			}
			
			$segments = array(
				$rank,
				$char->first_name,
				$char->last_name,
				$char->suffix
			);
			
			return self::_parse_name($segments);
		}
	}
	
	public static function print_date($time = '')
	{
		// load the core model
		$mCore = new Model_Core;
		
		// get the date format
		$args = array(
			'where' => array(
				array(
					'field' => 'setting_key',
					'value' => 'date_format'
				),
			),
		);
		$format = $mCore->get('settings', $args);
		
		// get an instance of the session
		$session = Session::Instance();
		
		// set the timezone
		$timezone = $session->get('timezone', 'GMT');
		
		return date::mdate($format->setting_value, $time, $timezone);
	}
	
	public static function verify_server()
	{
		// grab the database config
		$db_config = Kohana::config('database.default');
		
		// grab the database version
		$version = db::query('SELECT version() AS ver')->execute()->current();
		
		$items = array(
			'php' => array(
				'required' => '5.2.4',
				'actual' => PHP_VERSION,
				'text' => __('verify.php_text', array(':php_req' => '5.2.4', ':php_act' => PHP_VERSION)),
				'failure' => TRUE),
			'db' => array(
				'required' => array('mysql', 'mysqli'),
				'actual' => $db_config['connection']['type'],
				'text' => __('verify.db_text'),
				'failure' => TRUE),
			'dbver' => array(
				'required' => '4.1',
				'actual' => $version['ver'],
				'text' => __('verify.dbver_text', array(':db_req' => '4.1', ':db_act' => $version['ver'])),
				'failure' => ($db_config['connection']['type'] == 'mysql') ? TRUE : FALSE),
			'reflection' => array(
				'required' => TRUE,
				'actual' => class_exists('ReflectionClass'),
				'text' => __('verify.reflection_text'),
				'failure' => TRUE),
			'filters' => array(
				'required' => TRUE,
				'actual' => function_exists('filter_list'),
				'text' => __('verify.filters_text'),
				'failure' => TRUE),
			'iconv' => array(
				'required' => TRUE,
				'actual' => extension_loaded('iconv'),
				'text' => __('verify.iconv_text'),
				'failure' => FALSE),
			'reflection' => array(
				'required' => TRUE,
				'actual' => class_exists('ReflectionClass'),
				'text' => __('verify.reflection_text'),
				'failure' => TRUE),
			'spl' => array(
				'required' => TRUE,
				'actual' => function_exists('spl_autoload_register'),
				'text' => __('verify.spl_text'),
				'failure' => TRUE),
			'mbstring' => array(
				'required' => TRUE,
				'actual' => extension_loaded('mbstring'),
				'text' => __('verify.mbstring_text'),
				'failure' => TRUE),
			'mbstring_overload' => array(
				'required' => TRUE,
				'actual' => ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING,
				'text' => __('verify.mbstring_overload_text'),
				'failure' => TRUE),
			'pcre_utf8' => array(
				'required' => TRUE,
				'actual' => ! @preg_match('/^.$/u', 'ñ'),
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
			'pcre_unicode' => array(
				'required' => TRUE,
				'actual' => ! @preg_match('/^\pL$/u', 'ñ'),
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
		);
		
		/* build the specs array */
		$specs = array(
			'php' => array(
				'req'	=> '5.2.4',
				'act'	=> PHP_VERSION),
			'db' => array(
				'req'	=> array('mysql', 'mysqli'),
				'act'	=> $db_config['connection']['type']),
			'dbver' => array(
				'req'	=> array('mysql' => '4.1', 'mysqli' => '-'),
				'act'	=> $version->ver),
			'regglobals' => array(
				'req'	=> ucfirst(__('word.off')),
				'act'	=> (ini_get('register_globals') == 1) ? ucfirst(__('word.on')) : ucfirst(__('word.off'))),
			'mem' => array(
				'req'	=> 8,
				'act'	=> substr(ini_get('memory_limit'), 0, -1)),
			'file' => array(
				'req'	=> ucfirst(__('word.on')),
				'act'	=> (ini_get('allow_url_fopen') == 1) ? ucfirst(__('word.on')) : ucfirst(__('word.off'))),
			'reflection' => array(
				'req'	=> ucfirst(__('word.on')),
				'act'	=> (class_exists('ReflectionClass')) ? ucfirst(__('word.on')) : ucfirst(__('word.off'))),
			'filters' => array(
				'req'	=> ucfirst(__('word.on')),
				'act'	=> (function_exists('filter_list')) ? ucfirst(__('word.on')) : ucfirst(__('word.off'))),
		);
		
		/* set the final result array */
		$final = array(
			'php' => (version_compare($specs['php']['act'], $specs['php']['req'], '<')) ? __('verify.failure') : __('verify.success'),
			'db' => (!in_array($specs['db']['act'], $specs['db']['req'])) ? __('verify.failure') : __('verify.success'),
			'dbver' => (version_compare($specs['dbver']['act'], $specs['dbver']['req'][$specs['db']['act']], '<')) ? __('verify.failure') : __('verify.success'),
			'regglobals' => ($specs['regglobals']['act'] != $specs['regglobals']['req']) ? __('verify.warning') : __('verify.success'),
			'mem' => ($specs['mem']['act'] < $specs['mem']['req']) ? __('verify.warning') : __('verify.success'),
			'file' => ($specs['file']['act'] != $specs['file']['req']) ? __('verify.warning') : __('verify.success'),
			'reflection' => ($specs['reflection']['act'] != $specs['reflection']['req']) ? __('verify.failure') : __('verify.success'),
			'filters' => ($specs['filters']['act'] != $specs['filters']['req']) ? __('verify.failure') : __('verify.success'),
		);
		
		$output = "<table class='table100 fontMedium'>\r\n";
			$output.= "\t<thead>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<th>".__('verify.component')."</th>\r\n";
					$output.= "\t\t\t<th>".__('verify.required')."</th>\r\n";
					$output.= "\t\t\t<th>".__('verify.actual')."</th>\r\n";
					$output.= "\t\t\t<th>".__('verify.result')."</th>\r\n";
				$output.= "\t\t</tr>\r\n";
			$output.= "\t</thead>\r\n";
			
			$output.= "\t<tbody>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.php')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['php']['req']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['php']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['php']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.db')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".implode(', ', $specs['db']['req'])."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['db']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['db']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.db_version')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".implode(', ', $specs['dbver']['req'])."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['dbver']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['dbver']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.regglobals')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['regglobals']['req']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['regglobals']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['regglobals']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.mem')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['mem']['req']."M</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['mem']['act']."M</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['mem']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.file')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['file']['req']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['file']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['file']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.reflection')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['reflection']['req']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['reflection']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['reflection']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
				$output.= "\t\t<tr>\r\n";
					$output.= "\t\t\t<td>".__('verify.filters')."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['filters']['req']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$specs['filters']['act']."</td>\r\n";
					$output.= "\t\t\t<td class='align-center'>".$final['filters']."</td>\r\n";
				$output.= "\t\t</tr>\r\n";
			$output.= "\t</tbody>\r\n";
		$output.= "</table>\r\n";
		
		/* set the data */
		
		//$ci->table->add_row(lang('verify_db'), implode(', ', $specs['db']['req']), $specs['db']['act'], $final['db']);
		//$ci->table->add_row(lang('verify_db_ver'), implode(', ', $specs['dbver']['req']), $specs['dbver']['act'], $final['dbver']);
		//$ci->table->add_row(lang('verify_regglobals'), $specs['regglobals']['req'], $specs['regglobals']['act'], $final['regglobals']);
		//$ci->table->add_row(lang('verify_mem'), $specs['mem']['req'] .'M', $specs['mem']['act'] .'M', $final['mem']);
		//$ci->table->add_row(lang('verify_file'), $specs['file']['req'], $specs['file']['act'], $final['file']);
		
		return $output;
	}
	
	private static function _check_requirements($reqs = '')
	{
		# code...
	}
	
	private static function _parse_name($value = '')
	{
		if (!is_array($value))
		{
			$value = array($value);
		}
		
		foreach ($value as $k => $v)
		{
			if (empty($v))
			{
				unset($value[$k]);
			}
		}
		
		return implode(' ', $value);
	}
}

// End of file utility.php
// Location: modules/nova/classes/nova/utility.php