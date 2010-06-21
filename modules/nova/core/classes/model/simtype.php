<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sim Type Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Simtype extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('sim_type');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'simtype_id'
			)),
			'name' => new Field_String(array(
				'column' => 'simtype_name'
			)),
		));
	}
}