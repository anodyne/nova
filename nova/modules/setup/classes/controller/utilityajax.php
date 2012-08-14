<?php
/**
 * Setup Utility Ajax Controller
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_UtilityAjax extends \Controller
{
	public function before()
	{
		parent::before();

		// make sure nothing times out
		set_time_limit(0);

		// load the nova config file
		\Config::load('nova', 'nova');
		\Config::load('nova::nova', 'nova');
	}

	/**
	 * Add a new field to an existing Nova table.
	 *
	 * @internal
	 * @return	object
	 */
	public function action_install_field()
	{
		// grab the fields
		$table 		= \Security::xss_clean(\Input::post('table'));
		$name 		= \Security::xss_clean(\Input::post('name'));
		$type 		= \Security::xss_clean(\Input::post('type'));
		$constraint	= \Security::xss_clean(\Input::post('constraint'));
		$default 	= \Security::xss_clean(\Input::post('def'));

		// build the array for creating the field
		$field = array(
			$name => array(
				'type' => $type,
				'constraint' => $constraint
			),
		);

		// if a default is provided, put it in
		if ( ! empty($default))
		{
			$field[$name]['default'] = $default;
		}

		// add the column to the table
		\DBUtil::add_fields($table, $field);
		
		// figure out what to return
		$retval = (count(\DB::list_columns($table, '%'.$name.'%')) > 0) ? array('code' => 1) : array('code' => 0);
		
		return json_encode($retval);
	}

	/**
	 * Install a new genre into the database.
	 *
	 * @internal
	 * @return	object
	 */
	public function action_install_genre()
	{
		// grab the genre variable
		$genre = trim(\Security::xss_clean(\Input::post('genre')));

		// pull in the schema data
		include NOVAPATH.'setup/assets/install/fields.php';

		// build an array of genre tables that need to be added
		$tables = array(
			'departments_'.$genre => array(
				'fields' => $fields_departments),
			'positions_'.$genre => array(
				'fields' => $fields_positions),
			'ranks_'.$genre => array(
				'fields' => $fields_ranks),
		);

		foreach ($tables as $table => $value)
		{
			// set the primary key
			$primary_key = (isset($value['id'])) ? array($value['id']) : array('id');

			// set the fields for the table
			$fields = (isset($value['fields'])) ? $value['fields'] : ${'fields_'.$table};

			// create the table with the values
			\DBUtil::create_table($table, $fields, $primary_key);
			
			// if we've specified an index, create it
			if (isset($value['index']))
			{
				foreach ($value['index'] as $index)
				{
					\DBUtil::create_index($table, $index);
				}
			}
		}

		// pause the script for a second
		sleep(1);

		// pull in the genre data
		include_once NOVAPATH.'setup/assets/install/genres/'.strtolower($genre).'.php';

		$insert = array();
		
		foreach ($data as $key => $value)
		{
			foreach ($$value as $k => $v)
			{
				// do the query
				$result = \DB::insert($key)->set($v)->execute();

				// capture whether it was successful or not
				$insert[$key] = (is_array($result));
			}
		}
		
		if (in_array(false, $insert))
		{
			return json_encode(array('code' => 0));
		}
		
		// figure out what to return
		$retval = (count(\DB::list_tables('%_'.$genre)) > 0) ? array('code' => 1) : array('code' => 0);

		// create an event
		\SystemEvent::add('user', __('event.setup.genre_installed', array('genre' => $genre)));
		
		return json_encode($retval);
	}

	/**
	 * Execute a query against the database.
	 *
	 * @internal
	 * @return	object
	 */
	public function action_install_query()
	{
		// grab the fields
		$query = trim(\Security::xss_clean(\Input::post('query')));

		// explode the query to find out what type of query it is
		$queryarray = explode(' ', $query);

		// set up the query
		$sql = \DB::query($query);

		if (strtolower($queryarray[0]) == 'insert' or strtolower($queryarray[0]) == 'create')
		{
			try
			{
				// run the query
				$result = $sql->execute();
				
				// figure out what we should be returning
				$return = ($result[1] > 0) ? 1 : 2;
			}
			catch (\Database_Exception $e)
			{
				$return = 0;
			}
		}
		elseif (strtolower($queryarray[0]) == 'update' or strtolower($queryarray[0]) == 'delete')
		{
			try
			{
				// run the query
				$result = $sql->execute();
				
				// figure out what we should be returning
				$return = ($result > 0) ? 1 : 2;
			}
			catch (\Database_Exception $e)
			{
				$return = 0;
			}
		}
		else
		{
			try
			{
				// run the query
				$result = $sql->execute();
				
				// figure out what we should be returning
				$return = 3;
			}
			catch (\Database_Exception $e)
			{
				$return = 0;
			}
		}
		
		$retval = array('code' => $return);

		return json_encode($retval);
	}

	/**
	 * Create a table along with a simple ID field.
	 *
	 * @internal
	 * @return	object
	 */
	public function action_install_table()
	{
		// grab the table name
		$table = trim(\Security::xss_clean(\Input::post('table')));

		// add the table
		\DBUtil::create_table(
			$table, 
			array(
				'id' => array(
					'constraint' => 11,
					'type' => 'int',
					'auto_increment' => true
				),
			), 
			array('id')
		);
		
		$retval = (count(\DB::list_tables(\DB::table_prefix().$table)) > 0) ? array('code' => 1) : array('code' => 0);
		
		return json_encode($retval);
	}

	/**
	 * Uninstall an existing genre from the database.
	 *
	 * @internal
	 * @return	object
	 */
	public function action_uninstall_genre()
	{
		// grab the genre variable
		$genre = trim(\Security::xss_clean(\Input::post('genre')));

		// drop the tables
		\DBUtil::drop_table('departments_'.$genre);
		\DBUtil::drop_table('positions_'.$genre);
		\DBUtil::drop_table('ranks_'.$genre);
		
		$retval = (count(\DB::list_tables('%_'.$genre)) > 0) ? array('code' => 0) : array('code' => 1);

		// create an event
		\SystemEvent::add('user', __('event.setup.genre_uninstalled', array('genre' => $genre)));
		
		return json_encode($retval);
	}
}
