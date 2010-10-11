<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Upgrade Controller
 *
 * @package		Upgrade
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Upgrade extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			$this->request->redirect('install/setupconfig');
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step', 'index', 'verify', 'readme');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::config('info.app_db_tables');
			
			// we're upgrading from sms, so make sure the system isn't installed
			if ($this->request->action != 'step' AND (count($db->list_tables($db->table_prefix().'%')) == $tables))
			{
				$this->request->redirect('install/index');
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
		$this->template->layout->flash	= FALSE;
		$this->template->layout->controls		= FALSE;
	}
	
	public function action_index()
	{
		// nova must be installed in the same database where sms is
		if (count(Database::instance()->list_tables('sms_%')) == 0)
		{
			$this->template->layout->flash = View::factory('upgrade/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = __('Nova 2 must be installed in the same database as SMS.');
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
			'class' => 'btn-main',
			'id' => 'install',
		);
		
		// build the next step control
		$this->template->layout->controls = form::open('upgrade/index').form::button('install', __('Upgrade Center'), $next).form::close();
		
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
			$this->template->layout->flash = View::factory('upgrade/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = __('step.error_no_genre', array(':path' => APPFOLDER.'/config/nova'.EXT));
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
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::open('upgrade/step/1').form::button('next', __('Start Upgrade'), $next).form::close();
				}
			break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// update the character set
					$dbconfig = Kohana::config('database');
					$db->set_charset($dbconfig['default']['charset']);
					
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
				
				// do the quick installs
				Utility::install_ranks();
				Utility::install_skins();
				Utility::install_widgets();
				
				// get the number of tables
				$tables = $db->list_tables($db->table_prefix().'%');
				
				// create a new content view
				$this->template->layout->content = View::factory('upgrade/pages/upgrade_step1');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => Location::image('loading-circle-large.gif', NULL, 'upgrade', 'image'),
					'attr' => array(
						'class' => 'image'),
				);
				
				// content
				$this->template->title.= __('Upgrading to Nova');
				$this->template->layout->label = __('Upgrading to Nova');
				
				// create the javascript view
				$this->template->javascript = View::factory('upgrade/js/upgrade_step1_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::config('info.app_db_tables'))
					? FALSE 
					: form::button('next', __('Upgrade'), $next).form::close();
			break;
				
			case 2:
				// create a new content view
				$this->template->layout->content = View::factory('upgrade/pages/upgrade_step2');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// content
				$this->template->title.= __('Cleaning Up Data');
				$this->template->layout->label = __('Cleaning Up Data');
				
				// create the javascript view
				$this->template->javascript = View::factory('upgrade/js/upgrade_step2_js');
				
				// set the loading image
				$data->loading = array(
					'src' => Location::image('loading-circle-large.gif', NULL, 'upgrade', 'image'),
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('next', __('Run'), $next).form::close();
			break;
				
			case 3:
				if (isset($_POST['submit']))
				{
					// do the registration
					$this->_register();
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('upgrade/pages/upgrade_step3');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// an empty array for user info
				$data->options = array();
				
				// get all active users
				$all = Jelly::query('user')->where('status', '=', 'active')->select();
				
				foreach ($all as $a)
				{
					$data->options[$a->id] = $a->name.' ('.$a->email.')';
				}
				
				// content
				$this->template->title.= __('Passwords and Admin Rights');
				$this->template->layout->label = __('Passwords and Admin Rights');
				
				// create the javascript view
				$this->template->javascript = View::factory('upgrade/js/upgrade_step3_js');
				
				// set the loading image
				$data->loading = array(
					'src' => Location::image('loading-circle-large.gif', NULL, 'upgrade', 'image'),
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('next', __('Finalize'), $next).form::close();
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
		
		if ($data->verify === FALSE OR ! isset($data->verify['failure']))
		{
			// build the next step button
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install'
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('upgrade/step').form::button('install', __('Start Upgrade'), $next).form::close();
		}
		
		// content
		$this->template->title.= __('verify.title');
		$this->template->layout->label = __('verify.title');
	}
	
	private function _register()
	{
		if ($path = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required'))
		{
			// load the file
			Kohana::load($path);
			
			// get an instance of the database
			$db = Database::instance();
			
			// build the data we need
			$request = array(
				Kohana::config('info.app_name'),
				Kohana::config('info.app_version_full'),
				url::site(),
				$_SERVER['REMOTE_ADDR'],
				$_SERVER['SERVER_ADDR'],
				phpversion(),
				'upgrade',
				Kohana::config('nova.genre'),
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
			
			// send the email
			//$email = email::install_register($data);
		}
	}
}