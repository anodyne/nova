<?php
/**
 * Module Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CatalogueModule extends Orm\Model {
	
	public static $_table_name = 'catalogue_modules';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'short_name' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'desc' => array(
			'type' => 'text'),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive'",
			'default' => 'active'),
		'credits' => array(
			'type' => 'text'),
	);
	
	/**
	 * Get all the modules from the catalogue.
	 *
	 * @access	public
	 * @param	string	the status of modules
	 * @return	object	an object with the results
	 */
	public static function get_all_entries($status = 'active')
	{
		return static::find()->where('status', $status);
	}
}
