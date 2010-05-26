<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Submit Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Submit
{
	/**
	 * Executes a create submission that loops through the arrays, does the XSS clean,
	 * removes items from the array and merges it with any additional fields passed
	 * to the method then runs the core model add method.
	 *
	 * @param	array 	POST array
	 * @param	string	the table being added to
	 * @param	array 	an array of additional fields to be added to the POST array
	 * @param	array 	an array of elements to pop off the POST array
	 * @return			the number of affected rows by the add query
	 */
	public static function create($values = '', $table = '', $additional = array(), $pop = array())
	{
		$query = Jelly::factory($table);
		
		// clear out the unnecessary items
		foreach ($values as $key => $value)
		{
			if (in_array($key, $pop))
			{
				unset($values[$key]);
			}
			else
			{
				$array[$key] = security::xss_clean($value);
			}
		}
		
		// push the additional items onto the end of the array
		$array = array_merge($array, $additional);
		
		// execute the query
		$retval = $query->set($array)->save();
		
		return $retval;
	}
	
	/**
	 * Builds the flash message shown on some pages.
	 *
	 * @param	integer	result from a create, update or delete query
	 * @param	string	the item the action is being taken on
	 * @param	string	the action being taken
	 * @param	string	the skin
	 * @param	string	the section
	 * @param	string	extra content to be appended to the end of the flash message
	 * @param	boolean	whether the verb should be pluralized or not (was/were)
	 * @return			the string result of the flash message
	 */
	public static function show_flash($result = 0, $item = '', $action = '', $skin = '', $section = '', $extra = '', $plural = FALSE)
	{
		// grab the flash partial
		$flash = new View(location::view('flash', $skin, $section, 'pages'));
		
		if ($result > 0)
		{
			$flash->status = 'success';
			
			if ($plural === FALSE)
			{
				$flash->message = ucfirst(__('phrase.flash_success', array(':item' => $item, ':action' => $action, ':extra' => $extra)));
			}
			else
			{
				$flash->message = ucfirst(__('phrase.flash_success_plural', array(':item' => $item, ':action' => $action, ':extra' => $extra)));
			}
		}
		else
		{
			$flash->status = 'failure';
			
			if ($plural === FALSE)
			{
				$flash->message = ucfirst(__('phrase.flash_failure', array(':item' => $item, ':action' => $action, ':extra' => $extra)));
			}
			else
			{
				$flash->message = ucfirst(__('phrase.flash_failure_plural', array(':item' => $item, ':action' => $action, ':extra' => $extra)));
			}
		}
		
		return $flash;
	}
}

// End of file submit.php
// Location: modules/nova/classes/nova/submit.php