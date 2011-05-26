<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		2.0
 */

class Controller_Nova_Ajax extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull the settings and put them into the options object
		$this->options = Model_Settings::get_settings($this->settingsArray);
		
		// set the variables
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the shell
		$this->template = View::factory(Location::file('ajax', null, 'structure'));
		
		// set the variables in the template
		$this->template->content = false;
	}
	
	/**
	 * Because we extend Controller_Nova_Base, we have to blank out the after
	 * method otherwise an exception will be thrown. This means that for methods
	 * that need to output to the template, we'll have to do all that work in
	 * the actual method instead of relying on it to magically work.
	 */
	public function after() {}
	
	public function action_info_show_position_desc()
	{
		// we don't need the template, just the output from the method
		$this->template = null;
		
		// set the POST variable
		$position = Security::xss_clean($_POST['position']);
		$position = (is_numeric($position)) ? $position : false;
		
		// grab the position details
		$item = Model_Position::find($position);
		
		// set the output
		$output = (count($item) > 0) ? $item->desc : false;
		
		echo nl2br($output);
	}
	
	public function action_info_show_rank_image()
	{
		// we don't need the template, just the output from the method
		$this->template = null;
		
		// set the POST variables
		$rank = Security::xss_clean($_POST['rank']);
		$location = Security::xss_clean($_POST['location']);
		
		// a little sanity check
		$rank = (is_numeric($rank)) ? $rank : false;
		
		// grab the rank catalogue
		$catalogue = Model_CatalogueRank::get_item($location);
		
		// pull the rank record
		$rank = Model_Rank::find($rank);
		
		// set the output
		$output = (count($rank) > 0) ? Location::image($rank->image.$catalogue->extension, null, $location, 'rank') : false;
		
		echo Html::image($output);
	}
	
	public function action_install_field()
	{
		// we don't need the template, just the output from the method
		$this->template = null;
		
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
		
		if ( ! empty($default))
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
		$this->template = null;
		
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
			DBForge::add_key($value['id'], true);
			DBForge::create_table($key, true);
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
					
				$insert[$key] = $db->query(Database::INSERT, $sql, true);
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
		$this->template = null;
		
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
				$return = ($result[1] > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		elseif (strtolower($queryarray[0]) == 'update')
		{
			try {
				$result = $db->query(Database::UPDATE, $query, true);
				$return = ($result > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		elseif (strtolower($queryarray[0]) == 'delete')
		{
			try {
				$result = $db->query(Database::DELETE, $query, true);
				$return = ($result > 0) ? '1' : '2';
			} catch (Exception $e) {
				$return = '0';
			}
		}
		else
		{
			try {
				$result = $db->query(null, $query, true);
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
		$this->template = null;
		
		// grab an instance of the database
		$db = Database::instance();
		
		// initialize the forge
		$forge = new DBForge;
		
		// grab the genre variable
		$table = trim(Security::xss_clean($_POST['table']));
		
		// add an id field to keep everything happy
		DBForge::add_field('id');
		
		// add the table
		DBForge::create_table($table, true);
		
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
		$this->template = null;
		
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
	
	/**
	 * Used by users/index for user management
	 */
	public function action_search_users()
	{
		if ($this->request->is_ajax())
		{
			// get the string we're searching for
			$search = Security::xss_clean($_POST['query']);
			
			if ( ! empty($search))
			{
				// what should we be searching for?
				$only_search_email = Valid::regex($search, '(@)');
				
				/**
				 * Search for email addresses that match the string
				 */
				$email = "SELECT userid, name, email FROM nova_users WHERE email LIKE '%$search%'";
				$emailR = mysql_query($email);
				$emailA = array();
				
				while ($row = mysql_fetch_array($emailR))
				{
					$emailA[] = $row;
				}
				
				if (count($emailA) > 0)
				{
					foreach ($emailA as $key => $value)
					{
						$retval['email'][] = array(
							'userid'	=> $value[0],
							'name'		=> $value[1],
							'email' 	=> $value[2],
						);
					}
				}
				
				if ( ! $only_search_email)
				{
					/**
					 * Search for user names that match the string
					 */
					$name = "SELECT userid, name, email FROM nova_users WHERE name LIKE '%$search%'";
					$nameR = mysql_query($name);
					$nameA = array();
					
					while ($row = mysql_fetch_array($nameR))
					{
						$nameA[] = $row;
					}
					
					if (count($nameA) > 0)
					{
						foreach ($nameA as $key => $value)
						{
							$retval['name'][] = array(
								'userid'	=> $value[0],
								'name'		=> $value[1],
								'email' 	=> $value[2],
							);
						}
					}
					
					/**
					 * Search through for characters with a name that matches the string
					 */
					$chars = "SELECT a.userid, a.name, a.email, b.first_name, b.last_name FROM nova_users AS a, nova_characters AS b ";
					$chars.= "WHERE (b.first_name LIKE '%$search%' OR b.last_name LIKE '%$search%') AND a.userid = b.user";
					$charsR = mysql_query($chars);
					$charsA = array();
					
					while ($row = mysql_fetch_array($charsR))
					{
						$charsA[] = $row;
					}
					
					if (count($charsA) > 0)
					{
						foreach ($charsA as $key => $value)
						{
							$retval['characters'][] = array(
								'userid'	=> $value[0],
								'name'		=> $value[1],
								'email' 	=> $value[2],
								'fname'		=> $value[3],
								'lname'		=> $value[4],
							);
						}
					}
				}
			}
			else
			{
				$retval = array();
			}
			
			echo json_encode($retval);
			
			if (Valid::regex($search, '(@)'))
			{
				// the string contains @ which means they're searching for an email
				// address so we should only search for emails and return email results
				
				if ( ! empty($search))
				{
					$email = "SELECT name, email FROM nova_users WHERE email LIKE '%$search%'";
					$emailR = mysql_query($email);
					$emailA = array();
					
					while ($row = mysql_fetch_array($emailR))
					{
						$emailA[] = $row;
					}
					
					if (count($emailA) > 0)
					{
						foreach ($emailA as $key => $value)
						{
							$retval['email'][] = array(
								'name' => $value[0],
								'email' => $value[1]
							);
						}
					}
				}
				else
				{
					$retval = array();
				}
				
				echo json_encode($retval);
			}
			else
			{
				// the string doesn't contain @ which means they're searching for
				// everything so we should search everything and return everything
				
				if ( ! empty($search))
				{
					$name = "SELECT name, email FROM nova_users WHERE name LIKE '%$search%'";
					$nameR = mysql_query($name);
					$nameA = array();
					
					while ($row = mysql_fetch_array($nameR))
					{
						$nameA[] = $row;
					}
					
					$email = "SELECT name, email FROM nova_users WHERE email LIKE '%$search%'";
					$emailR = mysql_query($email);
					$emailA = array();
					
					while ($row = mysql_fetch_array($emailR))
					{
						$emailA[] = $row;
					}
					
					if (count($nameA) > 0)
					{
						foreach ($nameA as $key => $value)
						{
							$retval['name'][] = array(
								'name' => $value[0],
								'email' => $value[1]
							);
						}
					}
					
					if (count($emailA) > 0)
					{
						foreach ($emailA as $key => $value)
						{
							$retval['email'][] = array(
								'name' => $value[0],
								'email' => $value[1]
							);
						}
					}
				}
				else
				{
					$retval = array();
				}
				
				echo json_encode($retval);
			}
		}
	}
}
