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

class Fusion_Observer_CreatedAt extends Fusion_Observer {

	public static $mysql_timestamp = false;
	public static $property = 'created_at';

	public function before_insert(Model $obj)
	{
		$date = new DateTime('now', new DateTimeZone('UTC'));
		
		$obj->{static::$property} = static::$mysql_timestamp ? $date->format('Y-m-d H:i:s') : $date->format('Y-m-d H:i:s');
	}
}
