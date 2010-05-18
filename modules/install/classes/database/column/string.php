<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database string column object.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Column_String extends Database_Column {
	
	/**
	 * The maximum length of the column in bytes.
	 * 
	 * @var	int
	 */
	public $max_length;
	
	/**
	 * Whether the column is fixed in length.
	 * 
	 * @var	bool
	 */
	public $exact;
	
	/**
	 * Whether the column is colated to store binary data.
	 * 
	 * @var	bool
	 */
	public $binary;
	
	public function parameters($set = NULL)
	{
		if ($this->exact)
		{
			return array();
		}
		else
		{
			if ($set === NULL)
			{
				return isset($this->max_length) ? array($this->max_length) : array();
			}
			else
			{
				$this->max_length = $set;
			}
		}
	}
	
	protected function _load_schema(array $schema)
	{
		$this->max_length = arr::get($schema, 'character_maximum_length');
		$this->binary = arr::get($schema, 'binary', FALSE);
		$this->exact = arr::get($schema, 'exact', FALSE);
	}
	
	protected function _constraints()
	{
		if ($this->binary)
		{
			return array('binary');
		}
		
		return array();
	}
	
} // End Database_Column_String