<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Preferences Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Userpref extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('user_prefs');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'pref_id'
			)),
			'key' => new Field_String(array(
				'column' => 'pref_key'
			)),
			'label' => new Field_String(array(
				'column' => 'pref_label'
			)),
			'default' => new Field_String(array(
				'column' => 'pref_default'
			)),
		));
	}
}