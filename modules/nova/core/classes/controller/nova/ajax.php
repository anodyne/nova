<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Ajax extends Controller_Nova_Base
{
	public function before()
	{
		parent::before();
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the shell
		$this->template = View::factory('_common/layouts/ajax', array('skin' => $this->skin, 'sec' => 'main'));
		
		// set the variables in the template
		$this->template->content = FALSE;
	}
	
	public function action_info_show_position_desc()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// set the POST variable
		$position = Security::xss_clean($_POST['position']);
		$position = (is_numeric($position)) ? $position : FALSE;
		
		// grab the position details
		$item = Jelly::query('position', $position)->select();
		
		// set the output
		$output = (count($item) > 0) ? $item->desc : FALSE;
		
		echo nl2br($output);
	}
	
	public function action_info_show_rank_image()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// set the POST variables
		$rank = Security::xss_clean($_POST['rank']);
		$location = Security::xss_clean($_POST['location']);
		
		// a little sanity check
		$rank = (is_numeric($rank)) ? $rank : FALSE;
		
		// grab the rank catalogue
		$catalogue = Jelly::query('cataloguerank')->where('location', '=', $location)->limit(1)->select();
		
		// pull the rank record
		$rank = Jelly::query('rank', $rank)->select();
		
		// set the output
		$output = (count($rank) > 0) ? Location::image($rank->image.$catalogue->extension, NULL, $location, 'rank') : FALSE;
		
		echo html::image($output);
	}
	
	public function action_install_field()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
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
		
		if (!empty($default))
		{
			$field[$name]['default'] = $default;
		}
		
		// add the column to the table
		DBForge::add_column($table, $field);
		
		if (count($db->list_columns($table, '%'.$name.'%')) > 0)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_install_genre()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
		// grab the genre variable
		$genre = trim(Security::xss_clean($_POST['genre']));
		
		// pull in the schema data
		include_once MODPATH.'install/assets/fields'.EXT;
		
		// build an array of genre tables that need to be added
		$tables = array(
			'departments_'.$genre => array(
				'id' => 'dept_id',
				'fields' => $fields_departments),
			'positions_'.$genre => array(
				'id' => 'pos_id',
				'fields' => $fields_positions),
			'ranks_'.$genre => array(
				'id' => 'rank_id',
				'fields' => $fields_ranks),
		);
		
		foreach ($tables as $key => $value)
		{
			DBForge::add_field($value['fields']);
			DBForge::add_key($value['id'], TRUE);
			DBForge::create_table($key, TRUE);
		}
		
		// pause the script for a second
		sleep(1);
		
		// pull in the genre data
		include_once MODPATH.'install/assets/genres/'.strtolower($genre).EXT;
		
		$insert = array();
		
		foreach ($data as $key => $value)
		{
			foreach ($$value as $k => $v)
			{
				$sql = db::insert($key)
					->columns(array_keys($v))
					->values(array_values($v))
					->compile($db);
					
				$insert[$key] = $db->query(Database::INSERT, $sql, TRUE);
			}
		}
		
		if (count($db->list_tables('%_'.$genre)) > 0)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_install_query()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// grab the fields
		$query = trim(Security::xss_clean($_POST['query']));
		
		// explode the query to find out what type of query it is
		$queryarray = explode(' ', $query);
		
		if (strtolower($queryarray[0]) == 'insert')
		{
			try {
				$result = $db->query(Database::INSERT, $query, TRUE);
				$return = ($result[1] > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		elseif (strtolower($queryarray[0]) == 'update')
		{
			try {
				$result = $db->query(Database::UPDATE, $query, TRUE);
				$return = ($result > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		elseif (strtolower($queryarray[0]) == 'delete')
		{
			try {
				$result = $db->query(Database::DELETE, $query, TRUE);
				$return = ($result > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		else
		{
			try {
				$result = $db->query(NULL, $query, TRUE);
				echo '3';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		
		echo $return;
	}
	
	public function action_install_table()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
		// grab the genre variable
		$table = trim(Security::xss_clean($_POST['table']));
		
		// add an id field to keep everything happy
		DBForge::add_field('id');
		
		// add the table
		DBForge::create_table($table, TRUE);
		
		if (count($db->list_tables('%_'.$table)) > 0)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_uninstall_genre()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
		// grab the genre variable
		$genre = trim(Security::xss_clean($_POST['genre']));
		
		// drop the tables
		DBForge::drop_table('departments_'.$genre);
		DBForge::drop_table('positions_'.$genre);
		DBForge::drop_table('ranks_'.$genre);
		
		if (count($db->list_tables('%_'.$genre)) > 0)
		{
			echo '0';
		}
		else
		{
			echo '1';
		}
	}
}