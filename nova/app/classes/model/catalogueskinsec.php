<?php
/**
 * Skin Section Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CatalogueSkinSec extends Model {
	
	public static $_table_name = 'catalogue_skinsecs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'skin' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'preview' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','development'",
			'default' => 'active'),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);
	
	public static $_belongs_to = array(
		'skins' => array(
			'model_to' => 'Model_CatalogueSkin',
			'key_to' => 'location',
			'key_from' => 'skin',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get the default skin section catalogue item.
	 *
	 * @access	public
	 * @param	string	the section to pull
	 * @return	object	the catalogue object
	 */
	public static function get_default($section)
	{
		return static::find('first', array(
			'where' => array(
				array('default', 1),
				array('section', $section),
			)
		));
	}
	
	/**
	 * Create a catalogue item.
	 *
	 *     Model_CatalogueSkinSec::create_item($data);
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
