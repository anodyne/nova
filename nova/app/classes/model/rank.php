<?php
/**
 * Rank Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Rank extends Model {
	
	public static $_table_name = 'ranks_';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'short_name' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'image' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'class' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 1),
	);
	
	/**
	 * The init function is necessary here since the name of the ranks
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
	
	public static function get_ranks($class = '', $display = true)
	{
		if ( ! empty($class))
		{
			$where[] = array('class', $class);
		}
		
		if ( ! empty($display))
		{
			$where[] = array('display', (int) $display);
		}
		
		$result = static::find('all', array(
			'where' => $where,
			'order_by' => array(
				array('class' => 'asc', 'order' => 'asc')
			),
		));
			
		return $result;
	}
}

Model_Rank::init();
