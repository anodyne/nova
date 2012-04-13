<?php
/**
 * Nav Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Nav extends \Model {
	
	public static $_table_name = 'navigation';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'group' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'url' => array(
			'type' => 'text',
			'null' => true),
		'url_target' => array(
			'type' => 'enum',
			'constraint' => "'onsite','offsite'",
			'default' => 'onsite'),
		'needs_login' => array(
			'type' => 'enum',
			'constraint' => "'y','n','none'",
			'default' => 'none'),
		'access' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'main'),
		'category' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'sim_type' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
	);
	
	/**
	 * Get a user from the database based on something other than their ID.
	 *
	 * @api
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

	/**
	 * Gets the nav items out of the database based on type and category.
	 *
	 * @api
	 * @param	string	the type of navigation (main, admin, sub, adminsub)
	 * @param	string	the category of navigation (main, personnel, sim, wiki)
	 * @param	bool	whether to pull displayed or hidden items (null to pull everything)
	 * @return	object
	 */
	public static function get_nav_items($type, $category, $display = true)
	{
		$query = static::find();

		if ( ! empty($type))
		{
			$query->where('type', $type);
		}

		if ( ! empty($category))
		{
			$query->where('category', $category);
		}

		if ($display !== null)
		{
			$query->where('display', (int) $display);
		}

		// set the ordering
		$query->order_by('group', 'asc')->order_by('order', 'asc');
		
		// run the query
		$items = $query->get();

		if (count($items) > 0)
		{
			return $items;
		}

		return false;
	}
}
