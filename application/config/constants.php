<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb');	// truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| HTML Entities
|--------------------------------------------------------------------------
|
| These definitions are used in the language files to give us properly formatted
| HTML entities for different characters
|
| http://www.cookwood.com/html/extras/entities.html
|
*/

define('RSQUO',		'&#8217;');		/* right single quote */
define('NDASH',		'&#8211;');		/* en dash */
define('RARROW',	'&raquo;');		/* right double arrow */
define('LARROW',	'&laquo;');		/* left double arrow */
define('AMP',		'&amp;');		/* left double arrow */

/*
| -------------------------------------------------------------------
|  System Constants
| -------------------------------------------------------------------
| Constants used by Nova.
|
*/

define('APP_NAME',				'Nova');
define('APP_VERSION',			'1.0.3');
define('APP_VERSION_MAJOR',		1);
define('APP_VERSION_MINOR',		0);
define('APP_VERSION_UPDATE',	3);

define('WIKI_NAME',				'Thresher');
define('WIKI_VERSION',			'Release 1');

define('SMS_UPGRADE_VERSION',	'2.6.9');

//define('VERSION_FEED', APPPATH . 'assets/version.yml');
define('VERSION_FEED', 'http://www.anodyne-productions.com/feeds/version_nova.yml');

/* figure out whether to install the bare essentials or the dev stuff */
define('APP_DATA_SRC', 'basic');

/* figure out if the request is an ajax request */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

/* CI_VERSION is available as a constant and is defined in ./core/codeigniter/CodeIgniter.php */

/* End of file constants.php */
/* Location: ./application/config/constants.php */