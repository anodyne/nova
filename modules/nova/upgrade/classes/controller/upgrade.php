<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Upgrade Controller
 *
 * @package		Upgrade
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Upgrade extends Controller_Template
{
	/**
	 * @var	integer	the number of database tables in the system
	 */
	public $_tables = 56;
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if (!file_exists(APPPATH.'config/database'.EXT))
		{
			if ($this->request->action != 'setupconfig')
			{
				$this->request->redirect('install/setupconfig');
			}
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step', 'index', 'main', 'verify', 'readme');
			
			// make sure the system is installed
			if (count(Database::instance()->list_tables()) < $this->_tables && !(in_array($this->request->action, $safesegs)))
			{
				$this->request->redirect('install/index');
			}
			
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (count(Database::instance()->list_tables()) == $this->_tables)
			{
				// get an instance of the session
				$session = Session::instance();
				
				// make sure there's a session
				if ($session->get('userid'))
				{
					// are they a sysadmin?
					$sysadmin = Auth::is_type('sysadmin', $session->get('userid'));
					
					// if they aren't, send them away
					if ($sysadmin === FALSE)
					{
						//$this->request->redirect('login/index/error/1');
					}
				}
				else
				{
					// no session? send them away
					//$this->request->redirect('login/index/error/1');
				}
			}
		}
		
		// set the locale
		i18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory('_common/layouts/upgrade');
		
		// set the variables in the template
		$this->template->title 					= 'Nova :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory('upgrade/template_upgrade');
		$this->template->layout->label			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->controls		= FALSE;
		$this->template->layout->controls_text	= FALSE;
	}
	
	public function action_index()
	{
		// the upgrade process requires the genre to be DS9
		if (Kohana::config('nova.genre') != 'ds9')
		{
			$this->template->layout->flash_message = View::factory('upgrade/pages/flash');
			$this->template->layout->flash_message->status = 'error';
			$this->template->layout->flash_message->message = __('Upgrading to Nova 2 requires your genre to be DS9!');
		}
		
		// nova must be installed in the same database where sms is
		if (count(Database::instance()->list_tables('sms_%')) == 0)
		{
			$this->template->layout->flash_message = View::factory('upgrade/pages/flash');
			$this->template->layout->flash_message->status = 'error';
			$this->template->layout->flash_message->message = __('Nova 2 must be installed in the same database as SMS.');
		}
		
		// create a new content view
		$this->template->layout->content = View::factory('upgrade/pages/upgrade_index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		// content
		$this->template->title.= __('Upgrade Center');
		$this->template->layout->label = __('Upgrade Center');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_readme()
	{
		// create a new content view
		$this->template->layout->content = View::factory('upgrade/pages/upgrade_readme');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('Readme');
		$this->template->layout->label = __('Readme');
		
		// build the next step button
		$next = array(
			'type' => 'submit',
			'class' => 'button',
			'id' => 'install',
		);
		
		// build the next step control
		$this->template->layout->controls = form::open('upgrade/index').form::button('install', __('Upgrade Center'), $next).form::close();
		
		// build the control text
		$this->template->layout->controls_text = __('Go back to the Upgrade Center');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_step($step = 0)
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
		$allowed = TRUE;
		
		if (Kohana::config('nova.genre') == '')
		{
			// installation not allowed
			$allowed = FALSE;
			
			// show the flash message
			$this->template->layout->flash_message = View::factory('upgrade/pages/flash');
			$this->template->layout->flash_message->status = 'error';
			$this->template->layout->flash_message->message = __('step.error_no_genre', array(':path' => APPFOLDER.'/config/nova'.EXT));
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('upgrade/pages/upgrade_step0');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('step0.inst'));
				
				// content
				$this->template->title.= __('Upgrade to Nova');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory('upgrade/js/upgrade_step0_js');
				
				if ($allowed === TRUE)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'button',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::open('upgrade/step/1').form::button('next', __('step0.button'), $next).form::close();
					$this->template->layout->controls_text = __('step0.button_text');
				}
				break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// update the character set
					$dbconfig = Kohana::config('database');
					$db->set_charset($dbconfig['default']['charset']);
					
					// initialize the forge
					$forge = new DBForge;
					
					// pull in the field information
					include_once MODPATH.'nova/install/assets/fields'.EXT;
					
					foreach ($data as $key => $value)
					{
						DBForge::add_field($$value['fields']);
						DBForge::add_key($value['id'], TRUE);
						
						if (isset($value['index']))
						{
							foreach ($value['index'] as $index)
							{
								DBForge::add_key($index);
							}
						}
						
						DBForge::create_table($key, TRUE);
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from inserting the tables
					$data = NULL;
					
					// pull in the basic data
					include_once MODPATH.'nova/install/assets/data'.EXT;
					
					$insert = array();
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$sql = db::insert($value)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$insert[$value] = $db->query(Database::INSERT, $sql, TRUE);
						}
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from insert the data
					$data = NULL;
					
					// pull in the genre data
					include_once MODPATH.'nova/install/assets/genres/'.strtolower(Kohana::config('nova.genre')).EXT;
					
					$genre = array();
					
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$sql = db::insert($key_d)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$genre[$key_d] = $db->query(Database::INSERT, $sql, TRUE);
						}
					}
					
					if (Kohana::config('install.dev'))
					{
						// pause the script for a second
						sleep(1);
						
						// wipe out the data from insert the data
						$data = NULL;
						
						// pull in the development test data
						include_once MODPATH.'nova/install/assets/dev'.EXT;
						
						$insert = array();
						
						foreach ($data as $value)
						{
							foreach ($$value as $k => $v)
							{
								$sql = db::insert($value)
									->columns(array_keys($v))
									->values(array_values($v))
									->compile($db);
									
								$insert[$value] = $db->query(Database::INSERT, $sql, TRUE);
							}
						}
					}
				}
				
				// get the number of tables
				$tables = $db->list_tables();
				
				// create a new content view
				$this->template->layout->content = View::factory('upgrade/pages/upgrade_step1');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the validation errors
				$data->errors = ($session->get('errors')) ? $session->get('errors') : FALSE;
				
				// make sure the proper message is displayed
				$data->message = ($data->errors === FALSE)
					? (count($tables) < $this->_tables) ? __('step1.failure') : __('step1.success')
					: __('step1.errors');
				
				// set the loading image
				$data->loading = array(
					'src' => location::image('loading-circle-large.gif', NULL, 'upgrade', 'image'),
					'attr' => array(
						'class' => 'image'),
				);
				
				// get the default rank set
				$rankdefault = Jelly::select('setting')->where('key', '=', 'display_rank')->load()->value;
				
				// grab the rank catalogue
				$catalogue = Jelly::select('cataloguerank')->where('location', '=', $rankdefault)->load();
				
				// pull the rank record
				$rank = Jelly::select('rank', $session->get('rank', 1));
				
				$data->default_rank = array(
					'src' => location::image($rank->image.$catalogue->extension, NULL, $catalogue->location, 'rank'),
					'attr' => array(
						'class' => 'image'),
				);
				
				// content
				$this->template->title.= __('step1.title');
				$this->template->layout->label = __('step1.label');
				
				// create the javascript view
				$this->template->javascript = View::factory('upgrade/js/upgrade_step1_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'button',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < $this->_tables) ? FALSE : form::button('next', __('step1.button'), $next).form::close();
				$this->template->layout->controls_text = __('step1.button_text');
				
				break;
				
			case 2:
				if (isset($_POST['next']))
				{
					$validate = Validate::factory($_POST)
						->rule('email', 'not_empty')
						->rule('email', 'email')
						->rule('password', 'not_empty')
						->rule('password_confirm', 'not_empty')
						->rule('password_confirm', 'matches', array('password'));
						
					if ($validate->check())
					{
						// wipe out the session if everything is good
						$session->destroy();
						
						// get the data
						$simname = trim(security::xss_clean($_POST['sim_name']));
						$name = trim(security::xss_clean($_POST['name']));
						$email = trim(security::xss_clean($_POST['email']));
						$password = trim(security::xss_clean($_POST['password']));
						$first_name = trim(security::xss_clean($_POST['first_name']));
						$last_name = trim(security::xss_clean($_POST['last_name']));
						$position = trim(security::xss_clean($_POST['position']));
						$rank = trim(security::xss_clean($_POST['rank']));
						
						// update the settings
						$upSettings = Jelly::select('setting')->where('key', '=', 'sim_name')->load();
						$upSettings->value = $simname;
						$upSettings->save();
						
						$upSettings = Jelly::select('setting')->where('key', '=', 'email_subject')->load();
						$upSettings->value = '['.$simname.']';
						$upSettings->save();
						
						# TODO: need to change the skin and rank defaults
						
						// create the user
						$crUser = Jelly::factory('user')
							->set(array(
								'status'		=> 'active',
								'name'			=> $name,
								'email'			=> $email,
								'password'		=> Auth::hash($password),
								'role'			=> 1,
								'sysadmin'		=> 'y',
								'gm'			=> 'y',
								'webmaster'		=> 'y',
								'skin_main'		=> 'default',
								'skin_wiki'		=> 'default',
								'skin_admin'	=> 'default',
								'rank'			=> 'default',
							))
							->save();
						
						// create the character
						$crCharacter = Jelly::factory('character')
							->set(array(
								'user'			=> $crUser->id,
								'fname'			=> $first_name,
								'lname'			=> $last_name,
								'position1'		=> $position,
								'rank'			=> $rank,
								'type'			=> 'active',
								'activate'		=> date::now(),
							))
							->save();
						
						// update the user with the character info
						$crUser->main_char = $crCharacter->id;
						$crUser->save();
						
						// do the quick installs
						Utility::install_ranks();
						Utility::install_skins();
						
						// do the registration
						$this->_register();
					}
					else
					{
						// set the session variables
						$session->set('sim_name', security::xss_clean($_POST['sim_name']));
						$session->set('name', security::xss_clean($_POST['name']));
						$session->set('email', security::xss_clean($_POST['email']));
						$session->set('password', security::xss_clean($_POST['password']));
						$session->set('first_name', security::xss_clean($_POST['first_name']));
						$session->set('last_name', security::xss_clean($_POST['last_name']));
						$session->set('position', security::xss_clean($_POST['position']));
						$session->set('rank', security::xss_clean($_POST['rank']));
						$session->set('errors', $validate->errors('register'));
						
						// redirect back to step 1
						$this->request->redirect('install/step/1');
					}
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('install/pages/install_step2');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = __('step2.message');
				
				// content
				$this->template->title.= __('step2.title');
				$this->template->layout->label = __('step2.label');
				
				// create the javascript view
				$this->template->javascript = View::factory('install/js/install_step2_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'button',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('main/index').form::button('next', __('step2.button'), $next).form::close();
				$this->template->layout->controls_text = __('step2.button_text');
				
				break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_verify()
	{
		// create a new content view
		$this->template->layout->content = View::factory('upgrade/pages/upgrade_verify');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// create the javascript view
		$this->template->javascript = View::factory('upgrade/js/verify_js');
		
		// the verification table
		$data->verify = Utility::verify_server();
		
		if ($data->verify === FALSE || !isset($data->verify['failure']))
		{
			// build the next step button
			$next = array(
				'type' => 'submit',
				'class' => 'button',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('upgrade/step').form::button('install', __('Start Upgrade'), $next).form::close();
			
			// build the control text
			$this->template->layout->controls_text = __('Upgrade from SMS to Nova now');
		}
		
		// content
		$this->template->title.= __('verify.title');
		$this->template->layout->label = __('verify.title');
	}
}