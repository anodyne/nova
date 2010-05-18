<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database table PRIMARY KEY constraint.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Kohana 3.0 Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Constraint_Primary extends Database_Constraint {
	
	/**
	 * List of keys that make up the primary key.
	 * 
	 * @var	array
	 */
	protected $_keys;
	
	/**
	 * Initiates a new primary constraint object.
	 * 
	 * @param	array	The list of columns that make up the primary key.
	 * @return	void
	 */
	public function __construct(array $keys, $table)
	{
		$this->name = 'pk_'.$table.'_'.implode('_', $keys);
		
		$this->_keys = $keys;
	}
	
	public function compile(Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		return 'CONSTRAINT '.$db->quote_identifier($this->name).
			' PRIMARY KEY ('.implode(',', array_map(array($db, 'quote_identifier'), $this->_keys)).')';
	}
	
	public function drop($table, Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		$this->compile($db);
		
		if ($db instanceof Database_MySQL)
		{
			return DB::alter($table)
				->drop(DB::expr(''), 'primary key')
				->execute($db);
		}
		else
		{
			return DB::alter($table)
				->drop($this->name, 'constraint')
				->execute($db);
		}
	}
	
} // End Database_Constraint_Primary