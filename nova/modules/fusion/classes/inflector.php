<?php

class Inflector extends Kohana_Inflector {
	
	/**
	 * Takes a class name and determines the table name.  The table name is a
	 * pluralized version of the class name.
	 *
	 * @param	string	$class_name the table name
	 * @return	string	the table name
	 */
	public static function tableize($class_name)
	{
		$class_name = static::denamespace($class_name);
		if (strncasecmp($class_name, 'Model_', 6) === 0)
		{
			$class_name = substr($class_name, 6);
		}
		return strtolower(static::pluralize(static::underscore($class_name)));
	}
	
	/**
	 * Takes the namespace off the given class name.
	 *
	 * @param	string	$class_name	the class name
	 * @return	string	the string without the namespace
	 */
	public static function denamespace($class_name)
	{
		$class_name = trim($class_name, '\\');
		if ($last_separator = strrpos($class_name, '\\'))
		{
			$class_name = substr($class_name, $last_separator + 1);
		}
		return $class_name;
	}
	
	/**
	 * Alias for the Kohana Inflector's plural method.
	 *
	 * @return	string
	 */
	public static function pluralize($word)
	{
		return static::plural($word);
	}
	
	/**
	 * Alias for the Kohana Inflector's uncountable method.
	 *
	 * @return	boolean
	 */
	public static function is_countable($word)
	{
		return static::uncountable($word);
	}
	
	/**
	 * Returns the namespace of the given class name.
	 *
	 * @param   string  $class_name  the class name
	 * @return  string  the string without the namespace
	 */
	public static function get_namespace($class_name)
	{
		$class_name = trim($class_name, '\\');
		
		if ($last_separator = strrpos($class_name, '\\'))
		{
			return substr($class_name, 0, $last_separator + 1);
		}
		
		return '';
	}
	
	/**
	 * Takes a table name and creates the class name.
	 *
	 * @param	string	$table_name	the table name
	 * @return	string	the class name
	 */
	public static function classify($table_name)
	{
		return preg_replace('/(^|_)(.)/e', "strtoupper('\\1\\2')", static::singularize($table_name));
	}
	
	/**
	 * Alias of Kohana Inflector's singular method.
	 *
	 * @return	string
	 */
	public static function singularize($word)
	{
		return static::singular($word);
	}
	
	/**
	 * Gets the foreign key for a given class.
	 *
	 * @param	string	$class_name		the class name
	 * @param	bool	$use_underscore	whether to use an underscore or not
	 * @return	string	the foreign key
	 */
	public static function foreign_key($class_name, $use_underscore = true)
	{
		$class_name = static::denamespace(strtolower($class_name));
		
		if (strncasecmp($class_name, 'Model_', 6) === 0)
		{
			$class_name = substr($class_name, 6);
		}
		
		return static::underscore(static::demodulize($class_name)).($use_underscore ? "_id" : "id");
	}
	
	/**
	 * Takes the class name out of a modulized string.
	 *
	 * @param	string	$class_name_in_module	the modulized class
	 * @return	string	the string without the class name
	 */
	public static function demodulize($class_name_in_module)
	{
		return preg_replace('/^.*::/', '', strval($class_name_in_module));
	}
}
