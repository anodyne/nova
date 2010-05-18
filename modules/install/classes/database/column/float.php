<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database float column class.
 *
 * @package		DBForge
 * @author		Oliver Morgan
 * @uses		Database
 * @copyright	(c) 2009 Oliver Morgan
 * @license		MIT
 */
class Database_Column_Float extends Database_Column_Int {
	
	/**
	 * The number of decimal places permitted by the float.
	 * 
	 * @var int
	 */
	public $precision;
	
	/**
	 * Whether the value is fixed in size or not.
	 * 
	 * @var bool
	 */
	public $exact;
	
	public function parameters($set = NULL)
	{
		if ($set === NULL)
		{
			// Scale comes before precision.
			$params = parent::parameters();
			
			// We dont want empty arrays
			return isset($this->precision) ? $params + array($this->precision) : $params;
		}
		else
		{
			// Set the integer's scale.
			parent::parameters($set[0]);
			
			// Set the decimal's precision.
			$this->precision = $set[1];
		}
	}
	
	protected function _load_schema(array $schema)
	{
		$this->exact = arr::get($schema, 'exact', FALSE);
		$this->precision = arr::get($schema, 'numeric_precision');
	}
	
	protected function _constraints()
	{
		return array();
	}
	
} // End Database_Column_Float