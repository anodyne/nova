<?php
/**
 * Rank Info Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Rank_Info extends \Model {
	
	public static $_table_name = 'rank_info_';
	
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
			'constraint' => 20,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);

	/**
	 * Relationships
	 */
	public static $_has_many = array(
		'ranks' => array(
			'model_to' => '\\Model_Rank',
			'key_to' => 'info_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Since the table name is appended with the genre, we can't hard-code
	 * it in to the model. The _init method is necessary since PHP won't
	 * allow creating an object project that's dynamic. This method changes
	 * the name of the table once the class is loaded.
	 *
	 * @internal
	 * @return	void
	 */
	public static function _init()
	{
		static::$_table_name = static::$_table_name.\Config::get('nova.genre');
	}
}
