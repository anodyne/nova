<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Preferences Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Userpref extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('user_prefs');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'pref_id'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'pref_key'
			)),
			'label' => Jelly::field('string', array(
				'column' => 'pref_label'
			)),
			'default' => Jelly::field('string', array(
				'column' => 'pref_default'
			)),
		));
	}
}