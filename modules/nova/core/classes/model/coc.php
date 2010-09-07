<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Chain of Command Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Coc extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('coc');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'coc_id'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'coc_crew',
				'foreign' => 'character'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'coc_order'
			)),
		));
	}
}