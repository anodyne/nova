<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Install Controller
 *
 * @package		Install Module
 * @subpackage	Controller
 * @author		Anodyne Productions
 * @version		2.0
 */

class Controller_Install extends Controller_Template
{
	// these models should be globally available
	public $mCore;
	public $mSettings;
	public $mMessages;
	
	public function before()
	{
		parent::before();
		
		// set the locale
		i18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory('_common/layouts/install');
		
		// set the variables in the template
		$this->template->title 					= 'Nova :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory('install/template_install');
		$this->template->layout->label			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->controls		= FALSE;
	}
	
	public function action_index()
	{
		// get an instance of the database
		$db = Database::Instance();
		
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// get the tables
		$tables = $db->list_tables();
		
		// figure out if the system is installed or not
		$data->installed = (count($tables) < 1) ? FALSE : TRUE;
		
		// content
		$this->template->title.= __('index.title');
		$this->template->layout->label = __('index.label');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_main($error = 0)
	{
		/**
		 * 0 - no errors
		 * 1 - system is already installed
		 * 2 - you must be a sysadmin to update the genre
		 */
		
		// get an instance of the database
		$db = Database::Instance();
		
		// create a new content view
		$this->template->layout->content = new View('install/pages/install_main');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// get the tables
		$tables = $db->list_tables();
		
		// figure out if the system is installed or not
		$data->installed = (count($tables) < 1) ? FALSE : TRUE;
		
		if ((is_numeric($error) && $error > 0) || count($tables) < 1)
		{
			$this->template->layout->flash_message = new View('install/pages/flash');
			$this->template->layout->flash_message->status = ($error == 1) ? 'info' : 'error';
			$this->template->layout->flash_message->message = __('install.error.error_'.$error);
		}
		
		// content
		$this->template->title.= __('index.title');
		$this->template->layout->label = __('index.label');
		 
		// build the next step control
		$this->template->layout->controls = '<a href="'. url::site('install/verify') .'" class="btn">'. __('main.options_verify') .'</a>';
		
		// load the javascript
		$this->template->javascript = new View('install/js/verify_js');
	}
	
	public function action_readme()
	{
		// create a new content view
		$this->template->layout->content = new View('install/pages/install_readme');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('readme.title');
		$this->template->layout->label = __('readme.label');
	}
	
	public function action_test()
	{
		$table = Database_Table::factory('test');
		
		$id = Database_Column::factory('int');
		$id->is_primary = TRUE;
		$id->is_auto_increment = TRUE;
		$id->is_nullable = TRUE;
		$id->name = 'id';
		
		$test_id = Database_Column::factory('int');
		$test_id->is_nullable = TRUE;
		$test_id->name = 'test_id';
		
		$email = Database_Column::factory('varchar');
		$email->parameters = 45;
		$email->is_nullable = FALSE;
		$email->is_unique = TRUE;
		$email->name = 'email';
		$email->default = 'bob@mail.com';
		
		$table->add_column($id);
		$table->add_column($test_id);
		$table->add_column($email);
		
		//$ck = Database_Constraint::check('id', '>=', 0);
		//$pk = Database_Constraint::primary_key(array($id->name), $table->name);
		
		//$table->add_constraint($pk);
		//$table->add_constraint($ck);
		
		$table->create();
		
		echo Kohana::debug($table);
		exit();
	}
	
	public function action_setupconfig($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_setupconfig');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pass the step over to the view file
		$data->step = $step;
		
		if (!file_exists(MODPATH.'database/config/database'.EXT))
		{
			$data->message = __('setup.no_config_file');
		}
		else
		{
			// load the file into an array
			$file = file(MODPATH.'database/config/database'.EXT);
			
			if (file_exists(APPPATH.'config/database'.EXT))
			{
				$data->message = __('setup.config_exists');
			}
			else
			{
				if (version_compare('5.2.4', PHP_VERSION, '>='))
				{
					$data->message = __('setup.php_version', array(':php' => PHP_VERSION));
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data->message = __('setup.step0_text');
							break;
						
						# show the form with all the database connection values	
						case 1:
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'button',
								'id' => 'next',
							);
							$text = ucwords(__('order.next').' '.__('label.step'));

							// build the next step control
							$this->template->layout->controls = form::button('next', $text, $next).'</form>';
							break;
						
						# write the file and offer link to installation
						case 2:
							// set the variables to use
							$dbName		= trim(Security::xss_clean($_POST['dbName']));
							$dbUser		= trim(Security::xss_clean($_POST['dbUser']));
							$dbPass		= trim(Security::xss_clean($_POST['dbPass']));
							$dbHost		= trim(Security::xss_clean($_POST['dbHost']));
							$prefix		= trim(Security::xss_clean($_POST['prefix']));
							
							foreach ($file as $line_num => $line) {
								switch (substr($line,0,16)) {
									case "define('DB_NAME'":
										$file[$line_num] = str_replace("putyourdbnamehere", $dbName, $line);
										break;
									case "define('DB_USER'":
										$file[$line_num] = str_replace("'usernamehere'", "'$dbUser'", $line);
										break;
									case "define('DB_PASSW":
										$file[$line_num] = str_replace("'yourpasswordhere'", "'$dbPass'", $line);
										break;
									case "define('DB_HOST'":
										$file[$line_num] = str_replace("localhost", $dbHost, $line);
										break;
									case '$table_prefix  =':
										$file[$line_num] = str_replace('wp_', $prefix, $line);
										break;
								}
							}
							
							if (!is_writable($file))
							{
								$data->message = __("Sorry, but I can't write the database connection file. You can create the database.php file manually and paste the following text into it.");
								foreach ($file as $line)
								{
									$data->file_output = htmlentities($line);
								}
							}
							else
							{
								// open the file
								$handle = fopen(APPPATH.'config/database'.EXT, 'w');
								
								// write the file line by line
								foreach ($file as $line)
								{
									fwrite($handle, $line);
								}
								
								// close the file
								fclose($handle);
								
								// try to chmod the file to the proper permissions
								chmod(APPPATH.'config/database'.EXT, 0666);
								
								$data->message = __("All right sparky! You've made it through this part of the installation. Nova can now communicate with your database. If you are ready, you can start the install...");
							}
							
							break;
					}
				}
			}
		}
		
