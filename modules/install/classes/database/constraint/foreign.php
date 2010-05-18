<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database table FOREIGN KEY constraint.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Kohana 3.0 Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Constraint_Foreign extends Database_Constraint {
	
	/**
	 * @var	array	The list of supported actions.
	 */
	public $actions = array(
		'cascade',
		'restrict',
		'no action',
		'set null',
		'set default'
	);
		
	/**
	 * The name of the referenced table and column.
	 * 
	 * @var	array
	 */
	protected $_references;
	
	/**
	 * The action taken when the referenced record is updates.
	 * 
	 * @var	string
	 */
	protected $_on_update = 'no action';
	
	/**
	 * The action taken when the referenced record is deleted.
	 * 
	 * @var unknown_type
	 */
	protected $_on_delete = 'no action';
	
	/**
	 * The name of the foreign key column.
	 * 
	 * @var unknown_type
	 */
	protected $_column;
	
	/**
	 * Initiate a FOREIGN KEY constraint.
	 *
	 * @param	string	The name of the column that represents the foreign key.
	 * @param	string	The name of the table.
	 * @return	void
	 */
	public function __construct($column, $table)
	{
		$this->name = 'fk_'.$table.'_'.$column.'_';
		
		$this->_column = $column;
	}
	
	/**
	 * The destination table and column you're referencing.
	 *
	 * @param	string	The table name you're referencing.
	 * @param	string	The column's name you're referencing.
	 * @return	Database_Constraint_Foreign
	 */
	public function references($table, $column)
	{
		$this->_references = array(
			$table,
			$column
		);
		
		return $this;
	}
	
	/**
	 * The action to perform when the foreign record is updated. Make sure this is supported by your
	 * database, otherwise it will not work.
	 * 
	 * @throws	Kohana_Exception	If you don't use a recognised type.
	 * @param	string	The lowercase type name. Use either: 'cascade', 'restrict',
	 * 'no action', 'set null','set default'.
	 * @return	Database_Constraint_Foreign	The current object.
	 */
	public function on_update($action)
	{
		if (in_array($action, $this->actions, FALSE))
		{
			$this->_on_update = $action;
		}
		else
		{
			throw new Kohana_Exception('The foreign key constraint action ":act" was not recognised', array(
				':act'	=> $action
			));
		}
		
		return $this;
	}
	
	/**
	 * The action to perform when the foreign record is updated. Make sure this is supported by your
	 * database, otherwise it will not work.
	 * 
	 * @throws	Kohana_Exception	If you don't use a recognised type.
	 * @param	string	The lowercase type name. Use either: 'cascade', 'restrict',
	 * 'no action', 'set null','set default'.
	 * @return	Database_Constraint_Foreign	The current object.
	 */
	public function on_delete($action)
	{
		if (in_array($action, $this->actions, FALSE))
		{
			$this->_on_delete = $action;
		}
		else
		{
			throw new Kohana_Exception('The foreign key constraint action ":act" was not recognised', array(
				':act'	=> $action
			));
		}
		
		return $this;
	}
	
	public function compile(Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		list($table, $column) = $this->_references;
		
		$this->name .= $table.'_'.$column;
		
		$sql = 'CONSTRAINT '.$db->quote_identifier($this->name).
			' FOREIGN KEY ('.$db->quote_identifier($this->_column).')'.
			' REFERENCES '.$db->quote_table($table).'('.$db->quote_identifier($column).')';
		
		if (isset($this->_on_update))
		{
			$sql .= ' ON UPDATE '.strtoupper($this->_on_update);
		}
		
		if(isset($this->_on_delete))
		{
			$sql .= ' ON DELETE '.strtoupper($this->_on_delete);
		}
		
		return $sql;
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
				->drop($this->name, 'foreign key')
				->execute($db);
		}
		else
		{
			return DB::alter($table)
				->drop($this->name, 'constraint')
				->execute($db);
		}
	}
	
} // End Database_Constraint_Foreign