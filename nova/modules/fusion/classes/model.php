<?php

class Model extends Fusion_Model {
	
	/**
	 * Create a an item.
	 *
	 * @access	public
	 * @param	mixed	an array or object of data
	 * @return	object	the newly created item
	 */
	public static function create_item($data)
	{
		$item = static::factory();
		
		foreach ($data as $key => $value)
		{
			if (is_array($data))
			{
				$item->{$key} = $data[$key];
			}
			else
			{
				$item->{$key} = $data->{$key};
			}
		}
		
		$item->save();
		
		return $item;
	}
}
