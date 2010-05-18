<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database query builder for TRUNCATE statements.
 *
 * @package    Database
 * @author     Oliver Morgan
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Database_Query_Builder_Truncate extends Database_Query_Builder {
	
	protected $_table;
	
	public function __construct($table)
	{
		$this->_table = $table;
		
		parent::__construct(Database::TRUNCATE, '');
	}
	
	public function compile( Database $db)
	{
		return 'TRUNCATE TABLE '.$db->quote_table($this->_table);
	}
	
	public function reset()
	{
		$this->_table = NULL;
	}
	
} // End Database_Query_Builder_Truncate