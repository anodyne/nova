<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Awards Received Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Awardrec extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('awards_received');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'awardrec_id'
			)),
			'user' => new Field_Integer(array(
				'column' => 'awardrec_user'
			)),
			'character' => new Field_Integer(array(
				'column' => 'awardrec_character'
			)),
			'nominated' => new Field_Integer(array(
				'column' => 'awardrec_nominated_by',
			)),
			'award' => new Field_BelongsTo(array(
				'column' => 'awardrec_award',
				'foreign' => 'award'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'awardrec_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'reason' => new Field_Text(array(
				'column' => 'awardrec_reason'
			)),
		));
	}
}