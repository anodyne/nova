<?php
/**
 * Module Catalog Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Catalog_Module extends \Model
{
	public static $_table_name = 'catalog_modules';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'short_name' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	/**
	 * Get all the modules from the catalog.
	 *
	 * @api
	 * @param	string	the status of modules
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE)
	{
		return static::find()->where('status', $status)->get();
	}
}
