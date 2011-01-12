<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('APP_NAME',				'Nova');

define('APP_VERSION',			'1.3.0');
define('APP_VERSION_MAJOR',		1);
define('APP_VERSION_MINOR',		3);
define('APP_VERSION_UPDATE',	0);

define('WIKI_NAME',				'Thresher');
define('WIKI_VERSION',			'Release 2');

define('SMS_UPGRADE_VERSION',	'2.6.9');

//define('VERSION_FEED', APPPATH . 'assets/version.yml');
define('VERSION_FEED', 'http://www.anodyne-productions.com/feeds/version_nova.yml');

/* figure out whether to install the bare essentials or the dev stuff */
define('APP_DATA_SRC', 'basic');
define('APP_DATA_DEV', FALSE);

/* figure out if the request is an ajax request */
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

/* CI_VERSION is available as a constant and is defined in ./core/codeigniter/CodeIgniter.php */