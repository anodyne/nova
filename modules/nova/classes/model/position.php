<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Position Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Position extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('positions_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'pos_id'
			)),
			'name' => new Field_String(array(
				'column' => 'pos_name'
			)),
			'desc' => new Field_Text(array(
				'column' => 'pos_desc',
			)),
			'dept' => new Field_BelongsTo(array(
				'column' => 'pos_dept',
				'foreign' => 'department'
			)),
			'order' => new Field_Integer(array(
				'column' => 'pos_order',
			)),
			'open' => new Field_Integer(array(
				'column' => 'pos_open',
			)),
			'display' => new Field_Enum(array(
				'column' => 'pos_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'type' => new Field_Enum(array(
				'column' => 'pos_type',
				'choices' => array('senior','officer','enlisted','other'),
				'default' => 'officer'
			))
		));
	}
}