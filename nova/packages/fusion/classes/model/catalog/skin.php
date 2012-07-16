<?php
/**
 * Skin Catalog Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Catalog_Skin extends \Model {
	
	public static $_table_name = 'catalog_skins';
	
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
		'credits' => array(
			'type' => 'text',
			'null' => true),
		'version' => array(
			'type' => 'string',
			'constraint' => 10,
			'null' => true),
	);
	
	public static $_has_many = array(
		'sections' => array(
			'model_to' => '\\Model_Catalog_SkinSec',
			'key_to' => 'skin',
			'key_from' => 'location',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all items from the catalog.
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
}
