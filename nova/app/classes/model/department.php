<?php
/**
 * Department Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Department extends Model {
	
	public static $_table_name = 'departments_';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'desc' => array(
			'type' => 'text'),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'playing','nonplaying'",
			'default' => 'playing'),
		'parent_id' => array(
			'type' => 'int',
			'constraint' => 10,
			'default' => 0),
		'manifest_id' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
	);
	
	public static $_belongs_to = array(
		'dept' => array(
			'model_to' => 'Model_Manifest',
			'key_to' => 'id',
			'key_from' => 'manifest_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static $_has_many = array(
		'positions' => array(
			'model_to' => 'Model_Position',
			'key_to' => 'dept_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * The init function is necessary here since the name of the departments
	 * table is dynamic. PHP won't allow creating an object property that's
	 * dynamic, so we need this in order to change the table name once the
	 * class is loaded.
	 *
	 * @access	public
	 * @return	void
	 */
	public static function init()
	{
		static::$_table_name = static::$_table_name.Kohana::config('nova.genre');
	}
}

Model_Department::init();
