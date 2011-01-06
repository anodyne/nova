<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Promotions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Characterpromotion extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('characters_promotions');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'prom_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'prom_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'prom_char',
				'foreign' => 'character'
			)),
			'old_order' => Jelly::field('integer', array(
				'column' => 'prom_old_order'
			)),
			'old_rank' => Jelly::field('string', array(
				'column' => 'prom_old_rank'
			)),
			'new_order' => Jelly::field('integer', array(
				'column' => 'prom_new_order'
			)),
			'new_rank' => Jelly::field('string', array(
				'column' => 'prom_new_rank'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'prom_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}
