<?php
/**
 * Rank Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Rank extends \Model {
	
	public static $_table_name = 'ranks_';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'info_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'set_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'base' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'pip' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'info' => array(
			'model_to' => '\\Model_Rank_Info',
			'key_to' => 'id',
			'key_from' => 'info_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'set' => array(
			'model_to' => '\\Model_Rank_Set',
			'key_to' => 'id',
			'key_from' => 'set_id',
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
	
	/**
	 * Get all of the ranks.
	 *
	 * @api
	 * @param	int		the class ID
	 * @param	mixed	pull ranks that should be displayed (null to pull everything)
	 * @return	mixed	an object of the rank results or FALSE if there's nothing to return
	 */
	public static function get_ranks($class = null, $display = true)
	{
		// start to query the database
		$result = static::find();

		if ($class !== null)
		{
			$result->where('class', $class);
		}
		
		if ( ! empty($display))
		{
			$result->where('display', (int) $display);
		}

		// make sure we order properly
		$result->order_by('class', 'asc')->order_by('order', 'asc');

		// only return an object if we have results
		if ($result->count() > 0)
		{
			return $result->get();
		}
		
		return false;
	}
}
