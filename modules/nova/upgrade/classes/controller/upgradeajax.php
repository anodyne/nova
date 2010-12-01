<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Upgradeajax extends Controller_Template {
	
	public $db;
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory('_common/layouts/ajax');
		
		// set the variables in the template
		$this->template->content = false;
		
		// get an instance of the database
		$this->db = Database::instance();
	}
	
	public function action_upgrade_awards()
	{
		// start by getting a count of the number of items in the awards table
		$c = $this->db->query(Database::SELECT, "SELECT awardid FROM sms_awards", true);
		$count_old = $c->count();
		
		// drop the nova version of the table
		DBForge::drop_table('awards');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."awards SELECT * FROM sms_awards", true);
			
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
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards MODIFY COLUMN `award_id` INT(5) auto_increment primary key", true);
			
			// get the number of records in the new table
			$count_new = Jelly::query('award')->count();
			
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
			
			// optmize the tables
			DBForge::optimize('awards');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_characters()
	{
		// change the user model to prevent null values
		Jelly::meta('user')->field('join')->auto_now_create = false;
		
		try {
			// get the characters
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			// the user array
			$userarray = array();
			
			// an array of character IDs
			$charIDs = array('' => 0);
			
			// add the languages field
			$lang = Jelly::factory('formfield')
				->set(array(
					'type' => 'text',
					'html_name' => 'languages',
					'html_id' => 'languages',
					'html_rows' => 0,
					'value' => '',
					'section' => 1,
					'order' => 4,
					'form' => 'bio',
					'label' => 'Languages'
				))
				->save();
			
			// create an empty users array
			$users = array();
			
			foreach ($result as $r)
			{
				if ( ! empty($r->email))
				{
					// build the array with user information
					$users[$r->email] = array(
						'name'				=> $r->realName,
						'email'				=> $r->email,
						'join'				=> false,
						'leave'				=> $r->leaveDate,
						'status'			=> ($r->crewType != 'active' and $r->crewType != 'pending') ? 'inactive' : $r->crewType,
						'password_reset'	=> 1,
						'role'				=> 4,
					);
					
					if ( ! isset($users[$r->email]['main_char']))
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
					
					if ( ! isset($users['last_post']))
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
					
					if ($users[$r->email]['join'] === false)
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
				$prefs = Jelly::query('userpref')->select();
				
				// loop through and create the preferences for the user
				foreach ($prefs as $p)
				{
					$prefvalues = Jelly::factory('userprefvalue')
						->set(array(
							'user' => $useraction->id(),
							'key' => $p->key,
							'value' => $p->default
						))
						->save();
				}
				
				// keeping track of user ids
				$charIDs[$u['email']] = $useraction->id();
			}
			
			// pause the script
			sleep(1);
			
			foreach ($result as $c)
			{
				// make sure the fields array is empty
				$fields = false;
				
				// create the character
				$characteraction = Jelly::factory('character')
					->set(array(
						'id' => $c->crewid,
						'user' => ( ! empty($c->email)) ? $charIDs[$c->email] : null,
						'fname' => $c->firstName,
						'mname' => $c->middleName,
						'lname' => $c->lastName,
						'status' => ($c->crewType == 'npc') ? 'active' : $c->crewType,
						'activate' => $c->joinDate,
						'deactivate' => $c->leaveDate,
						'rank' => $c->rankid,
						'position1' => $c->positionid,
						'position2' => $c->positionid2,
						'last_post' => $c->lastPost
					))
					->save();
				
				// store whether or not the save worked
				$saved['characters'][] = $characteraction->saved();
				
				// explode the images string
				$images = explode(',', $c->image);
				
				foreach ($images as $i)
				{
					$item = Jelly::factory('characterimage')
						->set(array(
							'user' => ( ! empty($c->email)) ? $charIDs[$c->email] : null,
							'character' => $c->crewid,
							'image' => $i
						))
						->save();
				}
				
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
					$lang->id() => $c->languages,
				);
				
				foreach ($fields as $field => $value)
				{
					// insert the character data
					$fieldata = Jelly::factory('formdata')
						->set(array(
							'form' => 'bio',
							'character' => $characteraction->id(),
							'user' => ( ! empty($c->email)) ? $charIDs[$c->email] : null,
							'field' => $field,
							'value' => $value
						))
						->save();
						
					// store whether or not the save worked
					$saved['formdata'][] = $fieldata->saved();
				}
				
				// optimize the table
				DBForge::optimize('forms_data');
			}
			
			// set the count variables
			$count_users = (in_array(false, $saved['users'])) ? false : true;
			$count_characters = (in_array(false, $saved['characters'])) ? false : true;
			$count_formdata = (in_array(false, $saved['formdata'])) ? false : true;
			
			if ($count_users === true and $count_characters === true and $count_formdata === true)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				if ($count_users === false and $count_characters === true and $count_formdata === true)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your characters and character data were upgraded, but not all users were upgraded")
					);
				}
				
				if ($count_users === false and $count_characters === false and $count_formdata === true)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your character data was upgraded, but not all users or characters were upgraded")
					);
				}
				
				if ($count_users === true and $count_characters === false and $count_formdata === true)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users and character data was upgraded, but not all characters were upgraded")
					);
				}
				
				if ($count_users === true and $count_characters === true and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users and characters were upgraded, but not all character data was upgraded")
					);
				}
				
				if ($count_users === false and $count_characters === true and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your characters were upgraded, but not all users or character data were upgraded")
					);
				}
				
				if ($count_users === true and $count_characters === false and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => __("Your users were upgraded, but not all characters or character data were upgraded")
					);
				}
				
				if ($count_users === false and $count_characters === false and $count_formdata === false)
				{
					$retval = array(
						'code' => 0,
						'message' => __("Your users, characters and character data could not be updated")
					);
				}
			}
			
			// optmize the tables
			DBForge::optimize('characters');
			DBForge::optimize('users');
			DBForge::optimize('forms_data');
			DBForge::optimize('forms_fields');
			DBForge::optimize('user_prefs_values');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_final_password()
	{
		// grab the password
		$password = $_POST['password'];
		
		try {
			// hash the password
			$password = Auth::hash($password);
			
			// update everyone
			Jelly::query('user')->set(array('password' => $password))->update();
			
			// find out how many users don't have the right password
			$count = Jelly::query('user')->where('password', '!=', $password)->count();
			
			if ($count > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => __("Not all of your users' passwords were updated")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_final_roles()
	{
		// grab the user IDs that should have the sys admin role
		$roles = $_POST['roles'];
		
		try {
			// temporary array
			$saved = array();
			
			foreach ($roles as $r)
			{
				$user = Jelly::factory('user', $r)->set(array('role' => 1))->save();
				$saved[] = $user->saved();
			}
			
			if ( ! in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("None of your administrators were set")
				);
			}
			elseif (in_array(false, $saved) and in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Some of your administrators were set, but others were not")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_logs()
	{
		// get the number of logs in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT logid FROM sms_personallogs", true);
		$count_old = $c->count();
		
		try {
			// drop the nova version of the table
			DBForge::drop_table('personal_logs');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."personal_logs SELECT * FROM sms_personallogs", true);
			
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
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."personal_logs MODIFY COLUMN `log_id` INT(5) auto_increment primary key", true);
			
			// get the new count of logs
			$count_new = Jelly::query('personallog')->count();
			
			if ($count_new == 0)
			{
				// catch the exception
				$retval = array(
					'code' => 0,
					'message' => __("None of your personal logs were able to be upgraded")
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				// catch the exception
				$retval = array(
					'code' => 2,
					'message' => __("Some of your personal logs were upgraded, but some where unable to be upgraded")
				);
			}
			else
			{
				// catch the exception
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('personal_logs');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_missions()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT missionid FROM sms_missions", true);
		$count_missions_old = $c->count();
		
		// get the number of news categories in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT postid FROM sms_posts", true);
		$count_posts_old = $c->count();
		
		try {
			// drop the nova version of the table
			DBForge::drop_table('missions');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'missions SELECT * FROM sms_missions', true);
			
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
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'missions MODIFY COLUMN `mission_id` INT(8) auto_increment primary key', true);
			
			// drop the nova version of the table
			DBForge::drop_table('posts');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'posts SELECT * FROM sms_posts', true);
			
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
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'posts MODIFY COLUMN `post_id` INT(8) auto_increment primary key', true);
			
			// count the missions
			$count_missions_new = Jelly::query('mission')->count();
			
			// count the posts
			$count_posts_new = Jelly::query('post')->count();
			
			if ($count_missions_new == 0 and $count_posts_new == 0)
			{
				// catch the exception
				$retval = array(
					'code' => 0,
					'message' => __("None of your missions or mission posts were able to be upgraded")
				);
			}
			elseif ($count_missions_new > 0 and $count_posts_new == 0)
			{
				if ($count_missions_new != $count_missions_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new of :old missions were upgraded, but your mission posts were not", 
							array(':old' => $count_missions_old, ':new' => $count_missions_new)
						),
					);
				}
				else
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("Your missions were upgraded, but your mission posts were not")
					);
				}
			}
			elseif ($count_missions_new == 0 and $count_posts_new > 0)
			{
				if ($count_posts_new != $count_posts_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new of :old mission posts were upgraded, but your missions were not",
							array(':old' => $count_posts_old, ':new' => $count_posts_new)
						),
					);
				}
				else
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("Your mission posts were upgraded, but your missions were not")
					);
				}
			}
			else
			{
				if ($count_missions_new == $count_missions_old and $count_posts_new == $count_posts_old)
				{
					// catch the exception
					$retval = array(
						'code' => 1,
						'message' => ''
					);
				}
				elseif ($count_missions_new == $count_missions_old and $count_posts_new != $count_posts_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("All of your missions and :new of :old mission posts were upgraded",
							array(':old' => $count_posts_old, ':new' => $count_posts_new)
						),
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new == $count_posts_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("All of your mission posts and :new of :old missions were upgraded",
							array(':old' => $count_missions_old, ':new' => $count_missions_new)
						),
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new != $count_posts_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new_mis of :old_mis missions and :new_posts of :old_posts mission posts were upgraded", 
							array(':old_posts' => $count_posts_old, ':new_posts' => $count_posts_new, ':new_mis' => $count_missions_new, ':old_mis' => $count_missions_old)
						),
					);
				}
			}
			
			// optmize the tables
			DBForge::optimize('missions');
			DBForge::optimize('posts');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_news()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT newsid FROM sms_news", true);
		$count_news_old = $c->count();
		
		// get the number of news categories in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT catid FROM sms_news_categories", true);
		$count_cats_old = $c->count();
		
		try {
			// drop the nova versions of the tables
			DBForge::drop_table('news');
			DBForge::drop_table('news_categories');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."news_categories SELECT * FROM sms_news_categories", true);
			
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
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news_categories MODIFY COLUMN `newscat_id` INT(5) auto_increment primary key", true);
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."news SELECT * FROM sms_news", true);
			
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
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news MODIFY COLUMN `news_id` INT(8) auto_increment primary key", true);
			
			// count the news items
			$count_news_new = Jelly::query('news')->count();
			
			// count the news categories
			$count_cats_new = Jelly::query('newscategory')->count();
			
			if ($count_news_new == 0 and $count_cats_new == 0)
			{
				// catch the exception
				$retval = array(
					'code' => 0,
					'message' => __("None of your news categories or news item were able to be upgraded")
				);
			}
			elseif ($count_news_new > 0 and $count_cats_new == 0)
			{
				if ($count_news_new != $count_news_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new of :old news items were upgraded, but your news categories were not",
							array(':old' => $count_news_old, ':new' => $count_news_new)
						),
					);
				}
				else
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("Your news items were upgraded, but your news categories were not")
					);
				}
			}
			elseif ($count_news_new == 0 and $count_cats_new > 0)
			{
				if ($count_cats_new != $count_cats_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new of :old news categories were upgraded, but your news items were not",
							array(':old' => $count_cats_old, ':new' => $count_cats_new)
						),
					);
				}
				else
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("Your news categories were upgraded, but your news items were not")
					);
				}
			}
			else
			{
				if ($count_news_new == $count_news_old and $count_cats_new == $count_cats_old)
				{
					// catch the exception
					$retval = array(
						'code' => 1,
						'message' => ''
					);
				}
				elseif ($count_news_new == $count_news_old and $count_cats_new != $count_cats_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("All of your news items and :new of :old news categories were upgraded",
							array(':old' => $count_cats_old, ':new' => $count_cats_new)
						),
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new == $count_cats_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __("All of your news categories and :new of :old news items were upgraded",
							array(':old' => $count_news_old, ':new' => $count_news_new)
						),
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new != $count_cats_old)
				{
					// catch the exception
					$retval = array(
						'code' => 2,
						'message' => __(":new_news of :old_news news items and :new_cats of :old_cats news categories were upgraded", 
							array(':old_cats' => $count_cats_old, ':new_cats' => $count_cats_new, ':new_news' => $count_news_new, ':old_news' => $count_news_old)
						),
					);
				}
			}
			
			// optmize the tables
			DBForge::optimize('news');
			DBForge::optimize('news_categories');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_quick_install()
	{
		try {
			// do the quick installs
			Utility::install_ranks();
			Utility::install_skins();
			
			// get the directory listing for the genre
			$dir = Utility::directory_map(APPPATH.'assets/common/'.Kohana::config('nova.genre').'/ranks/', true);
			
			// set the items to be pulled out of the listing
			$pop = array('index.html');
			
			// remove unwanted items
			foreach ($pop as $value)
			{
				// find the item in the directory listing
				$key = array_search($value, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// get the count of ranks
			$dir_ranks = count($dir);
			
			// pause the script for 1 second
			sleep(1);
			
			// reset the variables
			$pop = null;
			$dir = null;
			
			// get the listing of the directory
			$dir = Utility::directory_map(APPPATH.'views/', true);
			
			// create an array of items to remove
			$pop = array('index.html');
			
			# TODO: remove this after the application directory has been cleaned out
			$pop[] = '_base';
			$pop[] = 'template.php';
			
			// remove the items
			foreach ($pop as $value)
			{
				// find the location in the directory listing
				$key = array_search($value, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// get the count of skins
			$dir_skins = count($dir);
			
			// get the catalogue count for ranks
			$db_ranks = Jelly::query('cataloguerank')->count();
			
			// get the catalogue count for skins
			$db_skins = Jelly::query('catalogueskin')->count();

			if ($dir_ranks == $db_ranks and $dir_skins == $db_skins)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			elseif ($dir_ranks != $db_ranks and $dir_skins == $db_skins)
			{
				$retval = array(
					'code' => 2,
					'message' => __("Your skins were installed but not all of your rank sets were installed. Please try to install your ranks sets manually from the rank catalogue page.")
				);
			}
			elseif ($dir_ranks == $db_ranks and $dir_skins != $db_skins)
			{
				$retval = array(
					'code' => 2,
					'message' => __("Your rank sets were installed but not all of your skins were installed. Please try to install your skins manually from the skin catalogue page.")
				);
			}
			elseif ($dir_ranks != $db_ranks and $dir_skins != $db_skins)
			{
				$retval = array(
					'code' => 0,
					'message' => __("Additional ranks and skins were not installed. Please try to do so manually from the catalogue pages.")
				);
			}
			
			// optmize the tables
			DBForge::optimize('catalogue_ranks');
			DBForge::optimize('catalogue_skins');
			DBForge::optimize('catalogue_skinsecs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_settings()
	{
		// figure out what the name of the settings table is
		if (count($this->db->list_tables('sms_settings')) > 0)
		{
			$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_settings WHERE globalid = 1", true);
		}
		else
		{
			$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_globals WHERE globalid = 1", true);
		}
		
		// create arrays for checking to see if everything was saved
		$settings = array();
		$messages = array();
		
		foreach ($result as $r)
		{
			// sim name
			$item = Jelly::query('setting', 'sim_name')->limit(1)->select();
			$item->value = $r->shipPrefix.' '.$r->shipName.' '.$r->shipRegistry;
			$item->save();
			$settings[] = $item->saved();
			
			// sim year
			$item = Jelly::query('setting', 'sim_year')->limit(1)->select();
			$item->value = $r->simmYear;
			$item->save();
			$settings[] = $item->saved();
			
			// posting requirement
			$item = Jelly::query('setting', 'post_count')->limit(1)->select();
			$item->value = ($r->jpCount == 'y') ? 'multiple' : 'single';
			$item->save();
			$settings[] = $item->saved();
			
			// email subject
			$item = Jelly::query('setting', 'email_subject')->limit(1)->select();
			$item->value = $r->emailSubject;
			$item->save();
			$settings[] = $item->saved();
		}
		
		// get the messages
		$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_messages WHERE messageid = 1", true);
		
		foreach ($result as $r)
		{
			// welcome message
			$item = Jelly::query('message', 'welcome_msg')->limit(1)->select();
			$item->value = $r->welcomeMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// sim message
			$item = Jelly::query('message', 'sim')->limit(1)->select();
			$item->value = $r->simmMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// join disclaimer
			$item = Jelly::query('message', 'join_disclaimer')->limit(1)->select();
			$item->value = $r->joinDisclaimer;
			$item->save();
			$messages[] = $item->saved();
			
			// acceptance message
			$item = Jelly::query('message', 'accept_message')->limit(1)->select();
			$item->value = $r->acceptMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// rejection message
			$item = Jelly::query('message', 'reject_message')->limit(1)->select();
			$item->value = $r->rejectMessage;
			$item->save();
			$messages[] = $item->saved();
			
			// join post
			$item = Jelly::query('message', 'join_post')->limit(1)->select();
			$item->value = $r->samplePostQuestion;
			$item->save();
			$messages[] = $item->saved();
		}
		
		// optmize the tables
		DBForge::optimize('settings');
		DBForge::optimize('messages');
		
		// check to see if everything worked
		$settings_count = (in_array(false, $settings)) ? false : true;
		$messages_count = (in_array(false, $messages)) ? false : true;
		
		if ($settings_count === true and $messages_count === true)
		{
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		}
		else
		{
			if ($settings_count === true and $messages_count === false)
			{
				$retval['code'] = 2;
				$retval['message'] = __("All of your settings were upgraded, but some of your messages couldn't be upgraded");
			}
			
			if ($settings_count === false and $messages_count === true)
			{
				$retval['code'] = 2;
				$retval['message'] = __("All of your messages were upgraded, but some of your settings couldn't be upgraded");
			}
			
			if ($settings_count === false and $messages_count === false)
			{
				$retval['code'] = 0;
				$retval['message'] = __("None of your settings or messages could be upgraded");
			}
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_specs()
	{
		try {
			// get the specs from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_specs WHERE specid = 1', true);
			
			// create the spec item
			Jelly::factory('spec')
				->set(array(
					'name' => Jelly::query('setting', 'sim_name')->limit(1)->select()->value,
					'order' => 0,
				))
				->save();
			
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
			
			if (in_array(false, $specs) and ! in_array(true, $specs))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Your specifications were not upgraded")
				);
			}
			elseif (in_array(false, $specs) and in_array(true, $specs))
			{
				$retval = array(
					'code' => 2,
					'message' => __("Some of your specifications were upgraded, but others were not")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('specs');
			DBForge::optimize('forms_data');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_tour()
	{
		try {
			// get the tour items
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_tour', true);
			
			// create an array for validating
			$tour = array();
			
			foreach ($result as $r)
			{
				$images = array();
				
				if ( ! empty($r->tourPicture1))
				{
					$images[] = $r->tourPicture1;
				}
				
				if ( ! empty($r->tourPicture2))
				{
					$images[] = $r->tourPicture2;
				}
				
				if ( ! empty($r->tourPicture3))
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
						'images' => $images,
						'specitem' => 1
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
			
			if (in_array(false, $tour) and ! in_array(true, $tour))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Your tour items were not upgraded")
				);
			}
			elseif (in_array(false, $tour) and in_array(true, $tour))
			{
				$retval = array(
					'code' => 2,
					'message' => __("Some of your tour items were upgraded, but others were not")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('tour');
			DBForge::optimize('forms_data');
		} catch (Exception $e) {
			// catch the exception
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_user_awards()
	{
		// change the awards received model to prevent null values
		Jelly::meta('awardrec')->field('date')->auto_now_create = false;
		
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			// create an array for saved entries
			$saved = array();
			
			foreach ($result as $c)
			{
				$user = Jelly::query('character', $c->crewid)->select()->user;
				
				if ( ! empty($c->awards))
				{
					$awards = explode(';', $c->awards);
					
					foreach ($awards as $a)
					{
						if (strstr($a, '|') !== false)
						{
							$x = explode('|', $a);
							
							$awardaction = Jelly::factory('awardrec')
								->set(array(
									'character' => $c->crewid,
									'user' => $user->id,
									'award' => $x[0],
									'date' => $x[1],
									'reason' => $x[2]
								))
								->save();
							$saved[] = $awardaction->saved();
						}
						else
						{
							$awardaction = Jelly::factory('awardrec')
								->set(array(
									'character' => $c->crewid,
									'user' => $user->id,
									'award' => $a,
									'date' => null
								))
								->save();
							$saved[] = $awardaction->saved();
						}
					}
				}
			}
			
			if ( ! in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Your given awards could not be upgraded")
				);
			}
			elseif (in_array(true, $saved) and in_array(false, $saved))
			{
				$retval = array(
					'code' => 2,
					'message' => __("All of your given awards could not be upgraded")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('awards_received');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_user_defaults()
	{
		try {
			// get the total number of users
			$users = Jelly::query('user')->count();
			
			// get the total number of characters
			$characters = Jelly::query('character')->count();
			
			if ($users > 0 and $characters > 0)
			{
				// pull the defaults for skins and ranks
				$defaults = array(
					'skin_main'		=> Jelly::query('catalogueskinsec')->defaultskin('main')->select()->skin,
					'skin_admin'	=> Jelly::query('catalogueskinsec')->defaultskin('admin')->select()->skin,
					'skin_wiki'		=> Jelly::query('catalogueskinsec')->defaultskin('wiki')->select()->skin,
					'rank'			=> Jelly::query('cataloguerank')->defaultrank()->select()->location,
					'links'			=> '',
				);
				
				// update all users
				Jelly::query('user')->set($defaults)->update();
				
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 0,
					'message' => __("User defaults could not be upgraded")
				);
			}
			
			// optmize the tables
			DBForge::optimize('characters');
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_user_logs()
	{
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			foreach ($result as $c)
			{
				$user = Jelly::query('character', $c->crewid)->select()->user;
				
				if ( ! is_null($user) and $user->id > 0)
				{
					// update the personal logs
					$logs = Jelly::query('personallog')
						->where('author_character', '=', $c->crewid)
						->set(array('author_user' => $user->id))
						->update();
				}
			}
			
			// count the number of personal logs that don't have a user (there shouldn't be any)
			$blank = Jelly::query('personallog')->where('author_user', '=', '')->count();
			
			if ($blank > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => __("Some of your personal logs could not be upgraded and as a result, may not be associated with some users properly")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('personal_logs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_user_news()
	{
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			foreach ($result as $c)
			{
				$user = Jelly::query('character', $c->crewid)->select()->user;
				
				if ( ! is_null($user) and $user->id > 0)
				{
					// update the news items
					$news = Jelly::query('news')
						->where('author_character', '=', $c->crewid)
						->set(array('author_user' => $user->id))
						->update();
				}
			}
			
			// count the number of news items without a user (there shouldn't be any)
			$blank = Jelly::query('news')->where('author_user', '=', '')->count();
			
			if ($blank > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => __("Some of your news items could not be upgraded and as a result, may not be associated with some users properly")
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			// optmize the tables
			DBForge::optimize('news');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_user_posts()
	{
		try {
			// get all the posts
			$posts = Jelly::query('post')->select();
			
			// set a temp array to collect saves
			$saved = array();
			
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
						$user = Jelly::query('character', $a)->select()->user;
					
						if ( ! is_null($user) and ! in_array($user->id, $array))
						{
							$array[] = $user->id;
						}
					}
				}
				
				// create a string from the array
				$users = implode(',', $array);
				
				// update the post
				$post = Jelly::factory('post', $p->id)
					->set(array('author_users' => $users))
					->save();
				$saved[] = $post->saved();
			}
			
			if ( ! in_array(false, $saved))
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
					'message' => __("Not all of your mission posts could be upgraded")
				);
			}
			
			// optmize the tables
			DBForge::optimize('posts');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_welcome()
	{
		try {
			// update the welcome page header
			$msg = Jelly::query('message', 'welcome_head')->limit(1)->select();
			$msg->value = 'Welcome to the '.Jelly::query('setting', 'sim_name')->limit(1)->select()->value.'!';
			$msg->save();
			
			if ($msg->saved())
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
					'message' => __("Your welcome message couldn't be upgraded, please do so manually")
				);
			}
			
			// optmize the tables
			DBForge::optimize('messages');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
}