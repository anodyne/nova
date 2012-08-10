<?php
/**
 * This data is intended to be used for development purposes only.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

/**
 * Data array with the table/array names used
 */
$data = array(
	'announcements',
);

/**
 * Arrays of data with the information being inserted into the database
 */
$announcements = array(
	array(
		'title' => "",
		'user_id' => 1,
		'character_id' => 1,
		'category_id' => 1,
		'date' => time(),
		'content' => "",
		'status' => 'activated',
		'private' => (int) false,
		'tags' => "",
	),
);