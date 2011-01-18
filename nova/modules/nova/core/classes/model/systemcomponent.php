<?php defined('SYSPATH') or die('No direct script access.');
/**
 * System Versions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Systemcomponent extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('system_components');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'comp_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'comp_name'
			)),
			'version' => Jelly::field('string', array(
				'column' => 'comp_version'
			)),
			'url' => Jelly::field('string', array(
				'column' => 'comp_url'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'comp_desc'
			)),
		));
	}
}
