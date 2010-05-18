<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database query builder for CREATE statements.
 *
 * @package    Database
 * @author     Oliver Morgan
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Database_Query_Builder_Create extends Database_Query_Builder {
	
	/**
	 * The name of the table we're creating.
	 * 
	 * @var	string
	 */
	protected $_table;
	
	/**
	 * The list of column objects.
	 * 
	 * @var	array
	 */
	protected $_columns = array();
	
	/**
	 * The list of table options.
	 * 
	 * @var	array
	 */
	protected $_options = array();
	
	/**
	 * The list of table column constraints.
	 * 
	 * @var	array
	 */
	protected $_constraints = array();
	
	/**
	 * Initiates the sql create builder.
	 * 
	 * @param	string	The name of the table we're going to create.
	 * @return	void
	 */
	public function __construct($table)
	{		
		$this->_table = $table;

		parent::__construct(Database::CREATE, '');
	}
	
	/**
	 * Appends a list of column(s) to the column array.
	 * 
	 * @param	array	The column array.
	 * @return	Database_Query_Builder_Create
	 */
	public function columns(array $columns)
	{
		$this->_columns += $columns;
		
		return $this;
	}
	
	/**
	 * Appends a list of column constraints(s) to the array.
	 * 
	 * @param	array	The constraint array.
	 * @return	Database_Query_Builder_Create
	 */
	public function constraints(array $constraints)
	{
		$this->_constraints += $constraints;
		
		return $this;
	}
	
	/**
	 * Appends a list of options(s) to the options array.
	 * 
	 * Options are statements placed at the end of the table after the column parameters.
	 * 
	 * @param	array	The options array.
	 * @return	Database_Query_Builder_Create
	 */
	public function options(array $options)
	{
		$this->_options += $options;
		
		return $this;
	}
	
	public function compile(Database $db)
	{
		$sql = 'CREATE TABLE '.$db->quote_table($this->_table).' ';
		
		if ( ! empty($this->_columns))
		{
			$sql .= '(';
			
			foreach($this->_columns as $column)
			{
				$sql .= $column->compile($db).',';
			}
			
			foreach($this->_constraints as $constraint)
			{
				$sql .= $constraint->compile($db).',';
			}
			
			$sql = rtrim($sql, ',').') ';
		}
		
		foreach($this->_options as $key => $option)
		{
			$sql .= Database_Query_Builder::compile_statement(array($key => $option)).' ';
		}
		
		return $sql;
	}
	
	public function reset()
	{
		$this->_table = NULL;
		
		$this->_columns =
		$this->_options =
		$this->_constraints = array();
	}
	
} // End Database_Query_Builder_Create