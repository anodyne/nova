<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Event class is a method of executing code at different points during the
 * request flow as well as creating custom events.
 *
 * The Event class was ported from the Fuel Event class with several modifications
 * by Anodyne Productions.
 *
 * @package		Nova
 * @category	Classes
 * @author		Fuel Development Team
 * @author		Anodyne Productions
 * @copyright	2010 - 2011 Fuel Development Team
 * @version		1.0
 */

abstract class Nova_Event {
	
	/**
	 * @var	array	An array of listeners
	 */
	protected static $_events = array();
	
	/**
	 * Initializes the events array from the event config file.
	 *
	 * @access	public
	 * @return	void
	 */
	public static function init()
	{
		// get the events from the config file
		$config_events = Kohana::config('event');
		
		// loop through the events and register them
		foreach ($config_events as $event => $callback)
		{
			static::register($event, $callback);
		}
	}
	
	/**
	 * Registers a Callback for a given event
	 *
	 * @access	public
	 * @param	string	the name of the event
	 * @param	mixed	callback information
	 * @return	void
	 */
	public static function register()
	{
		// get any arguments passed
		$callback = func_get_args();

		// if the arguments are valid, register the event
		if (isset($callback[0]) and is_string($callback[0]) and isset($callback[1]) and is_callable($callback[1]))
		{
			// make sure we have an array for this event
			isset(static::$_events[$callback[0]]) or static::$_events[$callback[0]] = array();

			// store the callback on the call stack
			array_unshift(static::$_events[$callback[0]], $callback);

			// and report success
			return true;
		}
		else
		{
			// can't register the event
			return false;
		}
	}
	
	/**
	 * Triggers an event and returns the results.  The results can be returned
	 * in the following formats:
	 *
	 *     'array'
	 *     'json'
	 *     'serialized'
	 *     'string'
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @param	mixed	Any data that is to be passed to the listener
	 * @param	string	The return type
	 * @return	mixed	The return of the listeners, in the return type
	 */
	public static function trigger($event, $data = '', $return_type = 'string')
	{
		$calls = array();

		// check if we have events registered
		if (static::has_events($event))
		{
			// process them
			foreach (static::$_events[$event] as $arguments)
			{
				// get rid of the event name
				array_shift($arguments);

				// get the callback method
				$callback = array_shift($arguments);

				// call the callback event
				if (is_callable($callback))
				{
					$calls[] = call_user_func($callback, $data, $arguments);
				}
			}
		}

		return static::_format_return($calls, $return_type);
	}
	
	/**
	 * Checks if the event has listeners
	 *
	 * @access	public
	 * @param	string	The name of the event
	 * @return	bool	Whether the event has listeners
	 */
	public static function has_events($event)
	{
		if (isset(static::$_events[$event]) AND count(static::$_events[$event]) > 0)
		{
			return true;
		}
		return false;
	}

	/**
	 * Formats the return in the given type
	 *
	 * @access	protected
	 * @param	array	The array of returns
	 * @param	string	The return type
	 * @return	mixed	The formatted return
	 */
	protected static function _format_return(array $calls, $return_type)
	{
		switch ($return_type)
		{
			case 'array':
				return $calls;
			break;
				
			case 'json':
				return json_encode($calls);
			break;
				
			case 'none':
				return;
				
			case 'serialized':
				return serialize($calls);
			break;
			
			case 'string':
				$str = '';
				foreach ($calls as $call)
				{
					$str .= $call;
				}
				return $str;
			break;
			
			default:
				return $calls;
			break;
		}

		return false;
	}
}
