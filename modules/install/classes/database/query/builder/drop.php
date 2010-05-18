<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database query builder for DROP statements.
 *
 * @package    Database
 * @author     Oliver Morgan
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Database_Query_Builder_Drop extends Database_Query_Builder {
	
	protected $_name;
	
	protected $_drop_type;
	
	public function __construct($type, $name)
	{
		$this->_drop_type = strtolower($type);
		$this->_name = $name;
		
		parent::__construct(Database::DROP, '');
	}
	
	public function compile(Database $db)
	{
		switch($this->_drop_type)
		{
			case 'database':
				return 'DROP DATABASE '.$db->quote($this->_name);
			
			case 'table':
				return 'DROP TABLE '.$db->quote_table($this->_name);
				
			default:
				return 'DROP '.strtoupper($this->_drop_type).' '.$db->quote_identifier($this->_name);
		}
	}
	
	public function reset()
	{
		$this->_drop_type =
		$this->_name = NULL;
	}
	
} // End Database_Query_Builder_Drop