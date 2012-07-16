<?php
/**
 * The utility controller gives admins options to install new genres,
 * make changes to the database through a user interface, and uninstall
 * Nova entirely from the database.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Utility extends Controller_Base_Setup
{
	public function before()
	{
		parent::before();
	}

	/**
	 * There is nothing that can be done from the index method. If
	 * someone tries to get here manually, we're going to send them
	 * to the Setup Center.
	 *
	 * @return 	void
	 */
	public function action_index()
	{
		// nothing here, so redirect to the main page
		$this->response->redirect('setup/main/index');
	}

	/**
	 * Admins can easily add database tables, add fields to existing database
	 * tables, and run queries against the database with the Database Change
	 * Panel. Make sure to exercise great caution when using the Database
	 * Change Panel as even minor changes to existing tables can cause Nova
	 * to stop working altogether.
	 *
	 * @param	string	the type of change being made (default: '', options: '', table, field, query)
	 * @return 	void
	 */
	public function action_database($type = '')
	{
		$this->_view = 'utility/database';
		$this->_js_view = 'utility/database_js';
		
		$this->_data->title = 'Change Database';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Change Database';
		$this->_data->header->image = 'database-24x24.png';
		$this->_data->controls = false;

		// is the system installed?
		$installed = \Utility::installed();
		
		// show the back button?
		$showbutton = false;

		// build the images
		$this->_data->images = array(
			'loading' => array(
				'src' => 'nova/modules/setup/views/design/images/loading.gif',
				'attr' => array(
					'alt' => 'processing',
					'class' => '')),
		);
		
		if ($installed)
		{
			switch ($type)
			{
				case 'table':
					// set the content
					$this->_data->title.= ' - Add Database Table';
					$this->_data->sub = 'Add a Database Table';
					$this->_data->message = __('setup.change.table');
					
					// build the next step control
					$this->_data->controls = \Form::button('create', 'Create Table', array('type' => 'submit', 'class' => 'btn', 'id' => 'table'));
				break;
					
				case 'field':
					// set the content
					$this->_data->title.= ' - Add Database Table Fiel';
					$this->_data->sub = 'Add a Database Table Field';
					$this->_data->message = __('setup.change.field');
					
					// get the tables
					$tables = \DB::list_tables();
					
					// set the tables select menu options
					foreach ($tables as $t)
					{
						// get the database prefix
						$prefix = \DB::table_prefix();
						
						// set the key without the prefix
						$key = str_replace($prefix, '', $t);
						
						$this->_data->options[$key] = $t;
					}
					
					// set the field type options
					$this->_data->fieldtypes = array(
						'Strings & Text' => array(
							'VARCHAR' => 'Text String (varchar)',
							'TEXT' => 'Text Field',
							'LONGTEXT' => 'Long Text Field'),
						'Numbers' => array(
							'INT' => 'Integer',
							'TINYINT' => 'Tiny Integer',
							'BIGINT' => 'Big Integer'),
						'ENUM' => 'Enumerated List'
					);
					
					// build the next step control
					$this->_data->controls = \Form::button('add', 'Create Field', array('type' => 'submit', 'class' => 'btn', 'id' => 'field'));
				break;
					
				case 'query':
					// set the content
					$this->_data->title.= ' - Run Query';
					$this->_data->sub = 'Run a MySQL Query';
					$this->_data->message = __('setup.change.query');
					
					// build the next step control
					$this->_data->controls = \Form::button('run', 'Run Query', array('type' => 'submit', 'class' => 'btn', 'id' => 'query'));
				break;
				
				default:
					// set the content
					$this->_data->message = __('setup.change.default');
					$this->_data->controls = '<a href="'.\Uri::create('setup/main').'" class="muted pull-right">Back to Setup Center</a>';
				break;
			}
			
			if ($showbutton)
			{
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'back',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('install/changedb').
					form::button('back', ___('change.back'), $next).
					form::close();
			}
		}

		return;
	}

	/**
	 * Admins can install addition genres for use with their sim through the
	 * Genre Panel.
	 *
	 * @return 	void
	 */
	public function action_genre()
	{
		$this->_view = 'utility/genre';
		$this->_js_view = 'utility/genre_js';
		
		$this->_data->title = 'The Genre Panel';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'The Genre Panel';
		$this->_data->header->image = 'switch-24x24.png';
		$this->_data->controls = '<a href="'.\Uri::create('setup/main').'" class="muted pull-right">Back to Setup Center</a>';

		// load the genre info config file
		\Config::load('setup::genres', 'genre');
		
		// get the genre info
		$info = (array) \Config::get('genre');

		// map the genres directory
		$map = \File::read_dir(NOVAPATH.'setup/assets/install/genres');
		
		foreach ($map as $key => $m)
		{
			// drop the extension off
			$length = strlen('.php');
			$value = str_replace('.php', '', $m);
			
			if (array_key_exists($value, $info))
			{
				$genres[$value] = array(
					'name' => $info[$value],
					'installed' => (\DB::list_tables('%_'.$value)) ? true : false
				);
				
				// clear out the item from the map
				unset($map[$key]);
			}
			else
			{
				$additional[$value] = array(
					'name' => $value,
					'installed' => (\DB::list_tables('%_'.$value)) ? true : false
				);
			}
		}
		
		// set the genres list
		$this->_data->genres = (isset($genres)) ? $genres : false;
		$this->_data->additional = (isset($additional)) ? $additional : false;
		
		// set the loading image
		$this->_data->images = array(
			'loading' => array(
				'src' => 'nova/modules/setup/views/design/images/loading.gif',
				'attr' => array(
					'alt' => 'processing',
					'class' => '')),
		);
		
		return;
	}

	/**
	 * Admins can choose to uninstall Nova if they want and all of the Nova
	 * tables will be removed. Any database tables that do not have the table 
	 * prefix defined in the database config file will not be deleted. 
	 * Additionally, there are no attempts by Nova to delete any files during 
	 * uninstall.
	 *
	 * @return 	void
	 */
	public function action_remove()
	{
		$this->_view = 'utility/remove';
		$this->_js_view = 'utility/remove_js';
		
		$this->_data->title = 'Uninstall Nova';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Uninstall Nova';
		$this->_data->header->image = 'exclamation-24x24.png';
		$this->_data->controls = false;

		// is the system installed?
		$installed = \Utility::installed();

		if ($installed)
		{
			if (\Input::method() == 'POST')
			{
				// uninstall the system
				Setup::uninstall();

				// set the message that gets displayed
				$this->_data->message = __('setup.remove.success');

				// build the controls
				$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to Setup Center</a>';
			}
			else
			{
				// set the instructions
				$this->_data->message = __('setup.remove.instructions');

				// build the controls
				$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to Setup Center</a>';
				$this->_data->controls.= \Form::open('setup/utility/remove').
					\Form::button('submit', 'Uninstall', array('type' => 'submit', 'class' => 'btn', 'id' => 'remove')).
					\Form::close();
			}
		}
		else
		{
			// set the instructions
			$this->_data->message = __('setup.remove.no_tables');

			// build the controls
			$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to Setup Center</a>';
		}

		return;
	}
}
