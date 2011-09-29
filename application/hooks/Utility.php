<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once MODPATH.'core/hooks/nova_utility.php';

class Utility extends Nova_utility {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Do not add any hooks to this file! If you need to add hooks
	 * to your installation, create your own class and add the hooks
	 * to your application/config/hooks.php file.
	 */
}
