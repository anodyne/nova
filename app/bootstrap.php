<?php
/**
 * The full content of the bootstrap file is in the Nova core. If you need to do
 * anything to the bootstrap, you can override the default from here after the 
 * require statement.
 */

require NOVAPATH.'nova/bootstrap.php';

Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
));