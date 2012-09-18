<?php
/**
 * Widgets Catalog Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Catalog_Widget extends \Model
{
	public static $_table_name = 'catalog_widgets';
	
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
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'zone' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'credits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	/**
	 * Get all items from the catalog.
	 *
	 * @api
	 * @param	string	the status to pull
	 * @return	object
	 */
	public static function getItems($status = \Status::ACTIVE)
	{
		$status_where = ( ! empty($status)) ? array('status', $status) : array();
		
		$result = static::find()
			->where($status_where)
			->get();
			
		return $result;
	}
}
