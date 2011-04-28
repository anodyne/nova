<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Events class is a method of executing code at different points during the
 * request flow. All event calls are specified in the APPPATH/bootstrap.php file.
 * You should not edit any of the event calls as doing say will break the event
 * system.
 *
 * __About the config file:__ At this point, all events must be class methods.
 * The params is a single variable so if you need to pass more than one piece of
 * information to the class method, the param variable will need to be an array.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Events {
	
	/**
	 * Executes the class methods at the specified times in the request process.
	 * The event system has 8 event hooks: preCreate, postCreate, preExecute,
	 * postExecute, preHeaders, postHeaders, preResponse and postResponse. Events
	 * are stored in the events config file. You can copy the events config file
	 * from MODPATH/nova/config/events.php and put it in your application config
	 * directory and define whatever events you want.
	 *
	 * @access	public
	 * @uses	Kohana::config
	 * @param	string	the event to execute events for
	 * @return	void
	 */
	public static function event($event)
	{
		$events = Kohana::config('events.'.$event);
		
		if (is_array($events))
		{
			foreach ($events as $e)
			{
				// define the items we're using
				$class = $e['class'];
				$method = $e['method'];
				$param = $e['param'];
				
				// instantiate the class
				$$class = new $class;
				
				// execute the method
				$$class->$method($param);
			}
		}
	}
}
