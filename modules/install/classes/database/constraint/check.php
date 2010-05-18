<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database check constraint class.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Constraint_Check extends Database_Constraint {
	
	/**
	 * An associated array of checks done by this constraint
	 * 
	 * @var array
	 */
	protected $_checks;
	
	/**
	 * Initializes a new check constraint object.
	 * 
	 * @param	string	The name of the column to perform the statement on.
	 * @param	string	The opertor to compare the value with.
	 * @param	mixed	The value to compare the column with via the operator.
	 * @return	void
	 */
	public function __construct($column, $operator, $value)
	{
		$this->name = 'ck_'.$column;
		
		$this->_checks[] = array(
			$column,
			$operator,
			$value
		);
	}
	
	/**
	 * Adds a check statement using the AND keyword.
	 *
	 * @param	string	The name of the column to perform the statement on.
	 * @param	string	The opertor to compare the value with.
	 * @param	mixed	The value to compare the column with via the operator.
	 * @return	Database_Constraint_Check
	 */
	public function check_and($column, $operator, $value)
	{
		$this->_add_rule($column, $operator, $value, 'AND');
		
		return $this;
	}
	
	/**
	 * Adds a check statement using the OR keyword.
	 *
	 * @param	string	The name of the column to perform the statement on.
	 * @param	string	The opertor to compare the value with.
	 * @param	mixed	The value to compare the column with via the operator.
	 * @return	Database_Constraint_Check
	 */
	public function check_or($column, $operator, $value)
	{
		$this->_add_rule($column, $operator, $value, 'OR');
		
		return $this;
	}
	
	public function compile(Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		$sql = 'CONSTRAINT '.$db->quote_identifier($this->name).' CHECK (';
		
		foreach ($this->_checks as $check)
		{
			$key = key($check);
			$check = current($check);
			
			if ( ! is_int($key))
			{
				$sql .= ' '.$key.' ';
			}
			
			list($column, $operator, $value) = $check[0];
			
			$column = $db->quote_identifier($check[0]);
			$value = $db->quote($value);
			
			$sql .= $column.$operator.$value;
		}
		
		return $sql.')';
	}
	
	public function drop($table, Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		$this->compile($db);
		
		return DB::alter($table)
			->drop($this->name, 'constraint')
			->execute($db);
	}
	
	/**
	 * Adds a check statement using a defined key
	 *
	 * @param	string	The name of the column to perform the statement on.
	 * @param	string	The opertor to compare the value with.
	 * @param	mixed	The value to compare the column with via the operator.
	 * @param	string	The key that seperates this operator from the rest.
	 * @return	Database_Constraint_Check
	 */
	protected function _add_rule($column, $operator, $value, $key)
	{
		$this->name .= '_'.$column;
		
		$this->_checks[] = array(
			'OR' => array(
				$column,
				$operator,
				$value
			)
		);
	}
	
} // End Database_Constraint_Check