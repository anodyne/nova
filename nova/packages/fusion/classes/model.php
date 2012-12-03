<?php
/**
 * The model class is the foundation for all of Nova's models and provides core
 * functionality that's shared across many of the models used in Nova,
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
	 * @param	mixed	The data
	 * @param	bool	Should the object be returned?
	 * @param	bool	Should the data be filtered?
	 * @return	mixed
	 */
	public static function createItem($data, $returnObj = false, $filter = true)
	{
		// Create a forge
		$item = static::forge();
		
		// Loop through the data and add it to the item
		foreach ($data as $key => $value)
		{
			// Don't do anything with the ID field and make sure the column exists
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
		
		// Was the item saved?
		if ($item->save())
		{
			// Are we returning the object?
			if ($returnObj)
			{
				return $item;
			}

			return true;
		}
		
		return false;
	}

	/**
	 * Find a record/records in the table based on simple arguments.
	 *
	 * @api
	 * @param	string	The column
	 * @param	mixed	The value
	 * @param	bool	Is this for a search?
	 * @return	object
	 */
	public static function getItem($value, $column = false, $search = false)
	{
		if (is_array($value))
		{
			// Start the find
			$record = static::query();
			
			// Loop through the arguments and build the where clause
			foreach ($value as $col => $val)
			{
				// Make sure the column exists
				if (array_key_exists($col, static::$_properties))
				{
					$record->where($col, $val);
				}
			}
			
			// Get the record
			return $record->get_one();
		}
		else
		{
			// Make sure the column exists
			if (array_key_exists($column, static::$_properties))
			{
				// We aren't searching, so use an equality
				if ( ! $search)
				{
					return static::query()->where($column, $value)->get_one();
				}

				// We are searching, so make sure we use LIKE in the query
				return static::query()->where($column, 'like', $value)->get();
			}
		}
		
		return false;
	}

	/**
	 * Find a form item based on the form key.
	 *
	 * @api
	 * @param	string	The form key
	 * @param	bool	Get displayed items (true) or all items (false)?
	 * @return	object
	 */
	public static function getFormItems($key, $onlyActive = false)
	{
		// Get the object
		$items = static::query();

		// Make sure we're pulling back the right form
		$items->where('form_key', $key);

		// Should we be getting all items or just enabled ones?
		if ($onlyActive)
		{
			$items->where('status', \Status::ACTIVE);
		}

		// Order the items
		$items->order_by('order', 'asc');

		return $items->get();
	}
	
	/**
	 * Update an item in the table based on the ID and data.
	 *
	 * @api
	 * @param	mixed	An ID to update or NULL to update everything
	 * @param	array 	Array of data
	 * @param	bool	Should the data be run through the XSS filter
	 * @return	mixed
	 */
	public static function updateItem($id, array $data, $returnObj = false, $filter = true)
	{
		if ($id !== null)
		{
			// Get the item
			$item = static::find($id);
			
			// Loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				// Don't update the ID field and make sure the column exists
				if ($key != 'id' and array_key_exists($key, static::$_properties))
				{
					// Are we doing XSS filtering?
					if ($filter)
					{
						$value = \Security::xss_clean($value);
					}

					$item->{$key} = $value;
				}
			}
			
			// Save the item
			if ($item->save())
			{
				// Are we returning the object?
				if ($returnObj)
				{
					return $item;
				}

				return true;
			}

			return false;
		}
		else
		{
			// Pull everything from the table
			$items = static::find('all');
			
			// Loop through all the items
			foreach ($items as $item)
			{
				// Loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					// Are we filtering this for XSS?
					if ($filter)
					{
						$value = \Security::xss_clean($value);
					}

					$item->{$key} = $value;
				}
				
				// Save the item
				$item->save();
			}

			return true;
		}
	}
	
	/**
	 * Delete an item in the table based on the arguments passed.
	 *
	 * @api
	 * @param	mixed	An array of arguments or the item ID
	 * @return	bool
	 */
	public static function deleteItem($args)
	{
		// If we have a list of arguments, loop through them
		if (is_array($args))
		{
			// Start the find
			$item = static::query();

			// Loop through the arguments to build the where
			foreach ($args as $column => $value)
			{
				// Make sure the column exists
				if (array_key_exists($column, static::$_properties))
				{
					$item->where($column, $value);
				}
			}

			// Get the item
			$entry = $item->get_one();
		}
		else
		{
			// Go directly to the item
			$entry = static::find($args);
		}

		// Now that we have the item, delete it
		if ($entry->delete(null, true))
		{
			return true;
		}
		
		return false;
	}
}
