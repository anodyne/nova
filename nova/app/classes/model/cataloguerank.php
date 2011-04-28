<?php
/**
 * Rank Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CatalogueRank extends Model {
	
	public static $_table_name = 'catalogue_ranks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
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
			'type' => 'enum',
			'constraint' => "'active','inactive','development'",
			'default' => 'active'),
		'credits' => array(
			'type' => 'text'),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'genre' => array(
			'type' => 'string',
			'constraint' => 10,
			'default' => ''),
	);
	
	/**
	 * The init function is necessary here since the default genre in the
	 * database is dynamic. PHP won't allow creating an object property that's
	 * dynamic, so we need this in order to change the table name once the
	 * class is loaded.
	 *
	 * @access	public
	 * @return	void
	 */
	public static function init()
	{
		static::$_properties['genre']['default'] = Config::get('nova.genre');
	}
	
	/**
	 * Get all items from the catalogue.
	 *
	 * @access	public
	 * @param	string	the status to pull
	 * @param	bool	whether to limit to the current genre or not
	 * @return	object	an object of results
	 */
	public static function get_all_items($status = 'active', $limit_to_genre = true)
	{
		$genre_where = ($limit_to_genre) ? array('genre', Config::get('nova.genre')) : array();
		$status_where = ( ! empty($status)) ? array('status', $status) : array();
		
		$result = static::find()
			->where($genre_where)
			->where($status_where)
			->get();
			
		return $result;
	}
	
	/**
	 * Get the default rank catalogue item.
	 *
	 *     $default = Model_CatalogueRank::get_default();
	 *
	 * @access	public
	 * @param	boolean	whether to return just the location value or the whole object
	 * @return	mixed	the catalogue object or a string with the location
	 */
	public static function get_default($value_only = false)
	{
		$result = static::find('first', array(
			'where' => array('default', 1)
		));
		
		if ($value_only)
		{
			$result->location;
		}
		
		return $result;
	}
	
	/**
	 * Get a specific catalogue item.
	 *
	 *     $catalogue = Model_CatalogueRank::get_item('default');
	 *
	 * @access	public
	 * @param	string	the item to pull
	 * @param	string	the identifier to use
	 * @return	object	the catalogue object
	 */
	public static function get_item($item, $identifier = 'location')
	{
		$result = static::find('first', array(
			'where' => array($identifier, $item)
		));
		
		return $result;
	}
	
	/**
	 * Create a catalogue item.
	 *
	 *     Model_CatalogueRank::create_item($data);
	 *
	 * @access	public
	 * @param	mixed	an array or object of data
	 * @return	object	the newly created item
	 */
	public static function create_item($data)
	{
		$item = static::factory();
		
		foreach ($data as $key => $value)
		{
			if (is_array($data))
			{
				$item->{$key} = $data[$key];
			}
			else
			{
				$item->{$key} = $data->{$key};
			}
		}
		
		$item->save();
		
		return $item;
	}
}

Model_CatalogueRank::init();
