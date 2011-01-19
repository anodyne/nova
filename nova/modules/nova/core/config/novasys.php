<?php defined('SYSPATH') or die('No direct script access.');

return array(
	/**
	 * Version Information
	 *
	 * This version information is used by the various pieces of the system
	 * to check for newer versions. Do not modify this information unless
	 * you know what you're doing, otherwise parts of the system will stop
	 * working.
	 */
	 
	'app_name' => 'Nova',
	'app_version_full' => '3.0m3',
	'app_version_major' => 3,
	'app_version_minor' => 0,
	'app_version_update' => 0,
	
	# TODO: remove this for final release
	'app_dev_build' => '20101205',
	
	/**
	 * Thresher Information
	 */
	 
	'wiki_name' => 'Thresher',
	'wiki_version_full' => 'Release 2',
	'wiki_version_major' => 1,
	'wiki_version_minor' => 1,
	'wiki_version_update' => 0,
	
	/**
	 * Version Information Feed
	 */
	 
	'version_info' => MODPATH.'nova/update/assets/version.yaml',
	//'version_info' => 'http://www.anodyne-productions.com/feeds/version_nova.yaml',
	
	/**
	 * System Information
	 */
	'app_db_tables' => 61,
	'environment' => Kohana::DEVELOPMENT,
);
