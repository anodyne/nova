<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Upgradeajax extends Controller_Template
{
	public $db;
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory('_common/layouts/ajax');
		
		// set the variables in the template
		$this->template->content = FALSE;
		
		// get an instance of the database
		$this->db = Database::instance();
	}
	
	public function action_upgrade_awards()
	{
		// start by getting a count of the number of items in the awards table
		$c = $this->db->query(Database::SELECT, "SELECT awardid FROM sms_awards", TRUE);
		$count_old = $c->count();
		
		// load the dbforge
		$forge = new DBForge;
		
		// drop the nova version of the table
		DBForge::drop_table('awards');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query(NULL, "CREATE TABLE ".$this->db->table_prefix()."awards SELECT * FROM sms_awards", TRUE);
			
			// rename the fields
			$fields = array(
				'awardid' => array(
					'name' => 'award_id',
					'type' => 'INT',
					'constraint' => 5),
				'awardName' => array(
					'name' => 'award_name',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'awardImage' => array(
					'name' => 'award_image',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'awardOrder' => array(
					'name' => 'award_order',
					'type' => 'INT',
					'constraint' => 5),
				'awardDesc' => array(
					'name' => 'award_desc',
					'type' => 'TEXT'),
				'awardCat' => array(
					'name' => 'award_cat',
					'type' => 'ENUM',
					'constraint' => "'ic','ooc','both'",
					'default' => 'ic'),
			);
			
			// modify the columns
			DBForge::modify_column('awards', $fields);
			
			// add the award_display column
			$add = array(
				'award_display' => array(
					'type' => 'ENUM',
					'constraint' => "'y','n'",
					'default' => 'y')
			);
			
			// do the add action
			DBForge::add_column('awards', $add);
			
			// make award_id auto increment and the primary key
			$this->db->query(NULL, "ALTER TABLE ".$this->db->table_prefix()."awards MODIFY COLUMN `award_id` INT(5) auto_increment primary key", TRUE);
			
			// get the number of records in the new table
			$count_new = Jelly::select('award')->count();
	
			if ($count_new == $count_old)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 0,
					'message' => __("Not all of the awards were transferred to the Nova format")
				);
			}
		} catch (Exception $e) {
			// catch the exception and put the error message into the return array
			$retval = array(
				'code' => 0,
				'message' => $e->getMessage()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_characters()
	{
		try {
			// get the characters
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', TRUE);
			
			// the user array
			$userarray = array();
			
			// an array of character IDs
			$charIDs = array('' => 0);
			
			/*// add the languages field
			$lang = Jelly::insert('formfield')
				->set(array(
					'type' => 'text',
					'name' => 'languages',
					'section' => 1,
				));
			*/
			// create an empty users array
			$users = array();
			
			foreach ($result as $r)
			{
				if (!empty($r->email))
				{
					// build the array with user information
					$users[$r->email] = array(
						'name'				=> $r->realName,
						'email'				=> $r->email,
						'join'				=> FALSE,
						'leave'				=> $r->leaveDate,
						'status'			=> ($r->crewType != 'active' && $r->crewType != 'pending') ? 'inactive' : $r->crewType,
						'password_reset'	=> 1,
						'role'				=> 4,
					);
					
					if (!isset($users[$r->email]['main_char']))
					{
						// if we haven't set the main charcter yet, set it now
						$users[$r->email]['main_char'] = $r->crewid;
					}
					else
					{
						if ($r->crewType == 'active')
						{
							// if the main character has been set but the current character is active, use that
							$users[$r->email]['main_char'] = $c->crewid;
						}
					}
					
					if (!isset($users['last_post']))
					{
						// drop the latest post date in if it isn't set
						$users[$r->email]['last_post'] = $r->lastPost;
					}
					else
					{
						if ($r->crewType == 'active')
						{
							// if the latest post is set, but the current character is active, use that
							$users[$r->email]['last_post'] = $r->lastPost;
						}
					}
					
					if ($users[$r->email]['join'] === FALSE)
					{
						// if the join date isn't set yet, set it
						$users[$r->email]['join'] = $r->joinDate;
					}
				}
			}
			
			// create an empty array for checking users
			$saved = array();
			
			foreach ($users as $u)
			{
				// create the user
				$useraction = Jelly::factory('user')->set($u)->save();
				
				// store whether or not the save worked
				$saved['users'][] = $useraction->saved();
				
				// optimize the table
				DBForge::optimize('users');
				
				// get the preferences
				$prefs = Jelly::select('userpref')->execute();
				
				// loop through and create the preferences for the user
				foreach ($prefs as $p)
				{
					$prefvalues = Jelly::insert('userprefvalue')
						->set(array(
							'user' => $useraction->id(),
							'key' => $p->key,
							'value' => $p->default
						));
				}
				
				// keeping track of user ids
				$charIDs[$u['email']] = $useraction->id();
			}
			
			// pause the script
			sleep(1);
			
			foreach ($result as $c)
			{
				// make sure the fields array is empty
				$fields = FALSE;
				
				// create the character
				$characteraction = Jelly::factory('character')
					->set(array(
						'id'			=> $c->crewid,
						'user'			=> (!empty($c->email)) ? $charIDs[$c->email] : NULL,
						'fname'			=> $c->firstName,
						'mname'			=> $c->middleName,
						'lname'			=> $c->lastName,
						'status'		=> ($c->crewType == 'npc') ? 'active' : $c->crewType,
						'images' 		=> $c->image,
						'activate' 		=> $c->joinDate,
						'deactivate' 	=> $c->leaveDate,
						'rank'			=> $c->rankid,
						'position1'		=> $c->positionid,
						'position2' 	=> $c->positionid2,
						'last_post' 	=> $c->lastPost
					))
					->save();
				
				// store whether or not the save worked
				$saved['characters'][] = $characteraction->saved();
				
				// optimize the table
				DBForge::optimize('characters');
				
				// create the array that stores all the character information
				$fields = array(
					1 	=> $c->gender,
					2 	=> $c->species,
					3 	=> $c->age,
					4 	=> $c->heightFeet."' ".$c->heightInches.'"',
					5 	=> $c->weight.' lbs',
					6 	=> $c->hairColor,
					7 	=> $c->eyeColor,
					8 	=> $c->physicalDesc,
					9 	=> $c->spouse,
					10 	=> $c->children,
					11 	=> $c->father,
					12 	=> $c->mother,
					13 	=> $c->brothers."\r\n\r\n".$c->sisters,
					14 	=> $c->otherFamily,
					15 	=> $c->personalityOverview,
					16 	=> $c->strengths,
					17 	=> $c->ambitions,
					18 	=> $c->hobbies,
					19 	=> $c->history,
					20 	=> $c->serviceRecord,
					//$lang->id() => $c->languages,
				);
				
				foreach ($fields as $field => $value)
				{
					// insert the character data
					$fieldata = Jelly::factory('formdata')
						->set(array(
							'form'		=> 'bio',
							'character' => $characteraction->id(),
							'user' 		=> (!empty($c->email)) ? $charIDs[$c->email] : NULL,
							'field' 	=> $field,
							'value' 	=> $value
						))
						->save();
						
					// store whether or not the save worked
					$saved['formdata'][] = $fieldata->saved();
				}
				
				// optimize the table
				DBForge::optimize('forms_data');
			}
			
			// set the count variables
			$count_users = (in_array(FALSE, $saved['users'])) ? FALSE : TRUE;
			$count_characters = (in_array(FALSE, $saved['characters'])) ? FALSE : TRUE;
			$count_formdata = (in_array(FALSE, $saved['formdata'])) ? FALSE : TRUE;
			
			if ($count_users === TRUE && $count_characters === TRUE && $count_formdata === TRUE)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				if ($count_users === FALSE && $count_characters === TRUE && $count_formdata === TRUE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your characters and character data were successfully upgraded, but not all users were successfully upgraded")
					);
				}
				
				if ($count_users === FALSE && $count_characters === FALSE && $count_formdata === TRUE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your character data was successfully upgraded, but not all users or characters were successfully upgraded")
					);
				}
				
				if ($count_users === TRUE && $count_characters === FALSE && $count_formdata === TRUE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users and character data was successfully upgraded, but not all characters were successfully upgraded")
					);
				}
				
				if ($count_users === TRUE && $count_characters === TRUE && $count_formdata === FALSE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users and characters were successfully upgraded, but not all character data was successfully upgraded")
					);
				}
				
				if ($count_users === FALSE && $count_characters === TRUE && $count_formdata === FALSE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your characters were successfully upgraded, but not all users or character data were successfully upgraded")
					);
				}
				
				if ($count_users === TRUE && $count_characters === FALSE && $count_formdata === FALSE)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users were successfully upgraded, but not all characters or character data were successfully upgraded")
					);
				}
				
				if ($count_users === FALSE && $count_characters === FALSE && $count_formdata === FALSE)
				{
					$retval = array(
						'code' => 0,
						'message' => __("Your users, characters and character data could not be updated")
					);
				}
			}
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'PHP ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_final_password()
	{
		// grab the password
		$password = $_POST['password'];
		
		// hash the password
		$password = Auth::hash($password);
		
		// update everyone
		Jelly::update('user')->set(array('password' => $password));
		
		echo '1';
	}
	
	public function action_upgrade_final_roles()
	{
		// grab the user IDs that should have the sys admin role
		$roles = $_POST['roles'];
		
		foreach ($roles as $r)
		{
			$user = Jelly::select('user', $r);
			$user->role = 1;
			$user->save();
		}
		
		echo '1';
	}
	
	public function action_upgrade_logs()
	{
		// load the forge
		$forge = new DBForge;
		
		// drop the nova version of the table
		DBForge::drop_table('personal_logs');
		
		// copy the sms version of the table along with all its data
		$this->db->query(NULL, "CREATE TABLE ".$this->db->table_prefix()."personal_logs SELECT * FROM sms_personallogs", TRUE);
		
		// rename the fields to appropriate names
		$fields = array(
			'logid' => array(
				'name' => 'log_id',
				'type' => 'INT',
				'constraint' => 5),
			'logAuthor' => array(
				'name' => 'log_author_character',
				'type' => 'INT',
				'constraint' => 8),
			'logPosted' => array(
				'name' => 'log_date',
				'type' => 'BIGINT',
				'constraint' => 20),
			'logTitle' => array(
				'name' => 'log_title',
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => 'upcoming'),
			'logContent' => array(
				'name' => 'log_content',
				'type' => 'TEXT'),
			'logStatus' => array(
				'name' => 'log_status',
				'type' => 'ENUM',
				'constraint' => "'activated','saved','pending'",
				'default' => 'activated'),
		);
		
		// do the modification
		DBForge::modify_column('personal_logs', $fields);
		
		// add the other columns
		$add = array(
			'log_author_user' => array(
				'type' => 'INT',
				'constraint' => 8),
			'log_tags' => array(
				'type' => 'TEXT'),
			'log_last_update' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		);
		
		// do the modification
		DBForge::add_column('personal_logs', $add);
		
		// make sure the auto increment and primary key are right
		$this->db->query(NULL, "ALTER TABLE ".$this->db->table_prefix()."personal_logs MODIFY COLUMN `log_id` INT(5) auto_increment primary key", TRUE);
		
		echo '1';
	}
	
	public function action_upgrade_missions()
	{
		// load the forge
		$forge = new DBForge;
		
		// drop the nova version of the table
		DBForge::drop_table('missions');
		
		// copy the sms version of the table along with all its data
		$this->db->query(NULL, 'CREATE TABLE '.$this->db->table_prefix().'missions SELECT * FROM sms_missions', TRUE);
		
		// rename the fields to appropriate names
		$fields = array(
			'missionid' => array(
				'name' => 'mission_id',
				'type' => 'INT',
				'constraint' => 8),
			'missionOrder' => array(
				'name' => 'mission_order',
				'type' => 'INT',
				'constraint' => 5),
			'missionTitle' => array(
				'name' => 'mission_title',
				'type' => 'VARCHAR',
				'constraint' => 255),
			'missionImage' => array(
				'name' => 'mission_images',
				'type' => 'TEXT'),
			'missionStatus' => array(
				'name' => 'mission_status',
				'type' => 'ENUM',
				'constraint' => "'upcoming','current','completed'",
				'default' => 'upcoming'),
			'missionStart' => array(
				'name' => 'mission_start',
				'type' => 'BIGINT',
				'constraint' => 20),
			'missionEnd' => array(
				'name' => 'mission_end',
				'type' => 'BIGINT',
				'constraint' => 20),
			'missionDesc' => array(
				'name' => 'mission_desc',
				'type' => 'TEXT'),
			'missionSummary' => array(
				'name' => 'mission_summary',
				'type' => 'TEXT'),
			'missionNotes' => array(
				'name' => 'mission_notes',
				'type' => 'TEXT'),
		);
		
		// do the modification
		DBForge::modify_column('missions', $fields);
		
		// add the other fields
		$add = array(
			'mission_notes_updated' => array(
				'type' => 'BIGINT',
				'constraint' => 20),
			'mission_group' => array(
				'type' => 'INT',
				'constraint' => 5)
		);
		
		// do the modifications
		DBForge::add_column('missions', $add);
		
		// make sure the auto increment and primary key are right
		$this->db->query(NULL, 'ALTER TABLE '.$this->db->table_prefix().'missions MODIFY COLUMN `mission_id` INT(8) auto_increment primary key', TRUE);
		
		// drop the nova version of the table
		DBForge::drop_table('posts');
		
		// copy the sms version of the table along with all its data
		$this->db->query(NULL, 'CREATE TABLE '.$this->db->table_prefix().'posts SELECT * FROM sms_posts', TRUE);
		
		// rename the fields to appropriate names
		$fields = array(
			'postid' => array(
				'name' => 'post_id',
				'type' => 'INT',
				'constraint' => 8),
			'postAuthor' => array(
				'name' => 'post_authors',
				'type' => 'TEXT'),
			'postPosted' => array(
				'name' => 'post_date',
				'type' => 'BIGINT',
				'constraint' => 20),
			'postTitle' => array(
				'name' => 'post_title',
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'postContent' => array(
				'name' => 'post_content',
				'type' => 'TEXT'),
			'postStatus' => array(
				'name' => 'post_status',
				'type' => 'ENUM',
				'constraint' => "'activated','saved','pending'",
				'default' => 'activated'),
			'postLocation' => array(
				'name' => 'post_location',
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'postTimeline' => array(
				'name' => 'post_timeline',
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => ''),
			'postMission' => array(
				'name' => 'post_mission',
				'type' => 'INT',
				'constraint' => 8),
			'postSave' => array(
				'name' => 'post_saved',
				'type' => 'INT',
				'constraint' => 11),
		);
		
		// do the modifications
		DBForge::modify_column('posts', $fields);
		
		// add the other fields
		$add = array(
			'post_authors_users' => array(
				'type' => 'TEXT'),
			'post_tags' => array(
				'type' => 'TEXT'),
			'post_last_update' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		);
		
		// do the modifications
		DBForge::add_column('posts', $add);
		
		// remove the tag column
		DBForge::drop_column('posts', 'postTag');
		
		// make sure the auto increment and primary key are correct
		$this->db->query(NULL, 'ALTER TABLE '.$this->db->table_prefix().'posts MODIFY COLUMN `post_id` INT(8) auto_increment primary key', TRUE);
		
		echo '1';
	}
	
	public function action_upgrade_news()
	{
		// load the dbforge
		$forge = new DBForge;
		
		// drop the nova versions of the tables
		DBForge::drop_table('news');
		DBForge::drop_table('news_categories');
		
		// copy the sms version of the table along with all its data
		$this->db->query(NULL, "CREATE TABLE ".$this->db->table_prefix()."news_categories SELECT * FROM sms_news_categories", TRUE);
		
		// rename the fields to appropriate names
		$fields = array(
			'catid' => array(
				'name' => 'newscat_id',
				'type' => 'INT',
				'constraint' => 5),
			'catName' => array(
				'name' => 'newscat_name',
				'type' => 'VARCHAR',
				'constraint' => 255),
			'catVisible' => array(
				'name' => 'newscat_display',
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'y'),
		);
		
		// do the modifications
		DBForge::modify_column('news_categories', $fields);
		
		// remove the user level column
		DBForge::drop_column('news_categories', 'catUserLevel');
		
		// make sure the auto increment and primary id are correct
		$this->db->query(NULL, "ALTER TABLE ".$this->db->table_prefix()."news_categories MODIFY COLUMN `newscat_id` INT(5) auto_increment primary key", TRUE);
		
		// copy the sms version of the table along with all its data
		$this->db->query(NULL, "CREATE TABLE ".$this->db->table_prefix()."news SELECT * FROM sms_news", TRUE);
		
		// rename the fields to appropriate names
		$fields = array(
			'newsid' => array(
				'name' => 'news_id',
				'type' => 'INT',
				'constraint' => 8),
			'newsCat' => array(
				'name' => 'news_cat',
				'type' => 'INT',
				'constraint' => 3),
			'newsAuthor' => array(
				'name' => 'news_author_character',
				'type' => 'INT',
				'constraint' => 8),
			'newsPosted' => array(
				'name' => 'news_date',
				'type' => 'BIGINT',
				'constraint' => 20),
			'newsTitle' => array(
				'name' => 'news_title',
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => 'upcoming'),
			'newsContent' => array(
				'name' => 'news_content',
				'type' => 'TEXT'),
			'newsStatus' => array(
				'name' => 'news_status',
				'type' => 'ENUM',
				'constraint' => "'activated','saved','pending'",
				'default' => 'activated'),
			'newsPrivate' => array(
				'name' => 'news_private',
				'type' => 'ENUM',
				'constraint' => "'y','n'",
				'default' => 'n'),
		);
		
		// do the modifications
		DBForge::modify_column('news', $fields);
		
		// add the missing columns
		$add = array(
			'news_author_user' => array(
				'type' => 'INT',
				'constraint' => 8),
			'news_tags' => array(
				'type' => 'TEXT'),
			'news_last_update' => array(
				'type' => 'BIGINT',
				'constraint' => 20)
		);
		
		// do the modifications
		DBForge::add_column('news', $add);
		
		// make sure the auto increment and primary key are right
		$this->db->query(NULL, "ALTER TABLE ".$this->db->table_prefix()."news MODIFY COLUMN `news_id` INT(8) auto_increment primary key", TRUE);
		
		echo '1';
	}
	
	public function action_upgrade_quick_install()
	{
		// do the quick installs
		Utility::install_ranks();
		Utility::install_skins();
		
		echo '1';
	}
	
	public function action_upgrade_settings()
	{
		// figure out what the name of the settings table is
		if (count($this->db->list_tables('sms_settings')) > 0)
		{
			$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_settings WHERE globalid = 1", TRUE);
		}
		else
		{
			$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_globals WHERE globalid = 1", TRUE);
		}
		
		// create arrays for checking to see if everything was saved
		$settings = array();
		$messages = array();
		
		foreach ($result as $r)
		{
			// sim name
			$item = Jelly::select('setting')->where('key', '=', 'sim_name')->load();
			$item->value = $r->shipPrefix.' '.$r->shipName.' '.$r->shipRegistry;
			$item->save();
			$settings[] = $item->saved();
			
			// sim year
			$item = Jelly::select('setting')->where('key', '=', 'sim_year')->load();
			$item->value = $r->simmYear;
			$item->save();
			$settings[] = $item->saved();
			
			// posting requirement
			$item = Jelly::select('setting')->where('key', '=', 'post_count_format')->load();
			$item->value = ($r->jpCount == 'y') ? 'multiple' : 'single';
			$item->save();
			$settings[] = $item->saved();
			
			// sim name
			$item = Jelly::select('setting')->where('key', '=', 'email_subject')->load();
			$item->value = $r->emailSubject;
			$item->save();
			$settings[] = $item->saved();
		}
		
		// get the messages
		$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_messages WHERE messageid = 1", TRUE);
		
		foreach ($result as $r)
		{
			// welcome message
			$item = Jelly::select('message')->where('key', '=', 'welcome_msg')->load();
			$item->value = $r->welcomeMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// sim message
			$item = Jelly::select('message')->where('key', '=', 'sim')->load();
			$item->value = $r->simmMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// join disclaimer
			$item = Jelly::select('message')->where('key', '=', 'join_disclaimer')->load();
			$item->value = $r->joinDisclaimer;
			$item->save();
			$messages[] = $item->saved();
			
			// acceptance message
			$item = Jelly::select('message')->where('key', '=', 'accept_message')->load();
			$item->value = $r->acceptMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// rejection message
			$item = Jelly::select('message')->where('key', '=', 'reject_message')->load();
			$item->value = $r->rejectMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// join post
			$item = Jelly::select('message')->where('key', '=', 'join_post')->load();
			$item->value = $r->samplePostQuestion;
			$item->save();
			$messages[] = $item->saved();
		}
		
		// check to see if everything worked
		$settings_count = (in_array(FALSE, $settings)) ? FALSE : TRUE;
		$messages_count = (in_array(FALSE, $messages)) ? FALSE : TRUE;
		
		if ($settings_count === TRUE && $messages_count === TRUE)
		{
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		}
		else
		{
			if ($settings_count === TRUE && $messages_count === FALSE)
			{
				$retval['code'] = 2;
				$retval['message'] = __("All of your settings were upgraded, but some of your messages couldn't be upgraded");
			}
			
			if ($settings_count === FALSE && $messages_count === TRUE)
			{
				$retval['code'] = 2;
				$retval['message'] = __("All of your messages were upgraded, but some of your settings couldn't be upgraded");
			}
			
			if ($settings_count === FALSE && $messages_count === FALSE)
			{
				$retval['code'] = 0;
				$retval['message'] = __("None of your settings or messages could be upgraded");
			}
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_specs()
	{
		// get the specs from the sms table
		$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_specs WHERE specid = 1', TRUE);
		
		// create an empty array for validating the specs upgrade
		$specs = array();
		
		foreach ($result as $r)
		{
			// ship class
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 23,
					'value' => $r->shipClass,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// ship role
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 24,
					'value' => $r->shipRole,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// duration
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 25,
					'value' => $r->duration,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// refit
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 26,
					'value' => $r->refit.' '.$r->refitUnit,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// resupply
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 27,
					'value' => $r->resupply.' '.$r->resupplyUnit,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// length
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 28,
					'value' => $r->length,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// width
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 29,
					'value' => $r->width,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// height
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 30,
					'value' => $r->height,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// decks
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 31,
					'value' => $r->decks,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// officers
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 32,
					'value' => $r->complimentOfficers,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// enlisted
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 33,
					'value' => $r->complimentEnlisted,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// marines
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 34,
					'value' => $r->complimentMarines,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// civilians
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 35,
					'value' => $r->complimentCivilians,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// emergency compliment
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 36,
					'value' => $r->complimentEmergency,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// warp cruise
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 37,
					'value' => $r->warpCruise,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// warp max cruise
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 38,
					'value' => $r->warpMaxCruise.' '.$r->warpMaxTime,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// warp emergency
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 39,
					'value' => $r->warpEmergency.' '.$r->warpEmergencyTime,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// defensive
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 40,
					'value' => $r->shields."\r\n\r\n".$r->defensive,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// weapons
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 41,
					'value' => $r->phasers."\r\n\r\n".$r->torpedoLaunchers,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// armament
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 42,
					'value' => $r->torpedoCompliment,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// number of shuttlebays
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 43,
					'value' => $r->shuttlebays,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// shuttles
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 44,
					'value' => $r->shuttles,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// number of fighters
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 45,
					'value' => $r->fighters,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
			
			// number of runabouts
			$item = Jelly::factory('formdata')
				->set(array(
					'field' => 46,
					'value' => $r->runabouts,
					'item' => 1,
					'form' => 'specs'
				))
				->save();
			$specs[] = $item->saved();
		}
		
		// check to see if everything worked
		$specs_count = (in_array(FALSE, $specs)) ? FALSE : TRUE;
		
		if ($specs_count === TRUE)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_upgrade_tour()
	{
		// get the tour items
		$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_tour', TRUE);
		
		// create an array for validating
		$tour = array();
		
		foreach ($result as $r)
		{
			$images = array();
			
			if (!empty($r->tourPicture1))
			{
				$images[] = $r->tourPicture1;
			}
			
			if (!empty($r->tourPicture2))
			{
				$images[] = $r->tourPicture2;
			}
			
			if (!empty($r->tourPicture3))
			{
				$images[] = $r->tourPicture3;
			}
			
			// make the images array a string
			$images = implode(',', $images);
			
			$item = Jelly::factory('tour')
				->set(array(
					'name' => $r->tourName,
					'order' => $r->tourOrder,
					'display' => $r->tourDisplay,
					'summary' => $r->tourSummary,
					'images' => $images
				))
				->save();
			$tour[] = $item->saved();
			
			$dataitem = Jelly::factory('formdata')
				->set(array(
					'field' => 47,
					'value' => $r->tourLocation,
					'item' => $item->id(),
					'form' => 'tour'
				))
				->save();
			$tour[] = $dataitem->saved();
			
			$dataitem = Jelly::factory('formdata')
				->set(array(
					'field' => 48,
					'value' => $r->tourDesc,
					'item' => $item->id(),
					'form' => 'tour'
				))
				->save();
			$tour[] = $dataitem->saved();
		}
		
		// validate the tour items
		$tour_count = (in_array(FALSE, $tour)) ? FALSE : TRUE;
		
		if ($tour_count === TRUE)
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_upgrade_user_awards()
	{
		// get the crew from the sms table
		$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', TRUE);
		
		foreach ($result as $c)
		{
			$user = Jelly::select('character', $c->crewid)->user;
			
			if (!empty($c->awards))
			{
				$awards = explode(';', $c->awards);
				
				foreach ($awards as $a)
				{
					if (strstr($a, '|') !== FALSE)
					{
						$x = explode('|', $a);
						
						Jelly::factory('awardrec')
							->set(array(
								'character' => $c->crewid,
								'award' => $x[0],
								'date' => $x[1],
								'reason' => $x[2]
							))
							->save();
					}
					else
					{
						Jelly::factory('awardrec')
							->set(array(
								'character' => $c->crewid,
								'award' => $a
							))
							->save();
					}
				}
			}
		}
		
		echo '1';
	}
	
	public function action_upgrade_user_defaults()
	{
		// get the total number of users
		$users = Jelly::select('user')->count();
		
		// get the total number of characters
		$characters = Jelly::select('character')->count();
		
		if ($users > 0 && $characters > 0)
		{
			// pull the defaults for skins and ranks
			$defaults = array(
				'skin_main'		=> Jelly::select('catalogueskinsec')->defaultskin('main')->load()->skin,
				'skin_admin'	=> Jelly::select('catalogueskinsec')->defaultskin('admin')->load()->skin,
				'skin_wiki'		=> Jelly::select('catalogueskinsec')->defaultskin('wiki')->load()->skin,
				'rank'			=> Jelly::select('cataloguerank')->defaultrank()->load()->location,
				'links'			=> '',
			);
			
			// update all users
			Jelly::update('user')->set($defaults)->execute();
			
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
	
	public function action_upgrade_user_logs()
	{
		// get the crew from the sms table
		$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', TRUE);
		
		foreach ($result as $c)
		{
			$user = Jelly::select('character', $c->crewid)->user;
			
			if (!is_null($user) && $user->id > 0)
			{
				// update the personal logs
				$logs = Jelly::update('personallog')->where('author_character', '=', $c->crewid)->set(array('author_user' => $user->id));
			}
		}
		
		echo '1';
	}
	
	public function action_upgrade_user_news()
	{
		// get the crew from the sms table
		$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', TRUE);
		
		foreach ($result as $c)
		{
			$user = Jelly::select('character', $c->crewid)->user;
			
			if (!is_null($user) && $user->id > 0)
			{
				// update the news items
				$news = Jelly::update('news')->where('author_character', '=', $c->crewid)->set(array('author_user' => $user->id));
			}
		}
		
		echo '1';
	}
	
	public function action_upgrade_user_posts()
	{
		// get all the posts
		$posts = Jelly::select('post')->execute();
		
		foreach ($posts as $p)
		{
			// grab the authors and put them into an array
			$authors = explode(',', $p->authors);
			
			// make sure we have an array
			$array = array();
			
			foreach ($authors as $a)
			{
				if ($a > 0)
				{
					// get the user id
					$user = Jelly::select('character', $a)->user;
				
					if (!is_null($user) && !in_array($user->id, $array))
					{
						$array[] = $user->id;
					}
				}
			}
			
			// create a string from the array
			$users = implode(',', $array);
			
			// update the post
			$post = Jelly::select('post', $p->id);
			$post->author_users = $users;
			$post->save();
		}
		
		echo '1';
	}
	
	public function action_upgrade_welcome()
	{
		// update the welcome page header
		$msg = Jelly::select('message')->where('key', '=', 'welcome_head')->load();
		$msg->value = 'Welcome to the '.Jelly::select('setting')->where('key', '=', 'sim_name')->load()->value.'!';
		$msg->save();
		
		if ($msg->saved())
		{
			echo '1';
		}
		else
		{
			echo '0';
		}
	}
}