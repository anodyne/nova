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

abstract class Fusion_Observer {

	protected static $_instance = array();

	public static function orm_notify($instance, $event)
	{
		if (method_exists(static::instance(), $event))
		{
			static::instance()->{$event}($instance);
		}
	}

	public static function instance()
	{
		$class = get_called_class();

		if (empty(static::$_instance[$class]))
		{
			static::$_instance[$class] = new static;
		}

		return static::$_instance[$class];
	}
}
