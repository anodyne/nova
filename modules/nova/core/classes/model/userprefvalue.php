<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Preferences Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Userprefvalue extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('user_prefs_values');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'prefvalue_id'
			)),
			'user' => new Field_BelongsTo(array(
				'column' => 'prefvalue_user',
				'foreign' => 'user'
			)),
			'key' => new Field_String(array(
				'column' => 'prefvalue_key'
			)),
			'value' => new Field_String(array(
				'column' => 'prefvalue_value'
			)),
		));
	}
}