<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('GMT');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
$url = $_SERVER['SCRIPT_NAME'];
$url = substr($url, 0, strpos($url, '.php'));
$url = substr($url, 0, (strlen($url) - strpos(strrev($url), '/')));

Kohana::init(array(
	'base_url'   => $url,
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 *
 * NOTE: the array_slice in Hooks::modules should be working right, but
 * if anything is added to the modules array, we need to verify everything
 * is working properly with modules
 */
Kohana::modules(array(
	'override'		=> EXTPATH.'override',
	'thresher'		=> MODPATH.'nova/thresher',
	'veritas'		=> MODPATH.'nova/veritas',
	//'install'		=> MODPATH.'nova/install',
	//'update'		=> MODPATH.'nova/update',
	'setup'			=> MODPATH.'nova/setup',
	'assets'		=> MODPATH.'assets',
	'dbforge'		=> MODPATH.'nova/dbforge',
	'nova'			=> MODPATH.'nova/core',
	'database'		=> MODPATH.'kohana/database',
	'jelly'			=> MODPATH.'third_party/jelly',
	'htmlpurifier'	=> MODPATH.'third_party/purifier',
	'i18n'			=> MODPATH.'third_party/i18n',
	'cache'			=> MODPATH.'kohana/cache',
	'email'			=> MODPATH.'third_party/email',
	));

/**
 * Set the default language
 */
I18n::lang('en-us');

// set the Kohana environment
Kohana::$environment = Kohana::config('nova.environment');

/**
 * Set Kohana::$environment if $_ENV['KOHANA_ENV'] has been supplied.
 */
if (getenv('KOHANA_ENV') !== FALSE)
{
	Kohana::$environment = getenv('KOHANA_ENV');
}

/**
 * Set the exception handler
 */
//set_exception_handler(array('Nova_Exception_Handler', 'handle'));

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'main',
		'action'     => 'index',
	));
