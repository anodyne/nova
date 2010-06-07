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
		$position = security::xss_clean($_POST['position']);
		$position = (is_numeric($position)) ? $position : FALSE;
		
		// grab the position details
		$item = Jelly::select('position', $position);
		
		// set the output
		$output = (count($item) > 0) ? $item->desc : FALSE;
		
		echo nl2br($output);
	}
	
	public function action_info_show_rank_image()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// set the POST variables
		$rank = security::xss_clean($_POST['rank']);
		$location = security::xss_clean($_POST['location']);
		
		// a little sanity check
		$rank = (is_numeric($rank)) ? $rank : FALSE;
		
		// grab the rank catalogue
		$catalogue = Jelly::select('cataloguerank')->where('location', '=', $location)->load();
		
		// pull the rank record
		$rank = Jelly::select('rank', $rank);
		
		// set the output
		$output = (count($rank) > 0) ? location::image($rank->image.$catalogue->extension, NULL, $location, 'rank') : FALSE;
		
		echo html::image($output);
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
		$genre = trim(security::xss_clean($_POST['genre']));
		
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
	
	public function action_uninstall_genre()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
		// grab the genre variable
		$genre = trim(security::xss_clean($_POST['genre']));
		
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