<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'main';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/*
| -------------------------------------------------------------------------
| ROUTES FOR MODULES
| -------------------------------------------------------------------------
*/

// your URI doesn't have to start with a module name
//$route['site/(:any)/(.*)'] = 'modulerouter/$1/$2';			// only do module routing for this module

// your module URI can be constructed from different URI parts
//$route['(:any)/controller/(.*)'] = 'modulerouter/$1/$2';	// use different segments to route to the module

// you can also route on a per-module bases
//$route['example/(.*)'] = 'modulerouter/example/$1';			// only do module routing for this module

// you can choose to route all your standard application controllers first
// and everything else to the module router
//$route['(welcome|test)(.*)'] = '$1$2';	// welcome.php and test.php are application controllers
//$route['(.*)'] = 'modulerouter/$1';						// everything is assumed to be a module
