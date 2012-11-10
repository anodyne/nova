<?php
/**
 * Rank Catalog Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Catalog_Rank extends \Model
{
	public static $_table_name = 'catalog_ranks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'preview' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'preview.png'),
		'blank' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'blank.png'),
		'extension' => array(
			'type' => 'string',
			'constraint' => 5,
			'default' => '.png'),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text'),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'genre' => array(
			'type' => 'string',
			'constraint' => 10,
			'null' => true),
	);
	
	/**
	 * The init function is necessary here since the default genre in the
	 * database is dynamic. PHP won't allow creating an object property that's
	 * dynamic, so we need this in order to change the table name once the
	 * class is loaded.
	 *
	 * @api
	 * @return	void
	 */
	public static function init()
	{
		static::$_properties['genre']['default'] = \Config::get('nova.genre');
	}
	
	/**
	 * Get all items from the catalog.
	 *
	 * @api
	 * @param	string	the status to pull
	 * @param	bool	whether to limit to the current genre or not
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE, $limit_to_genre = true)
	{
		$result = static::query();

		if ($limit_to_genre)
		{
			$result->where('genre', \Config::get('nova.genre'));
		}

		if ( ! empty($status))
		{
			$result->where('status', $status);
		}
		
		return $result->get();
	}
	
	/**
	 * Get the default rank catalog item.
	 *
	 * @api
	 * @param	bool	whether to return just the location value or the whole object
	 * @return	mixed
	 */
	public static function getDefault($value_only = false)
	{
		$result = static::query()->where('default', 1)->get_one();
		
		if ($value_only)
		{
			return $result->location;
		}
		
		return $result;
	}
}

Model_Catalog_Rank::init();
