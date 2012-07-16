<?php
/**
 * Migration Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Migration extends \Model {
	
	public static $_table_name = 'migration';
	
	public static $_properties = array(
		'name' => array(
			'type' => 'string',
			'constraint' => 50),
		'type' => array(
			'type' => 'string',
			'constraint' => 25),
		'version' => array(
			'type' => 'int',
			'constraint' => 11),
	);

	/**
	 * Because the migration table doesn't have a primary key, we can't use
	 * the query builder and need to do this with raw SQL.
	 */
	public static function get_version($item)
	{
		$item = \DB::query("SELECT * FROM ".\DB::table_prefix()."migration WHERE name = '$item'")
			->as_object()
			->execute()
			->current();

		return $item->version;
	}
}
