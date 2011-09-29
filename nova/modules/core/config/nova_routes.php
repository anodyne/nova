<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
| 	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There is one reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
*/

$route['default_controller'] = "main";
$route['404_override'] = '';

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
