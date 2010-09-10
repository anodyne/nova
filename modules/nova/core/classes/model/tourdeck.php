<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Tour Decks Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Tourdeck extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('tour_decks');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'deck_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'deck_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'deck_order'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'deck_content',
			)),
		));
	}
}