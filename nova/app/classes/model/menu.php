<?php
/**
 * Menu Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Menu extends Model {
	
	public static $_table_name = 'menu_items';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'group' => array(
			'type' => 'int',
			'constraint' => 4),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'url' => array(
			'type' => 'text'),
		'url_target' => array(
			'type' => 'enum',
			'constraint' => "'onsite','offsite'",
			'default' => 'onsite'),
		'needs_login' => array(
			'type' => 'enum',
			'constraint' => "'y','n','none'",
			'default' => 'none'),
		'use_access' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'access' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'access_level' => array(
			'type' => 'int',
			'constraint' => 4,
			'default' => '0'),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'main','sub','adminsub'",
			'default' => 'main'),
		'category' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'sim_type' => array(
			'type' => 'int',
			'constraint' => 5),
	);
	
	/**
	 * Get a user from the database based on something other than their ID.
	 *
	 * @access	public
	 * @param	string	the column to use
	 * @param	mixed	the value to use
	 * @return	object	a user object
	 */
	public static function get_menu_item($column, $value)
	{
		if (in_array($column, static::$_properties))
		{
			return static::find()->where($column, $value)->get_one();
		}
		
		return false;
	}
}
