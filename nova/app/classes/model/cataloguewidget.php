<?php
/**
 * Widgets Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CatalogueWidget extends Model {
	
	public static $_table_name = 'catalogue_widgets';
	
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
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'zone' => array(
			'type' => 'int',
			'constraint' => 3),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','development'",
			'default' => 'active'),
		'credits' => array(
			'type' => 'text'),
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
		
		$result = static::find()
			->where($status_where)
			->get();
			
		return $result;
	}
}
