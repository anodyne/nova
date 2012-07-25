<?php
/**
 * Application Rule Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Application_Rule extends \Model {
	
	public static $_table_name = 'application_rules';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'global'),
		'condition' => array(
			'type' => 'text',
			'null' => true),
		'users' => array(
			'type' => 'text',
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'character' => array(
			'model_to' => '\\Model_Application',
			'key_to' => 'id',
			'key_from' => 'app_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function get_items($only_active = true)
	{
		$query = static::find();

		if ($only_active)
		{
			$query->where('status', (int) true);
		}

		return $query->get();
	}
}
