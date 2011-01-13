<?php

define('INSTALL_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))).'/nova/');

/**
 * PHP & Database Error Reporting
 *
 * 0: No error reporting
 * 1: PHP fatal errors & database errors
 * 2: PHP compiler errors & database errors
 * 3: All PHP errors, warnings, noties & database errors
 */
 
$debug_errors = 3;

switch ($debug_errors)
{
	case 1:
		ini_set('display_errors', 1);
		error_reporting(E_ERROR);
		define('NOVA_DB_DEBUG', TRUE);
	break;
		
	case 2:
		ini_set('display_errors', 1);
		error_reporting(E_ERROR | E_PARSE);
		define('NOVA_DB_DEBUG', TRUE);
	break;
		
	case 3:
		ini_set('display_errors', 1);
		error_reporting(E_ALL);
		define('NOVA_DB_DEBUG', TRUE);
	break;
	
	default:
		ini_set('display_errors', 0);
		error_reporting(E_ERROR);
		define('NOVA_DB_DEBUG', FALSE);
	break;
}

/**
 * System folder name
 *
 * This variable must contain the name of your "system" folder. Include the path
 * if the folder is not in the same directory as this file.
 *
 * NO TRAILING SLASH!
 */

 $system_folder = INSTALL_ROOT."codeigniter";

/**
 * Modules folder name
 *
 * This variable must contain the name of your "modules" folder.
 *
 * NO TRAILING SLASH!
 */

$mods_folder = 'modules';
$modules_folder = INSTALL_ROOT.$mods_folder;
	
/**
 * Application folder name
 *
 * If you want this front controller to use a different "application" folder than
 * the default one, you can set its name here. The folder can also be renamed or
 * relocated anywhere on your server. For more information please see the user
 * guide - http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */

$abspath = getcwd();
$app_folder = 'application';

$application_folder = $abspath.'/'.$app_folder;

/*
|===============================================================
| END OF USER CONFIGURABLE SETTINGS
|===============================================================
*/

if (phpversion() < '5.1')
{
	header('Location: message.php?type=php');
	exit();
}

/**
 * Default timezone
 *
 * Set the default timezone for date/time functions to use if
 * none is set on the server. This prevents PHP 5.3+ from
 * throwing errors.
 */

if ( ! ini_get('date.timezone'))
{
	date_default_timezone_set('GMT');
}

/**
 * Set the server path
 *
 * Let's attempt to determine the full server path to the CodeIgniter
 * core folder in order to reduce the possibility of path problems.
 * Note: We only attempt this if the user hasn't specified a full
 * server path.
 */

if (strpos($system_folder, '/') === FALSE)
{
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)
	{
		$system_folder = realpath(dirname(__FILE__)).'/'.$system_folder;
	}
}
else
{
	// Swap directory separators to Unix style for consistency
	$system_folder = str_replace("\\", "/", $system_folder); 
}

/**
 * Define Application Constants
 *
 * EXT		- The file extension. Typically ".php"
 * FCPATH	- The full server path to THIS file
 * SELF		- The name of THIS file (typically "index.php")
 * BASEPATH	- The full server path to the CodeIgniter core files
 * APPPATH	- The full server path to the "application" folder
 * MODPATH	- The full server path to the core "modules" folder
 * APPFOLDER- The name of the "application" folder
 * MODFOLDER- The name of the core "modules" folder
 */

define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_folder.'/');

define('APPFOLDER', $app_folder);
define('MODFOLDER', $mods_folder);

if (is_dir($application_folder))
{
	define('APPPATH', $application_folder.'/');
}
else
{
	if ($application_folder == '')
	{
		$application_folder = 'application';
	}

	define('APPPATH', BASEPATH.$application_folder.'/');
}

if (is_dir($modules_folder))
{
	define('MODPATH', $modules_folder.'/');
}
else
{
	if ($modules_folder == '')
	{
		$modules_folder = 'modules';
	}

	define('MODPATH', INSTALL_ROOT.$modules_folder.'/');
}

/**
 * If the nova directory doesn't exist, it means that we're doing
 * maintenance on the site and should show the maintenance page.
 * If the directory does exist, then it's time to start executing
 * everything...
 */

if ( ! is_dir(INSTALL_ROOT))
{
	header('Location: message'.EXT.'?type=maintenance');
}
else
{
	require_once BASEPATH.'codeigniter/CodeIgniter'.EXT;
}
