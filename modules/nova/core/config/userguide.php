<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
	// Default userguide page.
	'default_page' => 'basics.about',
	
	// Enable these packages in the API browser.  TRUE for all packages, or a string of comma seperated packages, using 'None' for a class with no @package
	// Example: 'api_packages' => 'Kohana,Kohana/Database,Kohana/ORM,None',
	//'api_packages' => TRUE,
	'api_packages' => 'Kohana,Jelly,Nova,DBForge',
	
	// Class prefixes to ignore
	'api_prefix_ignore' => 'kohana_,nova_',
);