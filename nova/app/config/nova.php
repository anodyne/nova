<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'app_name' => 'Nova',
	'app_version_full' => '3.0m3',
	'app_version_major' => 3,
	'app_version_minor' => 0,
	'app_version_update' => 0,
	
	# TODO: remove before final release
	'app_dev_build' => '20101205',
	
	'wiki_name' => 'Thresher',
	'wiki_version_full' => 'Release 3',
	'wiki_version_major' => 2,
	'wiki_version_minor' => 0,
	'wiki_version_update' => 0,
	
	'version_info' => MODPATH.'app/modules/setup/assets/update/version.yaml',
	//'version_info' => 'http://www.anodyne-productions.com/feeds/version_nova.yaml',
	
	'app_db_tables' => 60,
	'environment' => Kohana::DEVELOPMENT,
);
