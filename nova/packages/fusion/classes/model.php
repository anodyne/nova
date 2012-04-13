<?php
/**
 * Model class
 *
 * @package		Nova
 * @subpackage	ORM
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
	 * @return	object	the newly created item
	 */
	public static function create_item($data)
	{
		$item = static::forge();
		
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
	 * @return	object	the updated item
	 */
	public static function update_item($id, array $data, $filter = true)
	{
		if ($id !== null)
		{
			// get the item
			$record = static::find($id);
			
			// loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				if ($key != 'id')
				{
					if ($filter === true)
					{
						$value = trim(\Security::xss_clean($value));
					}

					$record->$key = $value;
				}
			}
			
			// save the record
			$record->save();
			
			return $record;
		}
		else
		{
			// pull everything from the table
			$records = static::find('all');
			
			// loop through all the records
			foreach ($records as $r)
			{
				// loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					$r->$key = $value;
				}
				
				// save the record
				$r->save();
			}
		}
	}
	
	/**
	 * Delete an item in the table based on the arguments passed to the method.
	 *
	 * @api
	 * @param	array	the data to use to find the item
	 * @return	object	an object
	 */
	public static function delete_item(array $args)
	{
		$record = static::find();
		
		foreach ($args as $column => $value)
		{
			if (array_key_exists($column, static::$_properties))
			{
				$record->where($column, $value);
			}
		}
		
		$result = $record->delete();
		
		return $result;
	}
}
