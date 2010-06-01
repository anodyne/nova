<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Setting extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * *This model is automatically initialized by the base controller as <code>$this->mSettings</code>. The only time you
	 * need to initialize this class is in the event you are not working with the base controller.*
	 *
	 * @return	void
	 */
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
	
	/**
	 * Pulls back specific settings from the database based on their setting key.
	 *
	 *     $settings = $this->mSettings->get_settings('sim_name');
	 *     $settings = $this->mSettings->get_settings(array('sim_name', 'sim_year'));
	 *
	 * @param	mixed	key(s) to pull back from the database
	 * @return	array 	an array of setting keys
	 */
	public static function get_settings($value)
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