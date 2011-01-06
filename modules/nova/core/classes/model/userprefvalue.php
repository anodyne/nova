<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Preferences Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Userprefvalue extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('user_prefs_values');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'prefvalue_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'prefvalue_user',
				'foreign' => 'user'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'prefvalue_key'
			)),
			'value' => Jelly::field('string', array(
				'column' => 'prefvalue_value'
			)),
		));
	}
}
