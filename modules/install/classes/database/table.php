<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database table object.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Kohana 3.0 Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Table {
	
	/**
	 * Retrieves an existing instance of a table from the database. Returns NULL if no table is found.
	 * 
	 * @param	string	The name of the table.
	 * @param	Database	The parent database object.
	 * @return	Database_Table
	 */
	public static function instance($name, Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		$schema = $db->list_tables($name);
		
		if ( ! empty($schema))
		{
			return new self($name, $db, $schema);
		}
		
		return NULL;
	}
	
	/**
	 * Creates a new instance of a database table.
	 * 
	 * @param	string	The name of the table.
	 * @param	Database	The parent database object.
	 * @return	Database_Table
	 */
	public static function factory($name, Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		return new self($name, $db);
	}
	
	/**
	 * The name of the table.
	 * 
	 * @var string
	 */
	public $name;
	
	/**
	 * The list of columns.
	 * 
	 * @var	array
	 */
	protected $_columns = array();
	
	/**
	 * The list of options.
	 * 
	 * @var	array
	 */
	protected $_options = array();
	
	/**
	 * The list of constraints.
	 * 
	 * @var	array
	 */
	protected $_constraints = array();
	
	/**
	 * Whether the table is loaded or not.
	 * 
	 * @var bool
	 */
	protected $_loaded;
	
	/**
	 * The parent database object.
	 * 
	 * @var	Database
	 */
	protected $_db;
	
	/**
	 * Creates a new table object.
	 *
	 * @param   string   The name of the table.
	 * @param	Database	The parent database object.
	 * @param	array	The schema array if loaded from the database.
	 * @return  void
	 */
	public function __construct($name, $db, array $schema = NULL)
	{
		$this->name = $name;
		$this->_db = $db;
		$this->_loaded = $schema !== NULL;
	}
	
	/**
	 * Whether the table exists in the database or not.
	 * 
	 * @return bool
	 */
	public function loaded()
	{
		return $this->_loaded;
	}
	
	/**
	 * Lists requested or all constraints associated with the table.
	 *
	 * @return  array|Database_Constraint	The list of all the columns
	 */
	public function constraints($name = NULL)
	{
		if ($name === NULL)
		{
			return $this->_constraints;
		}
		else
		{
			return $this->_constraints[$name];
		}
	}
	
	/**
	 * Retrieves an all or an existing table option.
	 *
	 * @param	string	The keyword which the option was defined with, if you're looking for something specific.
	 * @return  array
	 */
	public function options($key = NULL)
	{
		if ($key === NULL)
		{
			return $this->_options;
		}
		else
		{
			return $this->_options[$key];
		}
	}
	
	/**
	 * Returns the column requested or all columns within the table.
	 *
	 * @param	string	The column you want to return, if there is only one.
	 * @return  array|Database_Table_Column
	 */
	public function columns($like = NULL)
	{
		if ($this->_loaded)
		{
			if ($name !== NULL)
			{
				return Database_Column::instance($this->name, $name);
			}
			
			$columns = $this->_db->list_columns($this->name);
			
			foreach ($columns as $name => $schema)
			{
				$this->_columns[$column] = 
					Database_Column::instance($this->name, $name);
			}
		}
		else
		{
			return $this->_columns;
		}
	}
	
	/**
	 * Adds a column to the table. If the table is loaded then the action will be commited to the database.
	 *
	 * @param	Database_Column	The database column.
	 * @return  Database_Table
	 */
	public function add_column(Database_Column $column)
	{
		$this->_columns[$column->name] = $column;
		
		return $this;
	}
	
	/**
	 * Adds a constraint to the table.
	 *
	 * @param	Database_Constraint	The constraint object.
	 * @return  Database_Table
	 */
	public function add_constraint(Database_Constraint $constraint)
	{
		$this->_constraints[$constraint->name] = $constraint;
		
		return $this;
	}
	
	/**
	 * Adds a table option.
	 * 
	 * Table options are appended to the end of the create statement, typically in MySQL here you would set
	 * the database engine, auto_increment offset, comments etc. Consult your database documentation for
	 * more information.
	 * 
	 * On comilation a typical output would be; KEYWORD=`value` or if value is not set; KEYWORD
	 * 
	 * @see http://dev.mysql.com/doc/refman/5.1/en/create-table.html
	 *
	 * @param	string	The keyword of the option.
	 * @param	string	The value associated with the keyword. This is completely optional depending on your needs.
	 * @return  Database_Table
	 */
	public function add_option($key, $value = NULL)
	{
		if ($value === NULL)
		{
			$this->_options[] = $key;
		}
		else
		{
			$this->_options[$key] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Creates the table.
	 * 
	 * @return 	Database_Table
	 */
	public function create()
	{
		$this->_loaded = TRUE;
		
		DB::create($this->name)
			->columns($this->_columns)
			->constraints($this->_constraints)
			->options($this->_options)
			->execute($this->_db);
			
		return $this;
	}
	
	/**
	 * Cloned tables are not loaded.
	 * 
	 * @return	void
	 */
	public function __clone()
	{
		$this->_loaded = FALSE;
	}
	
} // End Database_Table