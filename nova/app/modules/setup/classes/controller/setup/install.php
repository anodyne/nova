<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Install Controller
 *
 * @package		Setup
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
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
		I18n::lang('en-us');
		
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
		$this->template->layout->steps		= View::factory(Location::file('setup_install', null, 'partials'));
	}
	
	public function after()
	{
		parent::after();
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_changedb()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/install/changedb');
		
		// create a new js view
		$this->template->javascript = View::factory('components/js/install/changedb_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// build the images
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
				'attr' => array(
					'alt' => 'processing',
					'class' => '')),
		);
		
		// show the back button?
		$showbutton = false;
		
		switch ($this->request->param('id'))
		{
			case 'table':
				// set the content
				$title = 'Add a Database Table';
				$data->message = ___('setup.change.table');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'table',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::button('back', 'Create Table', $next);
			break;
				
			case 'field':
				// set the content
				$title = 'Add a Database Field';
				$data->message = ___('setup.change.field');
				
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
				$this->template->layout->controls = Form::button('back', 'Create Field', $next);
				
			break;
				
			case 'query':
				// set the content
				$title = 'Run a MySQL Query';
				$data->message = ___('setup.change.query');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'query',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::button('back', 'Run Query', $next);
				
			break;
			
			default:
				// set the content
				$title = 'Change Database';
				$data->message = ___('setup.change.default');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'back',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('setup/main/index').Form::button('back', 'Setup Center', $next).Form::close();
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
		
		// content
		$this->template->title.= $title;
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/database-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = $title;
	}
	
	public function action_genre()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/install/genre');
		
		// create a new js view
		$this->template->javascript = View::factory('components/js/install/genre_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// map the genres directory
		$map = Utility::directory_list(MODPATH.'app/modules/setup/assets/install/genres/');
		
		// get the genre info
		$info = (array) Kohana::$config->load('genreinfo');
		
		foreach ($map as $key => $m)
		{
			// drop the extension off
			$length = strlen('.php');
			$value = str_replace('.php', '', $m);
			
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
				'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
				'attr' => array(
					'alt' => 'processing',
					'class' => '')),
			'installed' => array(
				'src' => MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png',
				'attr' => array(
					'alt' => 'installed',
					'class' => '')),
			'notinstalled' => array(
				'src' => MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png',
				'attr' => array(
					'alt' => 'not installed',
					'class' => '')),
		);
		
		// content
		$this->template->title.= 'The Genre Panel';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/switch-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'The Genre Panel';
	}
	
	public function action_remove()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/install/remove');
		
		// create a new js view
		$this->template->javascript = View::factory('components/js/install/remove_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (HTTP_Request::POST == $this->request->method())
		{
			// grab an instance of the database
			$db = Database::instance();
			
			// get the database config
			$dbconf = Kohana::$config->load('database.default');
			
			// get an array of the tables
			$tables = $db->list_tables($db->table_prefix().'%');
			
			// uninstall the system
			if (is_array($tables) and count($tables) > 0)
			{
				foreach ($tables as $v)
				{
					DBForge::drop_table($v);
				}
				
				$new_tables = $db->list_tables($db->table_prefix().'%');
				
				if (is_array($new_tables) and count($new_tables) == 0)
				{
					// set the failure message
					$data->message = ___('setup.remove.success');
					
					$url = 'setup/main/index';
					$text = 'Setup Center';
				}
				else
				{
					// set the failure message
					$data->message = ___('setup.remove.failure');
					
					$url = 'setup/install/remove';
					$text = 'Try Again';
				}
				
				
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'install',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open($url).Form::button('install', $text, $next).Form::close();
			}
			else
			{
				// set the failure message
				$data->message = ___('setup.remove.no_tables');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'install',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('setup/main/index').Form::button('install', 'Setup Center', $next).Form::close();
			}
		}
		else
		{
			// set the instructions
			$data->message = ___('setup.remove.instructions');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit',
			);
			
			// build the next step control
			$this->template->layout->controls = Form::open('setup/install/remove').Form::button('submit', 'Uninstall', $next).Form::close();
		}
		
		// content
		$this->template->title.= 'Uninstall Nova 3';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/bin-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Uninstall Nova 3';
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
					// do the install
					Setup::install();
				}
				
				// get the number of tables
				$tables = $db->list_tables($db->table_prefix().'%');
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/install/step1');
				
				// create a new js view
				$this->template->javascript = View::factory('components/js/install/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// get the questions from the db
				$questions = Model_SecurityQuestion::get_questions();
				
				// set the questions variable
				$data->questions = array('' => 'Please Select One');
				
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
				$data->message = ( ! $data->errors)
					? (count($tables) < Kohana::$config->load('nova.app_db_tables')) ? ___('setup.install.step1.failure') : ___('setup.install.step1.success')
					: ___('setup.install.step1.errors');
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
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
						
						// do the registration
						Setup::register('install');
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
}
