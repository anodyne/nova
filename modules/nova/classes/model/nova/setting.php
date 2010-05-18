<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Nova_Setting extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_settings($value = '')
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
		
		$query = db::select()->from('settings')->as_object()->execute();
		
		if ($query)
		{
			foreach ($query as $i)
			{
				if (in_array($i->setting_key, $select))
				{
					$array[$i->setting_key] = $i->setting_value;
				}
			}
		}
		
		return $array;
	}
}

// End of file setting.php
// Location: modules/nova/classes/model/nova/setting.php