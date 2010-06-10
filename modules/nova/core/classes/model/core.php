<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Core Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
# TODO: need to get add, count_all, delete and update working
# TODO: need to finish the get and get_all switch statements

class Model_Core extends Model
{
	public $prohibited = array();
	
	public function __construct()
	{
		parent::__construct();
		
		// set the prohibited array
		$this->prohibited = array(
			'get',
			'getwhere',
			'update',
			'delete',
			'insert',
			'set',
			'merge',
			'count_records',
			'select',
			'from',
			'regex',
			'orregex',
			'notregex',
			'ornotregex'
		);
	}
	
	public function add($table = '', $data = '', $optimize = TRUE)
	{
		$query = db::insert($table, $data)->execute();
		
		if ($optimize === TRUE)
		{
			db::query('OPTIMIZE TABLE '.$table);
		}
		
		return $query->count();
	}
	
	public function count_all($table = '', $args = '')
	{
		if (is_array($args))
		{
			// loop through the args and build the query
			foreach ($args as $key => $value)
			{
				if (!in_array($key, $this->prohibited))
				{
					switch ($key)
					{
						case 'join':
							foreach ($value as $v)
							{
								$this->db->join($v[0], $v[1], $v[2], $v[3]);
							}
						
							break;
							
						case 'like':
						case 'orlike':
						case 'notlike':
						case 'ornotlike':
						case 'in':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1], $v[2]);
							}
							
							break;
							
						case 'notin':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1]);
							}
							
							break;
						
						default:
							$this->db->$key($value);
					}
				}
			}
		}
		
		$query = $this->db->count_records($table);
		
		return $query;
	}
	
	public function delete($table = '', $args = '', $optimize = TRUE)
	{
		if (is_array($args))
		{
			// loop through the args and build the query
			foreach ($args as $key => $value)
			{
				if (!in_array($key, $this->prohibited))
				{
					switch ($key)
					{
						case 'join':
							foreach ($value as $v)
							{
								$this->db->join($v[0], $v[1], $v[2], $v[3]);
							}
						
							break;
							
						case 'like':
						case 'orlike':
						case 'notlike':
						case 'ornotlike':
						case 'in':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1], $v[2]);
							}
							
							break;
							
						case 'notin':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1]);
							}
							
							break;
						
						default:
							$this->db->$key($value);
					}
				}
			}
		}
		
		$query = $this->db->delete($table);
		
		if ($optimize === TRUE)
		{
			$this->db->query('OPTIMIZE TABLE '. $table);
		}
		
		return $query;
	}
	
	public function get($table = '', $args = '', $return = '')
	{
		// fire up the database object and start building the query
		$query = db::select()->from($table);
		
		// compile the arguments
		$query = $this->_compile_args($query, $args);
		
		// grab the result object
		$result = $query->as_object()->execute()->current();
		
		// figure out what we're supposed to return
		if (!empty($return) && $result)
		{
			if (!is_array($return))
			{
				return $result->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $result->$r;
				}
				
				return $array;
			}
		}
		
		return $result;
	}
	
	public function get_all($table = '', $args = '')
	{
		// fire up the database object and start building the query
		$query = db::select()->from($table);
		
		// compile the arguemnts into the database builder object
		$query = $this->_compile_args($query, $args);
		
		// grab the result object
		$result = $query->as_object()->execute();
		
		// figure out what should be returned
		$retval = ($result) ? $result : FALSE;
		
		return $retval;
	}
	
	public function update($table = '', $data = '', $args = '', $optimize = TRUE)
	{
		if (is_array($args))
		{
			// loop through the args and build the query
			foreach ($args as $key => $value)
			{
				if (!in_array($key, $this->prohibited))
				{
					switch ($key)
					{
						case 'join':
							foreach ($value as $v)
							{
								$this->db->join($v[0], $v[1], $v[2], $v[3]);
							}
						
							break;
							
						case 'like':
						case 'orlike':
						case 'notlike':
						case 'ornotlike':
						case 'in':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1], $v[2]);
							}
							
							break;
							
						case 'notin':
						case 'order_by':
							foreach ($value as $v)
							{
								$this->db->$key($v[0], $v[1]);
							}
							
							break;
						
						default:
							$this->db->$key($value);
					}
				}
			}
		}
		
		$query = $this->db->update($table, $data);
		
		if ($optimize === TRUE)
		{
			$this->db->query('OPTIMIZE TABLE '. $table);
		}
		
		return $query;
	}
	
	private function _compile_args($query = '', $args = '')
	{
		if (is_array($args))
		{
			// loop through the args and build the query
			foreach ($args as $key => $value)
			{
				if (!in_array($key, $this->prohibited))
				{
					switch ($key)
					{
						case 'join':
							foreach ($value as $v)
							{
								$operand = (isset($v[3])) ? $v[3] : '=';
								$query->join($v[0])->on($v[1], $operand, $v[2]);
							}
						
							break;
							
						case 'like':
						case 'orlike':
						case 'notlike':
						case 'ornotlike':
						case 'in':
							foreach ($value as $v)
							{
								$query->$key($v[0], $v[1], $v[2]);
							}
							
							break;
							
						case 'notin':
						case 'order_by':
							foreach ($value as $v)
							{
								$query->$key($v[0], $v[1]);
							}
							
							break;
							
						case 'where':
						case 'and_where':
						case 'or_where':
							foreach ($value as $v)
							{
								$operand = (isset($v['operand'])) ? $v['operand'] : '=';
								$query->$key($v['field'], $operand, $v['value']);
							}
							break;
						
						default:
							$query->$key($value);
					}
				}
			}
			
			return $query;
		}
		
		return FALSE;
	}
}

// End of file core.php
// Location: modules/nova/classes/model/core.php