<?php
/**
 * User Preferences Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_UserPref extends Model {
	
	public static $_table_name = 'user_prefs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'default' => array(
			'type' => 'text'),
	);
}
