<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.6 => 1.1
 *
 * @package		Update
 * @author		Anodyne Productions
 */

$system_versions	= NULL;
$system_info		= NULL;

/**
 * Build the data used by the system for version info
 */
$system_versions = array(
	'version'	=> '1.1.0',
	'major'		=> 1,
	'minor'		=> 1,
	'update'	=> 0,
	'date'		=> 1275865200,
	'launch'	=> "Nova 1.1 is the first update to Nova that adds additional features to the system. Included in this release is the ability to create multiple specification items and to associate tour items with specific specification items as well as bug fixes (a bug where editing existing tour items wouldn't update the current item, but the first item). A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'changes'	=> "* added the 1.1 update file
* added the ability to have multiple specification items
* added the ability to associate tour items with a specification item
* added the fancybox plugin
* added the jquery reflection plugin
* added _specitem\_select_ language item in the text\_lang file
* added _specitem\_empty\_fields_ lanuage item in the text\_lang file
* removed the colorbox plugin
* removed the reflection.js plugin
* updated the system to use the new jquery reflection plugin instead of reflection.js
* updated the image upload system to be able to handle spec images as well
* updated the specifications model with new methods for handling spec items
* updated the mission groups listing with a style fix
* updated jquery ui to version 1.8.4
* fixed bug where ordered and unordered lists weren't properly styled in Thresher
* fixed bug in mission group pages where missions didn't respect the mission order that was set for them
* fixed bug where the private message dropdown didn't populate with an author when replying to a message"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 1,
	'version_update'	=> 0
);

/**
  * jquery ui version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'jQuery UI')->set(array('version' => '1.8.4'))->update();

/**
 * reflection plugin info
 */
Jelly::query('systemcomponent')->where('name', '=', 'Reflection.js')
	->set(array(
		'name' => 'jQuery Reflection',
		'version' => '1.0.3',
		'desc' => "This is an improved version of the reflection.js script rewritten for the jQuery Javascript library. It allows you to add instantaneous reflection effects to your images in modern browsers, in less than 2 KB.",
		'url' => 'http://www.digitalia.be/software/reflectionjs-for-jquery'
	))
	->update();

/**
 * add the fancybox plugin to the list of components
 */
Jelly::factory('systemcomponent')
	->set(array(
		'name' => 'FancyBox',
		'version' => '1.3.1',
		'desc' => "FancyBox is a tool for displaying images, HTML content and multi-media in a Mac-style 'lightbox' that floats overtop of web page. 
	It was built using the jQuery library and is licensed under both MIT and GPL licenses.",
		'url' => 'http://fancybox.net/home'
	))
	->save();

/**
 * remove the colorbox plugin from the list of components
 */
$item = Jelly::query('systemcomponent')->where('name', '=', 'jQuery ColorBox')->limit(1)->select();
$item->delete();

/**
 * update the specs data
 */

// get the specs data
$specs = $this->db->get_where('specs_data', array('data_value !=' => ''));

// if there is specs data, then continue with updating it
if ($specs->num_rows() > 0)
{
	/**
	 * update all the specs data to point to the first specification item
	 */
	$this->db->update('specs_data', array('data_item' => 1));
	
	/**
	 * create a new specification item from the sim name
	 */
	$name = $this->db->get_where('settings', array('setting_key' => 'sim_name'));
	$name = ($name->num_rows() > 0) ? $name->row() : FALSE;
	$specitem = array(
		'specs_name' => $name->setting_value,
		'specs_summary' => 'Summary for the '. $name->setting_value,
	);
	$this->db->insert('specs', $specitem);
}

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();