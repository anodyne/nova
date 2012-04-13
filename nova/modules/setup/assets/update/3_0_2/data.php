<?php
/**
 * File that handles all data changes to the database.
 *
 * 3.0.1 => 3.0.2
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

$system_info		= null;

/**
 * Build the data used by the system for version info
 */
$system_info = array(
	'last_update'		=> time(),
	'version_major'		=> 3,
	'version_minor'		=> 0,
	'version_update'	=> 2
);
