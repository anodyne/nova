<?php
/**
 * Skin Section Catalog Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Catalog_SkinSec extends \Model
{
	public static $_table_name = 'catalog_skinsecs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'skin' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'preview' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'nav' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => 'dropdown'),
	);
	
	public static $_belongs_to = array(
		'skins' => array(
			'model_to' => '\\Model_Catalog_Skin',
			'key_to' => 'location',
			'key_from' => 'skin',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get the default skin section catalog item.
	 *
	 * @api
	 * @param	string	the section to pull
	 * @return	object
	 */
	public static function getDefault($section, $value_only = false)
	{
		$result = static::find()
			->where(array('default', 1))
			->where(array('section', $section))
			->get_one();
		
		if ($value_only)
		{
			return $result->skin;
		}
		
		return $result;
	}

	/**
	 * Get the catalog item.
	 *
	 * @api
	 * @param	string	the column to use
	 * @param	string	the value to use
	 * @return	object
	 */
	public static function getCatalog($column, $value)
	{
		$item = static::find()
			->where($column, $value)
			->get_one();

		if (count($item) > 0)
		{
			return $item;
		}

		return false;
	}
}
