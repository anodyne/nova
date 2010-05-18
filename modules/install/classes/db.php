<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database helper class.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class DB extends Kohana_DB {
	
	/**
	 * Create a new alter table query.
	 *
	 * @param	string	The name of the table to alter.
	 * @return	Database_Query_Builder_Alter
	 */
	public static function alter($table)
	{
		return new Database_Query_Builder_Alter($table);
	}
	
	/**
	 * Create a new create table query.
	 *
	 * @param	string	The table's name.
	 * @return	Database_Query_Builder_Create
	 */
	public static function create($table)
	{
		return new Database_Query_Builder_Create($table);
	}
	
	/**
	 * Create a new drop query.
	 *
	 * @param	string	The type of object to drop; 'database', 'table', 'column' or 'constraint.
	 * @param	string	The name of the object to drop.
	 * @return	Database_Query_Builder_Drop
	 */
	public static function drop($type, $name)
	{
		return new Database_Query_Builder_Drop($type, $name);
	}
	
	/**
	 * Creates a new table truncate query.
	 *
	 * @param	string	The table name to truncate.
	 * @return	Database_Query_Builder_Truncate
	 */
	public static function truncate($table)
	{
		return new Database_Query_Builder_Truncate($table);
	}

} // End DB