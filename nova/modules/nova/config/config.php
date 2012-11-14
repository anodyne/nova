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

return array(

	/**
	 * index_file - The name of the main bootstrap file.
	 *
	 * Set this to false or remove if you using mod_rewrite.
	 */
	'index_file'  => 'index.php',

	/**
	 * Localization & internationalization settings
	 */
	'locale'             => null, // PHP set_locale() setting, null to not set

	/**
	 * DateTime settings
	 *
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	'default_timezone'   => 'UTC',

	/**
	 * Security settings
	 */
	'security' => array(
		'csrf_token_key'   => 'nova_csrf_token',
		
		/**
		 * Whether to automatically filter view data
		 */
		'auto_filter_output'  => false,
	),

	/**
	 * To enable you to split up your application into modules which can be
	 * routed by the first uri segment you have to define their basepaths
	 * here. By default empty, but to use them you can add something
	 * like this:
	 *      array(APPPATH.'modules'.DS)
	 */
	'module_paths' => array(
		APPPATH.'modules'.DS,
		NOVAPATH,
	),


	/**************************************************************************/
	/* Always Load                                                            */
	/**************************************************************************/
	'always_load'  => array(

		/**
		 * These packages are loaded on Fuel's startup.  You can specify them in
		 * the following manner:
		 *
		 * array('auth'); // This will assume the packages are in PKGPATH
		 *
		 * // Use this format to specify the path to the package explicitly
		 * array(
		 *     array('auth'	=> PKGPATH.'auth/')
		 * );
		 */
		'packages'  => array(
			'fusion',
			'orm',
			'sentry',
			'swiftmailer',
			'carbon',
		),

		/**
		 * These modules are always loaded on Fuel's startup. You can specify them
		 * in the following manner:
		 *
		 * array('module_name');
		 *
		 * A path must be set in module_paths for this to work.
		 */
		'modules'  => array(
			'nova',
			'override',
			'setup',
			'wiki',
			'login',
		),
	),
);
