<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Boolean database column class.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Column_Bool extends Database_Column {
	
	public function parameters($set = NULL)
	{
		return NULL;
	}
	
	protected function _load_schema(array $schema)
	{
		return;
	}
	
	protected function _constraints()
	{
		return array();
	}
	
} // End Database_Column_Bool