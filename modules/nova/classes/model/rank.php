<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Rank extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('ranks_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'rank_id'
			)),
			'name' => new Field_String(array(
				'column' => 'rank_name'
			)),
			'shortname' => new Field_String(array(
				'column' => 'rank_short_name',
			)),
			'image' => new Field_String(array(
				'column' => 'rank_image',
			)),
			'order' => new Field_Integer(array(
				'column' => 'rank_order',
			)),
			'display' => new Field_Enum(array(
				'column' => 'rank_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'class' => new Field_Integer(array(
				'column' => 'rank_class'
			))
		));
	}
}

// End of file rank.php
// Location: modules/nova/classes/model/rank.php