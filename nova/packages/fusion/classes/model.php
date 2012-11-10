<?php
/**
 * The model class is the foundation for all of Nova's models and provides core
 * functionality that's shared across a lot of the models used in Nova,
 * including creating a new items, updating an existing item, finding items
 * based on criteria, and deleting items.
 *
 * Because these methods are the basis for the majority of CRUD operations in 
 * Nova models, any changes to this class should be done carefully and 
 * deliberately since they can cause wide ranging issues if not done properly.
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
	 * Create an item with the data passed.
	 *
	 * @api
	 * @param	mixed	an array or object of data
	 * @param	bool	should the object be returned?
	 * @param	bool	should the data be filtered?
	 * @return	mixed
	 */
	public static function createItem($data, $return_object = false, $filter = true)
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
						$item->{$key} = \Security::xss_clean($data[$key]);
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
						$item->{$key} = \Security::xss_clean($data->{$key});
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
	 * Find a record/records in the table based on the simple arguments.
	 *
	 * @api
	 * @param	string	the column to use
	 * @param	mixed	the value to use
	 * @param	bool	is this for a search?
	 * @return	object
	 */
	public static function getItem($value, $column, $search = false)
	{
		if (is_array($value))
		{
			// start the find
			$record = static::query();
			
			// loop through the arguments and build the where clause
			foreach ($value as $col => $val)
			{
				if (array_key_exists($col, static::$_properties))
				{
					$record->where($col, $val);
				}
			}
			
			// get the record
			return $record->get_one();
		}
		else
		{
			if (array_key_exists($column, static::$_properties))
			{
				if ( ! $search)
				{
					return static::query()->where($column, $value)->get_one();
				}

				return static::query()->where($column, 'like', $value)->get();
			}
		}
		
		return false;
	}

	/**
	 * Find a form item based on the form key.
	 *
	 * @api
	 * @param	string	the form key to use
	 * @param	bool	pull back displayed items (true) or all items (false)
	 * @return	object
	 */
	public static function getFormItems($key, $only_active = false)
	{
		// get the object
		$items = static::query();

		// make sure we're pulling back the right form
		$items->where('form_key', $key);

		// should we be getting all items or just enabled ones?
		if ($only_active)
		{
			$items->where('status', \Status::ACTIVE);
		}

		// order the items
		$items->order_by('order', 'asc');

		// return the object
		return $items->get();
	}
	
	/**
	 * Update an item in the table based on the ID and data.
	 *
	 * @api
	 * @param	mixed	a specific ID to update or NULL to update everything
	 * @param	array 	the array of data to update with
	 * @param	bool	should the data be run through the XSS filter
	 * @return	mixed
	 */
	public static function updateItem($id, array $data, $return_object = false, $filter = true)
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
						$value = \Security::xss_clean($value);
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
						$value = \Security::xss_clean($value);
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
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @api
	 * @param	mixed	an array of arguments or the item ID
	 * @return	bool
	 */
	public static function deleteItem($args)
	{
		// if we have a list of arguments, loop through them
		if (is_array($args))
		{
			// start the find
			$item = static::query();

			// loop through the arguments to build the where
			foreach ($args as $column => $value)
			{
				if (array_key_exists($column, static::$_properties))
				{
					$item->where($column, $value);
				}
			}

			// get the item
			$entry = $item->get_one();
		}
		else
		{
			// go directly to the item
			$entry = static::find($args);
		}

		// now that we have the item, delete it
		if ($entry->delete(null, true))
		{
			return true;
		}
		
		return false;
	}
}
