<?php
/**
 * Model class
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Model extends \Orm\Model
{	
	/**
	 * Create a an item.
	 *
	 * @api
	 * @param	mixed	an array or object of data
	 * @param	bool	should the object be returned?
	 * @return	mixed	a boolean by default, or the object
	 */
	public static function create_item($data, $return_object = false, $filter = true)
	{
		// create a forge
		$item = static::forge();
		
		// loop through the data and add it to the item
		foreach ($data as $key => $value)
		{
			if ($key != 'id' and array_key_exists($key, static::$_properties))
			{
				if (is_array($data))
				{
					if ($filter)
					{
						$item->{$key} = trim(\Security::xss_clean($data[$key]));
					}
					else
					{
						$item->{$key} = $data[$key];
					}
				}
				else
				{
					if ($filter)
					{
						$item->{$key} = trim(\Security::xss_clean($data->{$key}));
					}
					else
					{
						$item->{$key} = $data->{$key};
					}
				}
			}
		}
		
		if ($item->save())
		{
			if ($return_object)
			{
				return $item;
			}

			return true;
		}
		
		return false;
	}
	
	/**
	 * Find an item in the table based on the arguments passed to the method.
	 *
	 * @api
	 * @param	array	the data to use to find the item
	 * @return	object	an object
	 */
	public static function find_item(array $args)
	{
		$record = static::find();
		
		foreach ($args as $column => $value)
		{
			if (array_key_exists($column, static::$_properties))
			{
				$record->where($column, $value);
			}
		}
		
		$result = $record->get_one();
		
		return $result;
	}

	/**
	 * Find a form item.
	 *
	 * @api
	 * @param	string	the form key to use
	 * @return	object	the form object
	 */
	public static function find_form_items($key)
	{
		return static::find()->where('form_key', $key)->order_by('order', 'asc')->get();
	}
	
	/**
	 * Update an item in the table.
	 *
	 * @api
	 * @param	mixed	a specific ID to update or NULL to update everything
	 * @param	array 	the array of data to update with
	 * @param	bool	should the data be run through the XSS filter
	 * @return	bool
	 */
	public static function update_item($id, array $data, $return_object = false, $filter = true)
	{
		if ($id !== null)
		{
			// get the item
			$item = static::find($id);
			
			// loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				if ($key != 'id' and array_key_exists($key, static::$_properties))
				{
					if ($filter)
					{
						$value = trim(\Security::xss_clean($value));
					}

					$item->{$key} = $value;
				}
			}
			
			// save the item
			if ($item->save())
			{
				if ($return_object)
				{
					return $item;
				}

				return true;
			}

			return false;
		}
		else
		{
			// pull everything from the table
			$items = static::find('all');
			
			// loop through all the items
			foreach ($items as $item)
			{
				// loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					if ($filter)
					{
						$value = trim(\Security::xss_clean($value));
					}

					$item->{$key} = $value;
				}
				
				// save the item
				$item->save();
			}

			return true;
		}
	}
	
	/**
	 * Delete an item in the table based on the arguments passed to the method.
	 *
	 * @api
	 * @param	mixed	the data to use to find the item
	 * @return	bool
	 */
	public static function delete_item($args)
	{
		$item = static::find();
		
		if (is_array($args))
		{
			foreach ($args as $column => $value)
			{
				if (array_key_exists($column, static::$_properties))
				{
					$item->where($column, $value);
				}
			}
		}
		else
		{
			$item->where('id', $args);
		}

		if ($item->delete(null, true))
		{
			return true;
		}
		
		return false;
	}
}
