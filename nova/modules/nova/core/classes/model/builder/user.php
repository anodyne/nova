<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_User extends Jelly_Builder {
	
	/**
	 * Calculates the status of the user based on their characters.
	 *
	 *     $status = Jelly::query('user', 1)->get_status();
	 *
	 * @return	string 	a string of the status of the user (active, inactive, pending)
	 */
	public function get_status()
	{
		$query = $this->select();
		
		if (($query->main_char === null) or ($query->main_char->id == 0))
		{
			$status = 'inactive';
		}
		else
		{
			if (count($query->characters) > 0)
			{
				foreach ($query->characters as $c)
				{
					$chars[] = $c['status'];
				}
				
				if (in_array('active', $chars))
				{
					$status = 'active';
				}
				elseif ( ! in_array('active', $chars) and in_array('pending', $chars))
				{
					$status = 'pending';
				}
				elseif ( ! in_array('active', $chars) and ! in_array('pending', $chars))
				{
					$status = 'inactive';
				}
			}
			else
			{
				$status = 'inactive';
			}
		}
		
		return $status;
	}
}
