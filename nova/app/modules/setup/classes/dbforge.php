<?php
/**
 * The DBForge class provides a means of easily manipulating the database. This class only works
 * with MySQL through the standard Database drivers. The DBForge class has been ported from
 * CodeIgniter 1.7.2.
 *
 * *Use great caution when using the DBForge class as it can cause irreversible damage to your
 * database and its data!*
 *
 * @package		Setup
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

class DBForge {
	
	/**
	 * @var		array 	an array of fields
	 */
	public static $fields = array();
	
	/**
	 * @var		array 	an array of keys
	 */
	public static $keys = array();
	
	/**
	 * @var		array 	an array of primary keys
	 */
	public static $primary_keys = array();
	
	/**
	 * @var		string	the database character set
	 */
	public static $db_char_set;
	
	/**
	 * @var		object	database instance
	 */
	protected static $db;
	
	/**
	 * @var		array 	database config array
	 */
	protected static $dbconfig;
	
	/**
	 * @var		string	the database escape character
	 */
	protected static $_escape_char = '`';
	
	/**
	 * @var		boolean	should identifiers be protected
	 */
	protected static $_protect_identifiers	= true;
	
	/**
	 * @var		array 	identifiers that should NOT be escaped
	 */
	protected static $_reserved_identifiers	= array('*');
	
	protected static $swap_pre;
	
	/**
	 * Initializes the DBForge. It isn't necessary to directly call this method as it's called
	 * automatically when the class is used.
	 *
	 * @return	void
	 */
	public static function initialize()
	{
		// get an instance of the database
		self::$db = Database::instance();
		
		// get the database configuration
		self::$dbconfig = Kohana::config('database.default');
	}
	
	/**
	 * Create a database with the name passed to the method.
	 *
	 * *Some hosts may not allow you to create databases programmatically. Only use this method
	 * if you know your host allows this.*
	 *
	 *     DBForge::create_database('foo');
	 *
	 * @uses	Database::query
	 * @param	string	the database to create
	 * @return	object	query object
	 */
	public static function create_database($name)
	{
		$sql = "CREATE DATABASE ".$name;
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Drop the database with the name passed to the method.
	 *
	 * *Some hosts may not allow you to drop databases programmatically. Only use this method
	 * if you know your host allows this.*
	 *
	 *     DBForge::drop_database('foo');
	 *
	 * @uses	Database::query
	 * @param	string	the database to drop
	 * @return	object	query object
	 */
	public static function drop_database($name)
	{
		$sql = "DROP DATABASE ".$name;
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Add keys to the database
	 *
	 *     DBForge::add_key('table_field', true);
	 *
	 * @uses	DBForge::add_key
	 * @param	mixed	the key(s) to add
	 * @param	boolean	whether the key is a primary key or not
	 * @return	void
	 */
	public static function add_key($key, $primary = false)
	{
		if (is_array($key))
		{
			foreach ($key as $one)
			{
				self::add_key($one, $primary);
			}
			
			return;
		}
	
		if ($key == '')
		{
			throw new Kohana_Exception(__("Key information is required for that operation."));
		}
		
		if ($primary === true)
		{
			self::$primary_keys[] = $key;
		}
		else
		{
			self::$keys[] = $key;
		}
	}
	
	/**
	 * Add fields to the database
	 *
	 *     $field = array(
	 *         'field' => array(
	 *              'type' => 'VARCHAR',
	 *              'constraint' => 32
	 *         ),
	 *     );
	 *     
	 *     DBForge::add_field($field);
	 *
	 * @uses	DBForge::add_field
	 * @uses	DBForge::add_key
	 * @param	mixed	the field(s) to add
	 * @return	void
	 */
	public static function add_field($field)
	{
		if ($field == '')
		{
			throw new Kohana_Exception(__("Field information is required."));
		}
		
		if (is_string($field))
		{
			if ($field == 'id')
			{
				self::add_field(array(
					'id' => array(
						'type' => 'INT',
						'constraint' => 9,
						'auto_increment' => true
					)
				));
				self::add_key('id', true);
			}
			else
			{
				if (strpos($field, ' ') === false)
				{
					throw new Kohana_Exception(__("Field information is required for that operation."));
				}
				
				self::$fields[] = $field;
			}
		}
		
		if (is_array($field))
		{
			self::$fields = array_merge(self::$fields, $field);
		}
	}
	
	/**
	 * Create a table in the database.
	 *
	 *     DBForge::create_table('foo', true);
	 *
	 * @uses	Database::query
	 * @uses	DBForge::_escape_identifiers
	 * @uses	DBForge::_process_fields
	 * @uses	DBForge::_protect_identifiers
	 * @param	string	the name of the table to create
	 * @param	boolean	IF NOT EXISTS statement
	 * @return	object	result object
	 */
	public static function create_table($table, $if_not_exists = false)
	{	
		if ($table == '')
		{
			throw new Kohana_Exception(__("A table name is required for that operation."));
		}
			
		if (count(self::$fields) == 0)
		{
			throw new Kohana_Exception(__("Field information is required."));
		}
		
		$sql = 'CREATE TABLE ';
		
		if ($if_not_exists === true)
		{
			$sql.= 'IF NOT EXISTS ';
		}
		
		$sql.= self::_escape_identifiers(self::$db->table_prefix().$table)." (";

		$sql.= self::_process_fields(self::$fields);

		if (count(self::$primary_keys) > 0)
		{
			$key_name = self::_protect_identifiers(implode('_', self::$primary_keys));
			$primary_keys = self::_protect_identifiers(self::$primary_keys);
			$sql.= ",\n\tPRIMARY KEY ".$key_name." (" . implode(', ', self::$primary_keys) . ")";
		}

		if (is_array(self::$keys) and count(self::$keys) > 0)
		{
			foreach (self::$keys as $key)
			{
				if (is_array($key))
				{
					$key_name = self::_protect_identifiers(implode('_', $key));
					$key = self::_protect_identifiers($key);	
				}
				else
				{
					$key_name = self::_protect_identifiers($key);
					$key = array($key_name);
				}
				
				$sql.= ",\n\tKEY {$key_name} (" . implode(', ', $key) . ")";
			}
		}

		$sql.= "\n) DEFAULT CHARACTER SET ".self::$dbconfig['charset']." COLLATE ".self::$dbconfig['collate'].";";
		
		self::_reset();
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Drop a table from the database.
	 *
	 *     DBForge::drop_table('foo');
	 *
	 * @uses	Database::query
	 * @param	string	the name of the table to drop
	 * @return	object	result object
	 */
	public static function drop_table($table)
	{
		$sql = "DROP TABLE IF EXISTS ".self::_escape_identifiers(self::$db->table_prefix().$table);
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Rename a database table
	 *
	 *     DBForge::rename_table('foo', 'foo_new');
	 *
	 * @uses	Database::query
	 * @uses	DBForge::_protect_identifiers
	 * @param	string	the table to change
	 * @param	string	the new table name
	 * @return	object	the result object
	 */
	public static function rename_table($table, $newtable)
	{
		if ($table == '' or $newtable == '')
		{
			throw new Kohana_Exception(__("A table name is required for that operation."));
		}
		
		$sql = 'ALTER TABLE '.self::_protect_identifiers(self::$db->table_prefix().$table)." RENAME TO ".self::_protect_identifiers(self::$db->table_prefix().$newtable);
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Adds a column to the database table
	 *
	 *     $field = array(
	 *         'new_field' => array(
	 *             'type' => 'VARCHAR',
	 *             'constraint' => 32
	 *         ),
	 *     );
	 *     
	 *     DBForge::add_column('foo', $field);
	 *
	 * @uses	Database::query
	 * @uses	DBForge::add_field
	 * @uses	DBForge::_alter_table
	 * @uses	DBForge::_reset
	 * @param	string	the table
	 * @param	array 	the field(s) to add
	 * @param	string	if the field needs to be added after another field
	 * @return	void
	 */
	public static function add_column($table, array $field, $after_field = '')
	{
		if ($table == '')
		{
			throw new Kohana_Exception(__("A table name is required for that operation."));
		}

		// add field info into field array, but we can only do one at a time so we cycle through
		foreach ($field as $k => $v)
		{
			self::add_field(array($k => $field[$k]));		

			if (count(self::$fields) == 0)
			{
				throw new Kohana_Exception(__("Field information is required."));
			}
			
			$sql = self::_alter_table('ADD', self::$db->table_prefix().$table, self::$fields, $after_field);

			self::_reset();
			
			self::$db->query(null, $sql, true);
		}
	}
	
	/**
	 * Drop a column from a database table
	 *
	 *     DBForge::drop_column('foo', 'column');
	 *
	 * @uses	Database::query
	 * @uses	DBForge::_alter_table
	 * @param	string	the table
	 * @param	string	the column to drop
	 * @return	object	the result object
	 */
	public static function drop_column($table, $column_name)
	{
		if ($table == '')
		{
			throw new Kohana_Exception(__("A table name is required for that operation."));
		}

		if ($column_name == '')
		{
			throw new Kohana_Exception(__("A column name is required for that operation."));
		}

		$sql = self::_alter_table('DROP', self::$db->table_prefix().$table, $column_name);
		
		return self::$db->query(null, $sql, true);
	}
	
	/**
	 * Modify a database table column
	 *
	 *     $field = array(
	 *         'old_name' => array(
	 *             'name' => 'new_name',
	 *             'type' => 'TEXT'
	 *         ),
	 *     );
	 *     
	 *     DBForge::modify_column('foo', $field);
	 *
	 * @uses	Database::query
	 * @uses	DBForge::add_field
	 * @uses	DBForge::_alter_table
	 * @uses	DBForge::_reset
	 * @param	string	the table
	 * @param	array 	field information
	 * @return	void
	 */
	public static function modify_column($table, array $field)
	{
		if ($table == '')
		{
			throw new Kohana_Exception(__("A table name is required for that operation."));
		}

		// add field info into field array, but we can only do one at a time so we cycle through
		foreach ($field as $k => $v)
		{
			self::add_field(array($k => $field[$k]));

			if (count(self::$fields) == 0)
			{
				throw new Kohana_Exception(__("Field information is required."));
			}
		
			$sql = self::_alter_table('CHANGE', self::$db->table_prefix().$table, self::$fields);

			self::_reset();
			
			self::$db->query(null, $sql, true);
		}
	}
	
	/**
	 * Optimizes the given table.
	 *
	 *     DBForge::optimize('table);
	 *
	 * @uses	Database::query
	 * @param	string	the table to optimize
	 * @param	boolean	whether or not to append the table prefix
	 * @return	void
	 */
	public static function optimize($table, $prefix = true)
	{
		// attach the prefix if necessary
		if ($prefix === true)
		{
			$table = self::$db->table_prefix().$table;
		}
		
		// optimize the table
		DB::query(null, "OPTIMIZE TABLE `$table`", true);
	}
	
	/**
	 * Generates a query so that a table can be altered
	 *
	 * @uses	DBForge::_alter_table
	 * @uses	DBForge::_protect_identifiers
	 * @param	string	the ALTER type (ADD, DROP, CHANGE)
	 * @param	string	the column name
	 * @param	array	fields
	 * @param	string	the field after which we should add the new field
	 * @return	string	the SQL statement
	 */
	protected static function _alter_table($alter_type, $table, $fields, $after_field = '')
	{
		$sql = 'ALTER TABLE '.self::_protect_identifiers($table)." $alter_type ";

		// DROP has everything it needs now.
		if ($alter_type == 'DROP')
		{
			return $sql.self::_protect_identifiers($fields);
		}

		$sql.= self::_process_fields($fields);

		if ($after_field != '')
		{
			$sql.= ' AFTER ' . self::_protect_identifiers($after_field);
		}
		
		return $sql;
	}
	
	/**
	 * Escape the identifiers before a query is run
	 *
	 * @param	string	the item to escape
	 * @return	string	the escaped string
	 */
	protected static function _escape_identifiers($item)
	{
		if (self::$_escape_char == '')
		{
			return $item;
		}

		foreach (self::$_reserved_identifiers as $id)
		{
			if (strpos($item, '.'.$id) !== false)
			{
				$str = self::$_escape_char. str_replace('.', self::$_escape_char.'.', $item);  
				
				// remove duplicates if the user already included the escape
				return preg_replace('/['.self::$_escape_char.']+/', self::$_escape_char, $str);
			}		
		}
		
		if (strpos($item, '.') !== false)
		{
			$str = self::$_escape_char.str_replace('.', self::$_escape_char.'.'.self::$_escape_char, $item).self::$_escape_char;			
		}
		else
		{
			$str = self::$_escape_char.$item.self::$_escape_char;
		}
	
		// remove duplicates if the user already included the escape
		return preg_replace('/['.self::$_escape_char.']+/', self::$_escape_char, $str);
	}
	
	/**
	 * Process the fields to make sure they're using the proper syntax
	 *
	 * @uses	DBForge::_protect_identifiers
	 * @param	array 	the array of fields
	 * @return	string	the SQL statement
	 */
	protected static function _process_fields($fields)
	{
		$current_field_count = 0;
		$sql = '';

		foreach ($fields as $field => $attributes)
		{
			// Numeric field names aren't allowed in databases, so if the key is
			// numeric, we know it was assigned by PHP and the developer manually
			// entered the field information, so we'll simply add it to the list
			if (is_numeric($field))
			{
				$sql .= "\n\t$attributes";
			}
			else
			{
				$attributes = array_change_key_case($attributes, CASE_UPPER);
				
				$sql.= "\n\t".self::_protect_identifiers($field);
				
				if (array_key_exists('NAME', $attributes))
				{
					$sql.= ' '.self::_protect_identifiers($attributes['NAME']).' ';
				}
				
				if (array_key_exists('TYPE', $attributes))
				{
					$sql.= ' '.$attributes['TYPE'];
				}
	
				if (array_key_exists('CONSTRAINT', $attributes))
				{
					$sql.= '('.$attributes['CONSTRAINT'].')';
				}
	
				if (array_key_exists('UNSIGNED', $attributes) and $attributes['UNSIGNED'] === true)
				{
					$sql.= ' UNSIGNED';
				}
	
				if (array_key_exists('DEFAULT', $attributes))
				{
					$sql.= ' DEFAULT \''.$attributes['DEFAULT'].'\'';
				}
	
				if (array_key_exists('null', $attributes))
				{
					$sql.= ($attributes['null'] === true) ? ' null' : ' NOT null';
				}
	
				if (array_key_exists('AUTO_INCREMENT', $attributes) and $attributes['AUTO_INCREMENT'] === true)
				{
					$sql.= ' AUTO_INCREMENT';
				}
			}
			
			// don't add a comma on the end of the last field
			if (++$current_field_count < count($fields))
			{
				$sql.= ',';
			}
		}
		
		return $sql;
	}
	
	/**
	 * Protects fields from SQL injection by adding backticks
	 *
	 * @uses	DBForge::_escape_identifiers
	 * @param	mixed	the items to protect
	 * @param	boolean
	 * @param	boolean
	 * @param	boolean
	 * @return	mixed
	 */
	protected static function _protect_identifiers($item, $prefix_single = false, $protect_identifiers = null, $field_exists = true)
	{
		if ( ! is_bool($protect_identifiers))
		{
			$protect_identifiers = self::$_protect_identifiers;
		}

		if (is_array($item))
		{
			$escaped_array = array();

			foreach ($item as $k => $v)
			{
				$escaped_array[self::_protect_identifiers($k)] = self::_protect_identifiers($v);
			}

			return $escaped_array;
		}

		// Convert tabs or multiple spaces into single spaces
		$item = preg_replace('/[\t ]+/', ' ', $item);
	
		// If the item has an alias declaration we remove it and set it aside.
		// Basically we remove everything to the right of the first space
		$alias = '';
		if (strpos($item, ' ') !== false)
		{
			$alias = strstr($item, " ");
			$item = substr($item, 0, - strlen($alias));
		}

		// This is basically a bug fix for queries that use MAX, MIN, etc.
		// If a parenthesis is found we know that we do not need to 
		// escape the data or add a prefix.  There's probably a more graceful
		// way to deal with this, but I'm not thinking of it -- Rick
		if (strpos($item, '(') !== false)
		{
			return $item.$alias;
		}

		// Break the string apart if it contains periods, then insert the table prefix
		// in the correct location, assuming the period doesn't indicate that we're dealing
		// with an alias. While we're at it, we will escape the components
		if (strpos($item, '.') !== false)
		{
			$parts	= explode('.', $item);
			
			/*
			// Does the first segment of the exploded item match
			// one of the aliases previously identified?  If so,
			// we have nothing more to do other than escape the item
			if (in_array($parts[0], $this->ar_aliased_tables))
			{
				if ($protect_identifiers === true)
				{
					foreach ($parts as $key => $val)
					{
						if ( ! in_array($val, $this->_reserved_identifiers))
						{
							$parts[$key] = $this->_escape_identifiers($val);
						}
					}
				
					$item = implode('.', $parts);
				}			
				return $item.$alias;
			}
			*/
			
			// Is there a table prefix defined in the config file?  If not, no need to do anything
			if (self::$db->table_prefix() != '')
			{
				// We now add the table prefix based on some logic.
				// Do we have 4 segments (hostname.database.table.column)?
				// If so, we add the table prefix to the column name in the 3rd segment.
				if (isset($parts[3]))
				{
					$i = 2;
				}
				// Do we have 3 segments (database.table.column)?
				// If so, we add the table prefix to the column name in 2nd position
				elseif (isset($parts[2]))
				{
					$i = 1;
				}
				// Do we have 2 segments (table.column)?
				// If so, we add the table prefix to the column name in 1st segment
				else
				{
					$i = 0;
				}
				
				// This flag is set when the supplied $item does not contain a field name.
				// This can happen when this function is being called from a JOIN.
				if ($field_exists == false)
				{
					$i++;
				}

				// Verify table prefix and replace if necessary
				if (self::$swap_pre != '' and strncmp($parts[$i], self::$swap_pre, strlen(self::$swap_pre)) === 0)
				{
					$parts[$i] = preg_replace("/^".self::$swap_pre."(\S+?)/", self::$db->table_prefix()."\\1", $parts[$i]);
				}
								
				// We only add the table prefix if it does not already exist
				if (substr($parts[$i], 0, strlen(self::$db->table_prefix())) != self::$db->table_prefix())
				{
					$parts[$i] = self::$db->table_prefix().$parts[$i];
				}
				
				// Put the parts back together
				$item = implode('.', $parts);
			}
			
			if ($protect_identifiers === true)
			{
				$item = self::_escape_identifiers($item);
			}
			
			return $item.$alias;
		}

		// Is there a table prefix?  If not, no need to insert it
		if (self::$db->table_prefix() != '')
		{
			// Verify table prefix and replace if necessary
			if (self::$swap_pre != '' and strncmp($item, self::$swap_pre, strlen(self::$swap_pre)) === 0)
			{
				$item = preg_replace("/^".self::$swap_pre."(\S+?)/", self::$db->table_prefix()."\\1", $item);
			}

			// Do we prefix an item with no segments?
			if ($prefix_single == true and substr($item, 0, strlen(self::$db->table_prefix())) != self::$db->table_prefix())
			{
				$item = self::$db->table_prefix().$item;
			}		
		}

		if ($protect_identifiers === true and ! in_array($item, self::$_reserved_identifiers))
		{
			$item = self::_escape_identifiers($item);
		}
		
		return $item.$alias;
	}
	
	/**
	 * Resets the fields, keys and primary keys arrays.
	 *
	 * @return	void
	 */
	protected static function _reset()
	{
		self::$fields = array();
		self::$keys = array();
		self::$primary_keys = array();
	}
}
