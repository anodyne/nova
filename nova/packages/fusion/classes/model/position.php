<?php
/**
 * Position Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Position extends \Model {
	
	public static $_table_name = 'positions_';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'dept_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'open' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'senior','officer','enlisted','other'",
			'default' => 'officer'),
	);
	
	/**
	 * Relationships
	 */
	protected static $_belongs_to = array(
		'dept' => array(
			'model_to' => '\\Model_Department',
			'key_to' => 'id',
			'key_from' => 'dept_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'applicants' => array(
			'model_to' => '\\Model_Application',
			'key_to' => 'position_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_many_many = array(
		'characters' => array(
			'key_from' => 'id',
			'key_through_from' => 'position_id',
			'table_through' => 'character_positions',
			'key_through_to' => 'character_id',
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Position' => array(
			'events' => array('before_delete', 'after_insert', 'after_update')
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
	
	/**
	 * Get positions based on criteria passed to the method.
	 *
	 * @api
	 * @param	string	the scope of the positions to pull (all, open)
	 * @param	int		the department to pull (works for all scopes)
	 * @param	bool	whether to show displayed positions or not (null for both)
	 * @return	object
	 */
	public static function get_positions($scope = 'all', $dept = null, $display = true)
	{
		// grab the genre
		$genre = \Config::get('nova.genre');

		$query = static::query();
		
		if ( ! empty($display))
		{
			$query->where('display', (int) $display);
		}
		
		switch ($scope)
		{
			case 'all_playing':
				$query->related('dept')->where('dept.type', 'playing');
			break;

			case 'all_nonplaying':
				$query->related('dept')->where('dept.type', 'nonplaying');
			break;

			case 'open':
				$query->where('open', '>', 0);
			break;

			case 'open_playing':
				$query->related('dept')
					->where('dept.type', 'playing')
					->where('open', '>', 0);
			break;

			case 'open_nonplaying':
				$query->related('dept')
					->where('dept.type', 'nonplaying')
					->where('open', '>', 0);
			break;
		}
		
		if ( ! empty($dept) and is_numeric($dept))
		{
			$query->where('dept_id', $dept);
		}
		
		// we should always be using the dept and order to order the results
		$query->order_by('dept_id', 'asc');
		$query->order_by('order', 'asc');
		
		return $query->get();
	}
}
