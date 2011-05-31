<?php
/**
 * Fusion is a port of Fuel's fast, lightweight ORM.
 *
 * @package		Fusion
 * @author		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 * @version		1.0
 */

class Fusion_Observer_Self {

	public static function orm_notify(Model $instance, $event)
	{
		if (method_exists($instance, $method = '_event_'.$event))
		{
			call_user_func(array($instance, $method));
		}
	}
}
