<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Setting extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'setting_id'
			)),
			'key' => new Field_String(array(
				'column' => 'setting_key'
			)),
			'value' => new Field_Text(array(
				'column' => 'setting_value'
			)),
			'label' => new Field_String(array(
				'column' => 'setting_label'
			)),
			'user_created' => new Field_Enum(array(
				'column' => 'setting_user_created',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
	
	public static function get_settings($value = '')
	{
		$array = FALSE;
		
		if (is_array($value))
		{
			$select = $value;
		}
		else
		{
			$select[] = $value;
		}
		
		$query = Jelly::select('setting')->execute();
		
		if ($query)
		{
			foreach ($query as $i)
			{
				if (in_array($i->key, $select))
				{
					$array[$i->key] = $i->value;
				}
			}
		}
		
		return $array;
	}
}

// End of file setting.php
// Location: modules/nova/classes/model/setting.php