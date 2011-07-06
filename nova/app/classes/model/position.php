<?php
/**
 * Position Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Position extends Model {
	
	public static $_table_name = 'positions_';
	
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
		'dept_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'open' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'senior','officer','enlisted','other'",
			'default' => 'officer'),
	);
	
	public static $_belongs_to = array(
		'dept' => array(
			'model_to' => 'Model_Department',
			'key_to' => 'id',
			'key_from' => 'dept_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get positions based on criteria passed to the method.
	 *
	 * @access	public
	 * @param	string	the scope of the positions to pull (all, open)
	 * @param	int		the department to pull (works for all scopes)
	 * @param	bool	whether to show displayed positions or not (null for both)
	 * @return	object	an object with the results
	 */
	public static function get_positions($scope = 'all', $dept = null, $display = true)
	{
		$query = static::find();
		
		if ( ! empty($display))
		{
			$query->where('display', (int) $display);
		}
		
		switch ($scope)
		{
			case 'open':
				$query->where('open', '>', 0);
			break;
		}
		
		if ( ! empty($dept) and is_numeric($dept))
		{
			$query->where('dept_id', $dept);
		}
		
		// we should always be using the dept and position order to order the results
		$query->order_by('dept_id', 'asc');
		$query->order_by('order', 'asc');
		
		return $query->get();
	}

	/**
	 * The init function is necessary here since the name of the positions
	 * table is dynamic. PHP won't allow creating an object property that's
	 * dynamic, so we need this in order to change the table name once the
	 * class is loaded.
	 *
	 * @access	public
	 * @return	void
	 */
	public static function init()
	{
		static::$_table_name = static::$_table_name.Kohana::$config->load('nova.genre');
	}
}

Model_Position::init();