		// content
		$this->template->title.= __('setup.title');
		$this->template->layout->label = __('setup.title');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_step($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		if (!file_exists(MODPATH.'database/config/database.php'))
		{
			Request::Instance()->redirect('install/setupconfig');
		}
		
		// get an instance of the database
		$db = Database::Instance();
		
		// figure out if the system is installed
		$tables = $db->list_tables();
		
		# TODO: need to figure out the conditions under which they can't install
		
		switch ($step)
		{
			case 0:
				
				break;
				
			case 1:
				// update the character set
				$config = Kohana::config('database.default');
				$db->set_charset($config['character_set']);
				
				// pull in the field information
				include_once MODPATH.'install/assets/fields.php';
				
				foreach ($data as $key => $value)
				{
					$dbforge->add_field($$value['fields']);
					$dbforge->add_key($value['id'], TRUE);
					$dbforge->create_table($key, TRUE);
				}
				
				// get the number of tables
				$tables = $db->list_tables();
				
				// create a new content view
				$this->template->layout->content = new View('install/pages/install_step1');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = (count($tables) < 66) ? __('step1.failure') : __('step1.success');
				
				// content
				$this->template->title.= __('step1.title');
				$this->template->layout->label = __('step1.label');
				
				// create the javascript view
				$this->template->javascript = new View('install/js/install_step1_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => ucwords(__('order.next').' '.__('word.step')),
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < 66) ? FALSE : form::open('install/step/2').form::button($next).'</form>';
				
				break;
				
			case 2:
				// pull in the install data asset file
				include_once MODPATH.'install/assets/data_'.Kohana::config('install.data_src').'.php';
				
				// build a temporary array to check the results
				$insert = array();
				
				foreach ($data as $value)
				{
					foreach ($$value as $k => $v)
					{
						$query = $this->mCore->add($value, $v);
						
						if ($query == 0)
						{
							$insert[] = FALSE;
						}
					}
				}
				
				// create a new content view
				$this->template->layout->content = new View('install/pages/install_step2');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = (count($insert) > 0) ? __('step2.failure') : __('step2.success');
				
				// content
				$this->template->title.= __('step2.title');
				$this->template->layout->label = __('step2.label');
				
				// create the javascript view
				$this->template->javascript = new View('install/js/install_step2_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => ucwords(__('order.next').' '.__('word.step')),
					'id' => 'next',
				);
				
				if (Kohana::config('nova.genre') == '')
				{
					$this->template->layout->flash_message = new View('install/pages/flash');
					$this->template->layout->flash_message->status = 'error';
					$this->template->layout->flash_message->message = __('install.error.no_genre');
				}
				
				// build the next step control
				$this->template->layout->controls = (count($insert) > 0 || Kohana::config('nova.genre') == '') 
					? FALSE 
					: form::open('install/step/3').form::button($next).'</form>';
				
				break;
				
			case 3:
				// pull in the install genre data asset file
				include_once MODPATH.'install/assets/genres/'.Kohana::config('nova.genre').'_data.php';
				
				// build a temporary array to check the results
				$genre = array();
				
				foreach ($data as $key_d => $value_d)
				{
					foreach ($$value_d as $k => $v)
					{
						$query = $this->mCore->add($key_d, $v);
						
						if ($query == 0)
						{
							$genre[] = FALSE;
						}
					}
				}
				
				// create a new content view
				$this->template->layout->content = new View('install/pages/install_step3');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = (count($genre) > 0) ? __('step3.failure') : __('step3.success');
				
				// content
				$this->template->title.= __('step3.title');
				$this->template->layout->label = __('step3.label');
				
				// create the javascript view
				$this->template->javascript = new View('install/js/install_step3_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => ucwords(__('order.next').' '.__('word.step')),
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($genre) > 0) ? FALSE : form::button($next).'</form>';
				
				// build the inputs
				$data->inputs = array(
					'name' => array(
						'name' => 'real_name',
						'id' => 'real_name'),
					'dob' => array(
						'name' => 'dob',
						'id' => 'dob'),
					'email' => array(
						'name' => 'email',
						'id' => 'email'),
					'password' => array(
						'name' => 'password',
						'id' => 'password'),
					'security_answer' => array(
						'name' => 'security_answer',
						'id' => 'security_answer'),
					'first_name' => array(
						'name' => 'first_name',
						'id' => 'first_name'),
					'last_name' => array(
						'name' => 'last_name',
						'id' => 'last_name')
				);
				
				// get the rank information
				$args = array(
					'where' => array(
						array(
							'field' => 'rank_id',
							'value' => 1),
					),
				);
				$rank = $this->mCore->get('ranks_'.Kohana::config('nova.genre'), $args, 'rank_image');
				
				// get the rank extension
				$args = array(
					'where' => array(
						array(
							'field' => 'rankcat_location',
							'value' => 'default'),
						array(
							'field' => 'rankcat_genre',
							'value' => Kohana::config('nova.genre')),
					),
				);
				$ext = $this->mCore->get('catalogue_ranks', $args, 'rankcat_extension');
				
				// get the security questions
				$questions = $this->mCore->get_all('security_questions');
				
				// set up a place to put the questions
				$data->questions = FALSE;
				
				if ($questions)
				{
					$data->questions[0] = __('phrase.please_choose_one');
					
					foreach ($questions as $item)
					{
						$data->questions[$item->question_id] = $item->question_value;
					}
				}
				
				$data->images = array(
					'loading' => array(
						'src' => location::image('loading-circle-small.gif', NULL, 'install', 'image'),
						'alt' => '',
						'title' => '',
						'class' => 'image'),
					'default_rank' => array(
						'src' => location::image($rank.$ext, NULL, 'default', 'rank')),
				);
				
				break;
		}
	}
	
	public function action_verify()
	{
		// create a new content view
		$this->template->layout->content = new View('install/pages/install_verify');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// the verification table
		$data->table = Utility::verify_server();
		
		// content
		$this->template->title.= __('verify.title');
		$this->template->layout->label = __('verify.title');
	}
}

// End of file install.php
// Location: modules/install/controllers/install.php