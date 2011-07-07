<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Install Controller
 *
 * @package		Install
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

# TODO: remove the environment check around the login redirect

class Controller_Setup_Install extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			$this->request->redirect('setup/main/config');
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step', 'main', 'test');
			
			// you need to be logged in for these pages
			$protectedsegs = array('changedb', 'genre', 'remove');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::$config->load('nova.app_db_tables');
			
			// make sure the system is installed
			if (count($db->list_tables($db->table_prefix().'%')) < $tables and ! (in_array($this->request->action(), $safesegs)))
			{
				$this->request->redirect('setup/main/index');
			}
			
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (count($db->list_tables($db->table_prefix().'%')) == $tables)
			{
				if (in_array($this->request->action(), $protectedsegs))
				{
					// get an instance of the session
					$session = Session::instance();
					
					// make sure there's a session
					if ($session->get('userid'))
					{
						// are they a sysadmin?
						$sysadmin = Auth::is_type('sysadmin', $session->get('userid'));
						
						// if they aren't, send them away
						if ($sysadmin === false)
						{
							$this->request->redirect('login/error/1');
						}
					}
					else
					{
						if (Kohana::$environment !== Kohana::DEVELOPMENT)
						{
							// no session? send them away
							$this->request->redirect('login/error/1');
						}
					}
				}
			}
		}
		
		// set the locale
		i18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory(Location::file('setup', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 				= Kohana::$config->load('nova.app_name').' :: ';
		$this->template->javascript			= false;
		$this->template->layout				= View::factory(Location::file('setup', null, 'templates'));
		$this->template->layout->label		= false;
		$this->template->layout->flash		= false;
		$this->template->layout->controls	= false;
		$this->template->layout->content	= false;
	}
	
	public function after()
	{
		parent::after();
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_changedb($view = 'main')
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_changedb'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_changedb_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// build the images
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/nova/install/views/design/images/loading-circle-large.gif',
				'attr' => array(
					'alt' => ___('processing'),
					'class' => '')),
		);
		
		// show the back button?
		$showbutton = false;
		
		switch ($view)
		{
			case 'table':
				// set the header
				$data->header = ___('change.title.addtable');
				
				// set the message
				$data->message = ___("change.text.addtable");
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'table',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(__(':create table', array(':create' => ___('create')))), $next);
			break;
				
			case 'field':
				// set the header
				$data->header = ___('change.title.addfield');
				
				// set the message
				$data->message = ___('change.text.addfield');
				
				// set up the options
				$data->options = array();
				
				// get the tables
				$tables = Database::instance()->list_tables();
				
				// set the tables select menu options
				foreach ($tables as $t)
				{
					// get the database prefix
					$prefix = Database::instance()->table_prefix();
					
					// set the key without the prefix
					$key = str_replace($prefix, '', $t);
					
					$data->options[$key] = $t;
				}
				
				// set the field type options
				$data->fieldtypes = array(
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
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'field',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(___(':create field', array(':create' => ___('create')))), $next);
				
			break;
				
			case 'query':
				// set the header
				$data->header = ___('change.title.runquery');
				
				// set the message
				$data->message = ___('change.text.runquery');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'query',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(___('run query')), $next);
				
			break;
			
			default:
				// set the message
				$data->message = ___('change.text.default');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'back',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('install/index').
					form::button('back', ucwords(___('install center')), $next).
					form::close();
			break;
		}
		
		// content
		$this->template->title.= ___('change.title.default');
		$this->template->layout->label = ___('change.title.default');
		
		if ($showbutton === true)
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
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_genre()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_genre'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_genre_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
	
		// set the message
		$data->message = __('genre.message', array(':path' => APPFOLDER.'/config/nova'.EXT));
		
		// map the genres directory
		$map = Utility::directory_map(MODPATH.'nova/install/assets/genres/');
		
		// clear out the index file
		$indexkey = array_search('index.html', $map);
		unset($map[$indexkey]);
		
		// get the genre info
		$info = (array) Kohana::$config->load('genreinfo');
		
		foreach ($map as $key => $m)
		{
			// drop the extension off
			$length = strlen(EXT);
			$value = str_replace(EXT, '', $m);
			
			if (array_key_exists($value, $info))
			{
				$genres[$value] = array(
					'name' => $info[$value],
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? true : false
				);
				
				// clear out the item from the map
				unset($map[$key]);
			}
			else
			{
				$additional[$value] = array(
					'name' => $value,
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? true : false
				);
			}
		}
		
		// set the genres list
		$data->genres = (isset($genres)) ? $genres : false;
		$data->additional = (isset($additional)) ? $additional : false;
		
		// set the loading image
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/nova/install/design/images/loading-circle-large.gif',
				'attr' => array(
					'alt' => __('processing'),
					'class' => '')),
		);
		
		// content
		$this->template->title.= __('The Genre Panel');
		$this->template->layout->label = __('The Genre Panel');
		
		// send the response
		$this->response->body($this->template);
	}
	
	/**
	 * The install/main page can display several errors depending on the situation.
	 * The following errors have been built in to the install/main page:
	 *
	 *     0 - no errors
	 *     1 - the system is already installed
	 *     2 - you must be a system administrator to update the genre
	 */
	public function action_main($error = 0)
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_main'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_main_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		if ((is_numeric($error) and $error > 0))
		{
			$this->template->layout->flash = View::factory('install/pages/flash');
			$this->template->layout->flash->status = ($error == 1) ? 'info' : 'error';
			$this->template->layout->flash->message = ___('install.error.error_'.$error);
		}
		
		// content
		$this->template->title.= ___('Installation Center');
		$this->template->layout->label = ___('Installation Center');
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_remove()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_remove'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_remove_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (isset($_POST['submit']))
		{
			// grab an instance of the database
			$db = Database::instance();
			
			// get the database config
			$dbconf = Kohana::$config->load('database.default');
			
			// get an array of the tables
			$tables = $db->list_tables();
			
			// get the prefix length
			$prefix_len = strlen($dbconf['table_prefix']);
			
			// go through all the tables to find out if its part of the system or not
			foreach ($tables as $key => $value)
			{
				if (substr($value, 0, $prefix_len) != $dbconf['table_prefix'])
				{
					unset($tables[$key]);
				}
				else
				{
					$tables[$key] = substr_replace($value, '', 0, $prefix_len);
				}
			}
			
			// loop through and uninstall the system
			foreach ($tables as $v)
			{
				DBForge::drop_table($v);
			}
			
			// set the failure message
			$data->message = ___('install.remove.success');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/index').form::button('install', ___('Install Center'), $next).form::close();
		}
		else
		{
			// set the instructions
			$data->message = ___('install.remove.message');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/remove').form::button('submit', ___('Uninstall'), $next).form::close();
		}
		
		// content
		$this->template->title.= ___('Uninstall Nova');
		$this->template->layout->label = ___('Uninstall Nova');
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_step()
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// get an instance of the database
		$db = Database::instance();
		
		// get an instance of the session
		$session = Session::instance();
		
		// figure out if the system is installed
		$tables = $db->list_tables();
		
		// is installation allowed?
		$allowed = true;
		
		if (Kohana::$config->load('nova.genre') == '')
		{
			// installation not allowed
			$allowed = false;
			
			// show the flash message
			$this->template->layout->flash = View::factory('components/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = ___('setup.error.no_genre', array(':path' => APPFOLDER.'/config/nova.php'));
		}
		
		switch ($this->request->param('id'))
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/install/step0');
				
				// create a new js view
				$this->template->javascript = View::factory('components/js/install/step0_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.install.step0.instructions'));
				
				// content
				$this->template->title.= ___('Install Nova');
				$this->template->layout->label = ___('Getting Started');
				
				if ($allowed)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::open('setup/install/step/1').form::button('next', ___('Start Install'), $next).form::close();
				}
				
			break;
				
			case 1:
				if (HTTP_Request::POST == $this->request->method())
				{
					// update the character set
					$dbconfig = Kohana::$config->load('database');
					$db->set_charset($dbconfig['default']['charset']);
					
					// pull in the field information
					include_once MODPATH.'app/modules/setup/assets/install/fields.php';
					
					foreach ($data as $key => $value)
					{
						$fieldID = (isset($value['id'])) ? $value['id'] : 'id';
						$fieldName = (isset($value['fields'])) ? $value['fields'] : 'fields_'.$key;
						
						DBForge::add_field($$fieldName);
						DBForge::add_key($fieldID, true);
						
						if (isset($value['index']))
						{
							foreach ($value['index'] as $index)
							{
								DBForge::add_key($index);
							}
						}
						
						DBForge::create_table($key, true);
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from inserting the tables
					$data = null;
					
					// pull in the basic data
					include_once MODPATH.'app/modules/setup/assets/install/data.php';
					
					$insert = array();
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$sql = DB::insert($value)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$insert[$value] = $db->query(Database::INSERT, $sql, true);
						}
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from insert the data
					$data = null;
					
					// pull in the genre data
					include_once MODPATH.'app/modules/setup/assets/install/genres/'.strtolower(Kohana::$config->load('nova.genre')).'.php';
					
					$genre = array();
					
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$sql = DB::insert($key_d)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$genre[$key_d] = $db->query(Database::INSERT, $sql, true);
						}
					}
					
					if (Kohana::$config->load('install.dev'))
					{
						// pause the script for a second
						sleep(1);
						
						// wipe out the data from insert the data
						$data = null;
						
						// pull in the development test data
						include_once MODPATH.'app/modules/setup/assets/install/dev.php';
						
						$insert = array();
						
						foreach ($data as $value)
						{
							foreach ($$value as $k => $v)
							{
								$sql = DB::insert($value)
									->columns(array_keys($v))
									->values(array_values($v))
									->compile($db);
									
								$insert[$value] = $db->query(Database::INSERT, $sql, true);
							}
						}
					}
				}
				
				// get the number of tables
				$tables = $db->list_tables();
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/install/step1');
				
				// create a new js view
				$this->template->javascript = View::factory('components/js/install/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// get the questions from the db
				$questions = Model_SecurityQuestion::get_questions();
				
				// set the questions variable
				$data->questions = array('' => ___('Please Select One'));
				
				if (count($questions) > 0)
				{
					foreach ($questions as $q)
					{
						$data->questions[$q->id] = $q->value;
					}
				}
				
				// set the validation errors
				$data->errors = ($session->get('errors')) ? $session->get('errors') : false;
				
				// make sure the proper message is displayed
				$data->message = ($data->errors === false)
					? (count($tables) < Kohana::$config->load('nova.app_db_tables')) ? ___('setup.install.step1.failure') : ___('setup.install.step1.success')
					: ___('setup.install.step1.errors');
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading-circle-large.gif',
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// get the default rank object
				$catalogue = Model_CatalogueRank::get_default();
				
				// find out where the location of the default rank catalogue item is
				$rankdefault = $catalogue->location;
				
				// pull the rank record
				$rank = Model_Rank::find($session->get('rank', 1));
				
				$data->default_rank = array(
					'src' => APPFOLDER.'/assets/common/'.Kohana::$config->load('nova.genre').'/ranks/'.$rankdefault.'/'.$rank->image.$catalogue->extension,
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// content
				$this->template->title.= ___('Install Nova: Basic Information');
				$this->template->layout->label = ___('Just the Basics');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::$config->load('nova.app_db_tables')) 
					? false 
					: Form::button('next', ___('Next Step'), $next).Form::close();
			break;
				
			case 2:
				if (HTTP_Request::POST == $this->request->method())
				{
					$validate = Validation::factory($_POST)
						->rule('email', 'not_empty', array(':value'))
						->rule('email', 'email', array(':value'))
						->rule('password', 'not_empty', array(':value'))
						->rule('password_confirm', 'not_empty', array(':value'))
						->rule('password_confirm', 'matches', array(':validation', 'password_confirm', 'password'))
						->rule('security_question', 'not_empty', array(':value'))
						->rule('security_answer', 'not_empty', array(':value'));
						
					if ($validate->check())
					{
						// wipe out the session if everything is good
						$session->destroy();
						
						// get the data
						$simname = trim(Security::xss_clean($_POST['sim_name']));
						$name = trim(Security::xss_clean($_POST['name']));
						$email = trim(Security::xss_clean($_POST['email']));
						$password = trim(Security::xss_clean($_POST['password']));
						$question = trim(Security::xss_clean($_POST['security_question']));
						$answer = trim(Security::xss_clean($_POST['security_answer']));
						$first_name = trim(Security::xss_clean($_POST['first_name']));
						$last_name = trim(Security::xss_clean($_POST['last_name']));
						$position = trim(Security::xss_clean($_POST['position']));
						$rank = trim(Security::xss_clean($_POST['rank']));
						
						// an array of settings to update
						$settings = array(
							'sim_name' => $simname,
							'email_subject' => '['.$simname.']',
							'default_email_address' => 'donotreply@'.strtolower($simname),
							'default_email_name' => $simname,
						);
						
						// update the settings
						Model_Settings::update_settings($settings);
						
						// an array of data for creating the user
						$userinfo = array(
							'name' => $name,
							'email' => $email,
							'password' => Auth::hash($password),
							'role_id' => Model_AccessRole::SYSADMIN,
							'is_sysadmin' => (int) true,
							'is_game_master' => (int) true,
							'is_webmaster' => (int) true,
							'skin_main' => Model_CatalogueSkinSec::get_default('main')->skin,
							'skin_admin' => Model_CatalogueSkinSec::get_default('admin')->skin,
							'display_rank' => Model_CatalogueRank::get_default(true),
							'security_question' => $question,
							'security_answer' => sha1($answer),
							'join_date' => Date::now(),
						);
						
						// create the user
						$crUser = Model_User::create_user($userinfo);
						
						// an array of data for creating the character
						$characterinfo = array(
							'user_id' => $crUser->id,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'position1_id' => $position,
							'rank_id' => $rank,
							'status' => 'active',
							'activated' => Date::now(),
						);
						
						// create the character
						$crCharacter = Model_Character::create_character($characterinfo);
						
						// update the user with the character info
						Model_User::update_user($crUser->id, array('character_id' => $crCharacter->id));
						
						// do the quick installs
						Utility::install_rank();
						Utility::install_skin();
						Utility::install_widget();
						
						// do the registration
						$this->_register();
					}
					else
					{
						// set the session variables
						$session->set('sim_name', Security::xss_clean($_POST['sim_name']));
						$session->set('name', Security::xss_clean($_POST['name']));
						$session->set('email', Security::xss_clean($_POST['email']));
						$session->set('password', Security::xss_clean($_POST['password']));
						$session->set('security_question', Security::xss_clean($_POST['security_question']));
						$session->set('security_answer', Security::xss_clean($_POST['security_answer']));
						$session->set('first_name', Security::xss_clean($_POST['first_name']));
						$session->set('last_name', Security::xss_clean($_POST['last_name']));
						$session->set('position', Security::xss_clean($_POST['position']));
						$session->set('rank', Security::xss_clean($_POST['rank']));
						$session->set('errors', $validate->errors('register'));
						
						// redirect back to step 1
						$this->request->redirect('setup/install/step/1');
					}
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/install/step2');
				
				// create a new js view
				$this->template->javascript = View::factory('components/js/install/step2_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = ___('setup.install.step2.instructions');
				
				// content
				$this->template->title.= ___('Nova Installed!');
				$this->template->layout->label = ___('All Finished');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('main/index').Form::button('next', ___('Finish'), $next).Form::close();
				
			break;
		}
		
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
	}
	
	private function _register()
	{
		require_once Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');
		
		$db = Database::instance();
		
		$request = array(
			Kohana::$config->load('nova.app_name'),
			Kohana::$config->load('nova.app_version_full'),
			Url::site(),
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['SERVER_ADDR'],
			PHP_VERSION,
			'install',
			Kohana::$config->load('nova.genre'),
		);
		
		$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, type, date, genre) VALUES (%s, %s, %s, %s, %s, %s, %s, %d, %s);";
		
		$data['message'] = sprintf(
			$insert,
			$db->escape($request[0]),
			$db->escape($request[1]),
			$db->escape($request[2]),
			$db->escape($request[3]),
			$db->escape($request[4]),
			$db->escape($request[5]),
			$db->escape($request[6]),
			$db->escape($request[7]),
			$db->escape(date::now())
		);
		
		//$email = Email::install_register($data);
		$email = false;
		
		return $email;
	}
}
