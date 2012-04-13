<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

// load the base config from the nova core
$base_config = Fuel::load(NOVAPATH.'nova/config/config.php');

// this is where people can override the base config
$app_config = array(

	/**
	 * index_file - The name of the main bootstrap file.
	 *
	 * Set this to false or remove if you using mod_rewrite.
	 */
	'index_file'  => 'index.php',

	/**
	 * Localization & internationalization settings
	 */
	'language'           => 'en', // Default language
	'language_fallback'  => 'en', // Fallback language when file isn't available for default language
	'locale'             => null, // PHP set_locale() setting, null to not set

	'encoding'  => 'UTF-8',

	/**
	 * DateTime settings
	 *
	 * server_gmt_offset	in seconds the server offset from gmt timestamp when time() is used
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	'server_gmt_offset'  => 0,
	'default_timezone'   => 'UTC',
);

// merge the two arrays
$merged_array = array_merge( (array) $base_config, (array) $app_config);

// make sure the items get unset
unset($base_config);
unset($app_config);

// return the merged array
return $merged_array;

/* End of file config.php */
