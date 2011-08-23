<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Install Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Setup_Installajax extends Controller_Template {
	
	public $db;
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory(Location::file('ajax', null, 'structure'));
		
		// set the variables in the template
		$this->template->content = false;
		
		// get an instance of the database
		$this->db = Database::instance();
		
		// make sure the script doesn't time out
		set_time_limit(0);
	}
	
	public function action_install_field()
	{
		// grab the fields
		$table = trim(Security::xss_clean($_POST['table']));
		$name = trim(Security::xss_clean($_POST['name']));
		$type = trim(Security::xss_clean($_POST['type']));
		$constraint = trim(Security::xss_clean($_POST['constraint']));
		$default = trim(Security::xss_clean($_POST['def']));

		// build the array for creating the field
		$field = array(
			$name => array(
				'type' => $type,
				'constraint' => $constraint
			),
		);

		if ( ! empty($default))
		{
			$field[$name]['default'] = $default;
		}

		// add the column to the table
		DBForge::add_column($table, $field);
		
		$retval = (count($this->db->list_columns($table, '%'.$name.'%')) > 0) ? array('code' => 1) : array('code' => 0);
		
		echo json_encode($retval);
	}

	public function action_install_genre()
	{
		// we don't need the template, just the output from the method
		//$this->template = null;

		// grab the genre variable
		$genre = trim(Security::xss_clean($_POST['genre']));

		// pull in the schema data
		include_once MODPATH.'app/modules/setup/assets/install/fields.php';

		// build an array of genre tables that need to be added
		$tables = array(
			'departments_'.$genre => array(
				'id' => 'id',
				'fields' => $fields_departments),
			'positions_'.$genre => array(
				'id' => 'id',
				'fields' => $fields_positions),
			'ranks_'.$genre => array(
				'id' => 'id',
				'fields' => $fields_ranks),
		);

		foreach ($tables as $key => $value)
		{
			DBForge::add_field($value['fields']);
			DBForge::add_key($value['id'], true);
			DBForge::create_table($key, true);
		}

		// pause the script for a second
		sleep(1);

		// pull in the genre data
		include_once MODPATH.'app/modules/setup/assets/install/genres/'.strtolower($genre).'.php';

		$insert = array();

		foreach ($data as $key => $value)
		{
			foreach ($$value as $k => $v)
			{
				$sql = DB::insert($key)
					->columns(array_keys($v))
					->values(array_values($v))
					->compile($this->db);

				$insert[$key] = $this->db->query(Database::INSERT, $sql, true);
			}
		}
		
		$retval = (count($this->db->list_tables('%_'.$genre)) > 0)
			? array('code' => 1, 'message' => '')
			: array('code' => 0, 'message' => 'Could not install the requested genre');
		
		echo json_encode($retval);
	}

	public function action_install_query()
	{
		// grab an instance of the database
		$db = Database::instance();

		// grab the fields
		$query = trim(Security::xss_clean($_POST['query']));

		// explode the query to find out what type of query it is
		$queryarray = explode(' ', $query);

		if (strtolower($queryarray[0]) == 'insert')
		{
			try {
				$result = $db->query(Database::INSERT, $query, true);
				$return = ($result[1] > 0) ? 1 : 2;
			} catch (Exception $e) {
				$return = 0;
			}
		}
		elseif (strtolower($queryarray[0]) == 'update')
		{
			try {
				$result = $db->query(Database::UPDATE, $query, true);
				$return = ($result > 0) ? 1 : 2;
			} catch (Exception $e) {
				$return = 0;
			}
		}
		elseif (strtolower($queryarray[0]) == 'delete')
		{
			try {
				$result = $db->query(Database::DELETE, $query, true);
				$return = ($result > 0) ? 1 : 2;
			} catch (Exception $e) {
				$return = 0;
			}
		}
		else
		{
			try {
				$result = $db->query(null, $query, true);
				$return = 3;
			} catch (Exception $e) {
				$return = 0;
			}
		}
		
		$retval = array('code' => $return);

		echo json_encode($retval);
	}

	public function action_install_table()
	{
		// grab an instance of the database
		$db = Database::instance();

		// grab the genre variable
		$table = trim(Security::xss_clean($_POST['table']));

		// add an id field to keep everything happy
		DBForge::add_field('id');

		// add the table
		DBForge::create_table($table, true);
		
		$retval = (count($db->list_tables('%_'.$table)) > 0) ? array('code' => 1) : array('code' => 0);
		
		echo json_encode($retval);
	}

	public function action_uninstall_genre()
	{
		// grab the genre variable
		$genre = trim(Security::xss_clean($_POST['genre']));

		// drop the tables
		DBForge::drop_table('departments_'.$genre);
		DBForge::drop_table('positions_'.$genre);
		DBForge::drop_table('ranks_'.$genre);
		
		$retval = (count($this->db->list_tables('%_'.$genre)) > 0)
			? array('code' => 0, 'message' => 'Could not uninstall the requested genre')
			: array('code' => 1, 'message' => '');
		
		echo json_encode($retval);
	}
}
