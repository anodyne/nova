<?php
/**
 * Skin Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CatalogueSkin extends Orm\Model {
	
	public static $_table_name = 'catalogue_skins';
	
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
		'credits' => array(
			'type' => 'text'),
		'version' => array(
			'type' => 'string',
			'constraint' => 10,
			'default' => ''),
	);
	
	public static $_has_many = array(
		'sections' => array(
			'model_to' => 'Model_CatalogueSkinSec',
			'key_to' => 'skin',
			'key_from' => 'location',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all items from the catalogue.
	 *
	 * @access	public
	 * @param	string	the status to pull
	 * @return	object	an object of results
	 */
	public static function get_all_items($status = 'active')
	{
		$status_where = ( ! empty($status)) ? array('status', $status) : array();
		
		$result = static::find('all');
			
		return $result;
	}
	
	/**
	 * Create a catalogue item.
	 *
	 *     Model_CatalogueSkin::create_item($data);
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
