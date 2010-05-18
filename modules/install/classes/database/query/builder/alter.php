<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database query builder for ALTER statements.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Kohana 3.0 Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Query_Builder_Alter extends Database_Query_Builder {
	
	/**
	 * The name of the table.
	 * 
	 * @var	string
	 */
	protected $_table;
	
	/**
	 * The column to modify.
	 * 
	 * @var Database_Column
	 */
	protected $_modify;
	
	/**
	 * The list of columns to add.
	 * 
	 * @var	array
	 */
	protected $_add_columns = array();
	
	/**
	 * The list of constraints to add.
	 * 
	 * @var	array
	 */
	protected $_add_constraints = array();
	
	/**
	 * The name and type of the object to drop.
	 * 
	 * @var	array
	 */
	protected $_drop = array();
	
	/**
	 * Create a new alter query builder.
	 *
	 * @param	string	The name of the table to alter.
	 * @return	void
	 */
	public function __construct($table)
	{
		$this->_table = $table;

		parent::__construct(Database::ALTER, '');
	}
	
	/**
	 * Modify a column based on the object model. Note the columns need the same name.
	 * 
	 * @param	Database_Column	The column object to modify.
	 * @return	Database_Query_Builder_Alter
	 */
	public function modify(Database_Column $column)
	{
		$this->_modify = $column;
		
		return $this;
	}
	
	/**
	 * Drop a column or constraint.
	 *
	 * @param	string	The name of the column to drop.
	 * @param	string	The type of object you want to drop.
	 * @return	Database_Query_Builder_Alter	The current object for chaining.
	 */
	public function drop($name, $type = 'column')
	{
		$this->_drop = array($name, $type);
		
		return $this;
	}
	
	/**
	 * Adds a column or constraint to the table.
	 * 
	 * @throws	Kohana_Exception	If the object isn't a column or constraint.
	 * @param	object	Either the column or constraint object.
	 * @return	Database_Query_Builder_Alter
	 */
	public function add($object)
	{
		if ($object instanceof Database_Column)
		{
			$this->_add_columns[] = $object;
		}
		elseif ($object instanceof Database_Constraint)
		{
			$this->_add_constraints[] = $object;
		}
		else
		{
			throw new Kohana_Exception('Unrecognised add object :obj', array(
				':obj' => $object
			));
		}
		
		return $this;
	}
	
	public function compile(Database $db)
	{
		if ($sql = $this->_compile_add($db))
		{
			return 'ALTER TABLE '.$db->quote_table($this->_table).' '.$sql;
		}
		elseif ($sql = $this->_compile_modify($db))
		{
			return 'ALTER TABLE '.$db->quote_table($this->_table).' '.$sql;
		}
		elseif ($sql = $this->_compile_drop($db))
		{
			return 'ALTER TABLE '.$db->quote_table($this->_table).' '.$sql;
		}
		else
		{
			return NULL;
		}
	}
	
	public function reset()
	{
		$this->_modify =
		$this->_drop =
		$this->_table = NULL;
		
		$this->_add_columns =
		$this->_add_constraints = array();
	}
	
	/**
	 * Compiles all added columns / constraints into SQL.
	 * 
	 * @param	Database	The database object.
	 * @return	string
	 */
	protected function _compile_add(Database $db)
	{
		$sql = '';
		
		if ( ! empty($this->_add_columns) OR ! empty($this->_add_constraints))
		{
			$multi = count($this->_add_columns) + count($this->_add_constraints) > 1;
			
			$sql .= 'ADD '.($multi ? '(' : '');
			
			foreach ($this->_add_columns as $column)
			{
				$sql .= $column->compile().',';
			}
			
			foreach ($this->_add_constraints as $constraint)
			{
				$sql .= $constraint->compile($db).',';
			}
			
			$sql = rtrim($sql, ',').($multi ? ')' : '').';';
		}
		
		return $sql;
	}
	
	/**
	 * Compile all modify column statements into SQL.
	 * 
	 * @param	Database	The database object.
	 * @return	string
	 */
	protected function _compile_modify(Database $db)
	{
		if (isset($this->_modify))
		{
			return 'MODIFY '.$this->_modify->compile($db);
		}
		
		return '';
	}
	
	/**
	 * Compiles all drop statements into SQL.
	 * 
	 * @param	Database	The database object.
	 * @return	string
	 */
	protected function _compile_drop(Database $db)
	{
		if ( ! empty($this->_drop))
		{
			return DB::drop($type, $name)->compile($db);
		}
		
		return '';
	}
	
} // End Database_Query_Builder_Alter