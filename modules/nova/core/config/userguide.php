<?php defined('SYSPATH') or die('No direct script access.');

return array(
	// Default userguide page.
	'default_page' => 'basics.about',
	
	// Enable these packages in the API browser.  true for all packages, or a string of comma seperated packages, using 'None' for a class with no @package
	// Example: 'api_packages' => 'Kohana,Kohana/Database,Kohana/ORM,None',
	//'api_packages' => true,
	'api_packages' => 'Kohana,Jelly,Nova,DBForge',
	
	// Class prefixes to ignore
	'api_prefix_ignore' => 'kohana_,nova_',
);