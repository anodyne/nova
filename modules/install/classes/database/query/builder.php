<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database query builder class.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Kohana 3.0 Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
abstract class Database_Query_Builder extends Kohana_Database_Query_Builder {

	public static function compile_statement(array $statement)
	{
		$sql = '';

		foreach($statement as $key => $value)
		{
			$sql .= strtoupper($key);

			if ($value)
			{
				$sql .= '='.strtoupper($value);
			}

			$sql .= ' ';
		}

		$sql = substr($sql, 0, strlen($sql) - 1);

		return $sql;
	}

	
	public static function compile_column(Database_Column $column, Database $db = NULL)
	{
		if ($db === NULL)
		{
			$db = Database::instance();
		}
		
		$sql = $db->quote_identifier($column->name).' '.
			strtoupper($column->datatype);
			
		$parameters = $column->parameters();
		
		if ( ! empty($parameters))
		{
			$sql .= $db->quote($column->parameters());
		}

		foreach ($column->constraints() as $key => $constraint)
		{
			if ( ! is_int($key))
			{
				$sql .= ' '.strtoupper($key).' '.$db->quote($constraint);
			}
			else
			{
				$sql .= ' '.strtoupper($constraint);
			}
		}
		
		return $sql;
	}
	
} // EndDatabase_Query_Builder