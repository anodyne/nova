<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Upgrade Ajax controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_upgradeajax extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->dbforge();
		$this->load->dbutil();
	}
	
	public function upgrade_awards()
	{
		// start by getting a count of the number of items in the awards table
		$count = $this->db->query("SELECT awardid FROM sms_awards");
		$count_old = $count->num_rows();
		
		// drop the nova version of the table
		$this->dbforge->drop_table('awards');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."awards SELECT * FROM sms_awards");
			
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
			$this->dbforge->modify_column('awards', $fields);
			
			// add the award_display column
			$add = array(
				'award_display' => array(
					'type' => 'ENUM',
					'constraint' => "'y','n'",
					'default' => 'y')
			);
			
			// do the add action
			$this->dbforge->add_column('awards', $add);
			
			// make award_id auto increment and the primary key
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."awards MODIFY COLUMN `award_id` INT(5) auto_increment primary key");
			
			// get the number of records in the new table
			$count_new = $this->db->count_all('awards');
			
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
					'message' => "Not all of the awards were transferred to the Nova format"
				);
			}
			
			$this->dbutil->optimize_table('awards');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_characters()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		$this->load->model('access_model', 'access');
		
		try {
			// get the characters
			$query = $this->db->query("SELECT * FROM sms_crew");
			
			// the user array
			$userarray = array();
			
			// an array of character IDs
			$charIDs = array('' => 0);
			
			$langValues = array(
				'field_type' => 'text',
				'field_name' => 'languages',
				'field_fid' => 'languages',
				'field_rows' => 0,
				'field_value' => '',
				'field_section' => 1,
				'field_order' => 4,
				'field_label_page' => 'Languages'
			);
			$this->char->add_bio_field($langValues);
			
			// grab the ID of the new field
			$langID = $this->db->insert_id();
			
			// create an empty users array
			$users = array();
			
			foreach ($query->result() as $r)
			{
				if ( ! empty($r->email))
				{
					// build the array with user information
					$users[$r->email] = array(
						'name'				=> $r->realName,
						'email'				=> $r->email,
						'join_date'			=> false,
						'leave_date'		=> $r->leaveDate,
						'status'			=> ($r->crewType != 'active' and $r->crewType != 'pending') ? 'inactive' : $r->crewType,
						'password_reset'	=> 1,
						'access_role'		=> Access_Model::STANDARD,
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
					
					if ($users[$r->email]['join_date'] === false)
					{
						// if the join date isn't set yet, set it
						$users[$r->email]['join_date'] = $r->joinDate;
					}
				}
			}
			
			// create an empty array for checking users
			$saved = array();
			
			foreach ($users as $u)
			{
				// create the user
				$useraction = $this->user->create_user($u);
				
				// get the user ID
				$userID = $this->db->insert_id();
				
				// store whether or not the save worked
				$saved['users'][] = ($useraction > 0) ? true : false;
				
				// create the user prefs
				$this->user->create_user_prefs($userID);
				
				// keeping track of user ids
				$charIDs[$u['email']] = $userID;
			}
			
			// optimize the table
			$this->dbutil->optimize_table('users');
			
			// pause the script
			sleep(1);
			
			foreach ($query->result() as $c)
			{
				// make sure the fields array is empty
				$fields = false;
				
				$type = ($c->crewType != 'npc' and $c->crewType != 'active' and $c->crewType != 'inactive' and $c->crewType != 'pending')
					? 'inactive'
					: $c->crewType;
				
				$charValues = array(
					'charid' => $c->crewid,
					'user' => ( ! empty($c->email)) ? $charIDs[$c->email] : 0,
					'first_name' => $c->firstName,
					'middle_name' => $c->middleName,
					'last_name' => $c->lastName,
					'crew_type' => $type,
					'date_activate' => $c->joinDate,
					'date_deactivate' => $c->leaveDate,
					'rank' => $c->rankid,
					'position_1' => $c->positionid,
					'position_2' => $c->positionid2,
					'last_post' => $c->lastPost,
					'images' => $c->image,
				);
				$characteraction = $this->char->create_character($charValues);
				
				// store whether or not the save worked
				$saved['characters'][] = ($characteraction > 0) ? true : false;
				
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
					9 	=> $c->personalityOverview,
					10 	=> $c->strengths,
					11 	=> $c->ambitions,
					12 	=> $c->hobbies,
					13 	=> $c->spouse,
					14 	=> $c->children,
					15 	=> $c->father,
					16 	=> $c->mother,
					17 	=> $c->brothers,
					18	=> $c->sisters,
					19 	=> $c->otherFamily,
					20 	=> $c->history,
					21 	=> $c->serviceRecord,
					$langID => $c->languages,
				);
				
				foreach ($fields as $field => $value)
				{
					$fieldValues = array(
						'data_field' => $field,
						'data_char' => $c->crewid,
						'data_user' => ( ! empty($c->email)) ? $charIDs[$c->email] : 0,
						'data_value' => $value,
						'data_updated' => now()
					);
					$fieldata = $this->char->add_bio_field_data($fieldValues);
						
					// store whether or not the save worked
					$saved['formdata'][] = ($fieldata > 0) ? true : false;
				}
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
						'message' => "Your characters and character data were upgraded, but not all users were upgraded"
					);
				}
				
				if ($count_users === false and $count_characters === false and $count_formdata === true)
				{
					$retval = array(
						'code' => 2,
						'message' => "Your character data was upgraded, but not all users or characters were upgraded"
					);
				}
				
				if ($count_users === true and $count_characters === false and $count_formdata === true)
				{
					$retval = array(
						'code' => 2,
						'message' => "Your users and character data was upgraded, but not all characters were upgraded"
					);
				}
				
				if ($count_users === true and $count_characters === true and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => "Your users and characters were upgraded, but not all character data was upgraded"
					);
				}
				
				if ($count_users === false and $count_characters === true and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => "Your characters were upgraded, but not all users or character data were upgraded"
					);
				}
				
				if ($count_users === true and $count_characters === false and $count_formdata === false)
				{
					$retval = array(
						'code' => 2,
						'message' => "Your users were upgraded, but not all characters or character data were upgraded"
					);
				}
				
				if ($count_users === false and $count_characters === false and $count_formdata === false)
				{
					$retval = array(
						'code' => 0,
						'message' => "Your users, characters and character data could not be updated"
					);
				}
			}
			
			$this->dbutil->optimize_table('characters');
			$this->dbutil->optimize_table('users');
			$this->dbutil->optimize_table('characters_data');
			$this->dbutil->optimize_table('characters_fields');
			$this->dbutil->optimize_table('user_prefs_values');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_database()
	{
		// start by getting a count of the number of items in the database table
		$entries = $this->db->query("SELECT * FROM sms_database");
		$count_old = $entries->num_rows();
		
		try {
			$this->load->model('wiki_model', 'wiki');
			
			// set up the tracking arrays
			$pages = array();
			$drafts = array();
			
			foreach ($entries->result() as $e)
			{
				// create the wiki page
				$page = array(
					'page_created_at' => now(),
					'page_created_by_user' => 0,
					'page_created_by_character' => 0,
					'page_type' => 'standard'
				);
				$pages[] = (bool) $this->wiki->create_page($page);
				$pageid = $this->db->insert_id();
				
				// create the wiki draft
				$draft = array(
					'draft_title' => $e->dbTitle,
					'draft_author_user' => 0,
					'draft_author_character' => 0,
					'draft_summary' => $e->dbDesc,
					'draft_content' => ($e->dbType == 'entry') ? $e->dbContent : $e->dbURL,
					'draft_page' => $pageid,
					'draft_created_at' => now()
				);
				$drafts[] = (bool) $this->wiki->create_draft($draft);
				$draftid = $this->db->insert_id();
				
				// update the wiki page with the draft ID
				$this->wiki->update_page($pageid, array('page_draft' => $draftid));
			}
			
			if ( ! in_array(false, $pages) and ! in_array(false, $drafts))
			{
				$retval = array(
					'code' => 1,
					'message' => ""
				);
			}
			if ( ! in_array(false, $pages) and ! in_array(true, $drafts))
			{
				if ($count_old == count($pages))
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your database entries were created, but drafts could not be created for the wiki pages."
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Some, but not all, of your database entries were created, but drafts could not be created for the wiki pages."
					);
				}
			}
			if ( ! in_array(true, $pages) and ! in_array(false, $drafts))
			{
				if ($count_old == count($drafts))
				{
					$retval = array(
						'code' => 2,
						'message' => "Drafts were created for your content, but none of your database entries were converted to wiki pages."
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Drafts were created for your some, but not all, of your content, but none of your database entries were converted to wiki pages."
					);
				}
			}
			if ( ! in_array(true, $pages) and ! in_array(true, $drafts))
			{
				$retval = array(
					'code' => 0,
					'message' => ""
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_final_password()
	{
		// grab the password
		$password = $_POST['password'];
		
		$this->load->model('users_model', 'user');
		
		try {
			// hash the password
			$password = Auth::hash($password);
			
			// update everyone
			$this->user->update_all_users(array('password' => $password));
			
			// find out how many users don't have the right password
			$countQ = $this->db->from('users')->where('password !=', $password)->get();
			$count = $countQ->num_rows();
			
			if ($count > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Not all of your users' passwords were updated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_final_roles()
	{
		// grab the user IDs that should have the sys admin role
		$roles = $_POST['roles'];
		
		$this->load->model('users_model', 'user');
		$this->load->model('access_model', 'access');
		
		try {
			// temporary array
			$saved = array();
			
			foreach ($roles as $r)
			{
				$saved[] = $this->user->update_user($r, array(
					'access_role'		=> Access_Model::SYSADMIN,
					'is_sysadmin'		=> 'y',
					'is_game_master'	=> 'y',
				));
			}
			
			if ( ! in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => "None of your administrators were set"
				);
			}
			elseif (in_array(false, $saved) and in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => "Some of your administrators were set, but others were not"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_logs()
	{
		// get the number of logs in the sms table
		$count = $this->db->query("SELECT logid FROM sms_personallogs");
		$count_old = $count->num_rows();
		
		try {
			// drop the nova version of the table
			$this->dbforge->drop_table('personallogs');
			
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."personallogs SELECT * FROM sms_personallogs");
			
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
			$this->dbforge->modify_column('personallogs', $fields);
			
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
			$this->dbforge->add_column('personallogs', $add);
			
			// make sure the auto increment and primary key are right
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."personallogs MODIFY COLUMN `log_id` INT(5) auto_increment primary key");
			
			// get the new count of logs
			$count_new = $this->db->count_all('personallogs');
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "None of your personal logs were able to be upgraded"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "Some of your personal logs were upgraded, but some where unable to be upgraded"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('personallogs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_missions()
	{
		// get the number of missions in the sms table
		$count = $this->db->query("SELECT missionid FROM sms_missions");
		$count_missions_old = $count->num_rows();
		
		// get the number of mission posts in the sms table
		$count = $this->db->query("SELECT postid FROM sms_posts");
		$count_posts_old = $count->num_rows();
		
		try {
			// drop the nova version of the table
			$this->dbforge->drop_table('missions');
			
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."missions SELECT * FROM sms_missions");
			
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
			$this->dbforge->modify_column('missions', $fields);
			
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
			$this->dbforge->add_column('missions', $add);
			
			// make sure the auto increment and primary key are right
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."missions MODIFY COLUMN `mission_id` INT(8) auto_increment primary key");
			
			// drop the nova version of the table
			$this->dbforge->drop_table('posts');
			
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."posts SELECT * FROM sms_posts");
			
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
			$this->dbforge->modify_column('posts', $fields);
			
			// add the other fields
			$add = array(
				'post_authors_users' => array(
					'type' => 'TEXT'),
				'post_tags' => array(
					'type' => 'TEXT'),
				'post_last_update' => array(
					'type' => 'BIGINT',
					'constraint' => 20),
				'post_participants' => array(
					'type' => 'TEXT'),
				'post_lock_user' => array(
					'type' => 'INT',
					'constraint' => 8),
				'post_lock_date' => array(
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the modifications
			$this->dbforge->add_column('posts', $add);
			
			// remove the tag column
			$this->dbforge->drop_column('posts', 'postTag');
			
			// make sure the auto increment and primary key are correct
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."posts MODIFY COLUMN `post_id` INT(8) auto_increment primary key");
			
			// count the missions
			$count_missions_new = $this->db->count_all('missions');
			
			// count the posts
			$count_posts_new = $this->db->count_all('posts');
			
			if ($count_missions_new == 0 and $count_posts_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "None of your missions or mission posts were able to be upgraded"
				);
			}
			elseif ($count_missions_new > 0 and $count_posts_new == 0)
			{
				if ($count_missions_new != $count_missions_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_missions_new." of ".$count_missions_old." missions were upgraded, but your mission posts were not"
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Your missions were upgraded, but your mission posts were not"
					);
				}
			}
			elseif ($count_missions_new == 0 and $count_posts_new > 0)
			{
				if ($count_posts_new != $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_posts_new." of ".$count_posts_old." mission posts were upgraded, but your missions were not"
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Your mission posts were upgraded, but your missions were not"
					);
				}
			}
			else
			{
				if ($count_missions_new == $count_missions_old and $count_posts_new == $count_posts_old)
				{
					$retval = array(
						'code' => 1,
						'message' => ''
					);
				}
				elseif ($count_missions_new == $count_missions_old and $count_posts_new != $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your missions and ".$count_posts_new." of ".$count_posts_old." mission posts were upgraded"
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new == $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your mission posts and ".$count_missions_new." of ".$count_missions_old." missions were upgraded"
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new != $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_missions_new." of ".$count_missions_old." missions and ".$count_posts_new." of ".$count_posts_old." mission posts were upgraded"
					);
				}
			}
			
			$this->dbutil->optimize_table('missions');
			$this->dbutil->optimize_table('posts');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_news()
	{
		// get the number of news items in the sms table
		$count = $this->db->query("SELECT newsid FROM sms_news");
		$count_news_old = $count->num_rows();
		
		// get the number of news categories in the sms table
		$count = $this->db->query("SELECT catid FROM sms_news_categories");
		$count_cats_old = $count->num_rows();
		
		try {
			// drop the nova versions of the tables
			$this->dbforge->drop_table('news');
			$this->dbforge->drop_table('news_categories');
			
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."news_categories SELECT * FROM sms_news_categories");
			
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
			$this->dbforge->modify_column('news_categories', $fields);
			
			// remove the user level column
			$this->dbforge->drop_column('news_categories', 'catUserLevel');
			
			// make sure the auto increment and primary id are correct
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."news_categories MODIFY COLUMN `newscat_id` INT(5) auto_increment primary key");
			
			// copy the sms version of the table along with all its data
			$this->db->query("CREATE TABLE ".$this->db->dbprefix."news SELECT * FROM sms_news");
			
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
			$this->dbforge->modify_column('news', $fields);
			
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
			$this->dbforge->add_column('news', $add);
			
			// make sure the auto increment and primary key are right
			$this->db->query("ALTER TABLE ".$this->db->dbprefix."news MODIFY COLUMN `news_id` INT(8) auto_increment primary key");
			
			// count the news items
			$count_news_new = $this->db->count_all('news');
			
			// count the news categories
			$count_cats_new = $this->db->count_all('news_categories');
			
			if ($count_news_new == 0 and $count_cats_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "None of your news categories or news item were able to be upgraded"
				);
			}
			elseif ($count_news_new > 0 and $count_cats_new == 0)
			{
				if ($count_news_new != $count_news_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_news_new." of ".$count_news_old." news items were upgraded, but your news categories were not"
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Your news items were upgraded, but your news categories were not"
					);
				}
			}
			elseif ($count_news_new == 0 and $count_cats_new > 0)
			{
				if ($count_cats_new != $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_cats_new." of ".$count_cats_old." news categories were upgraded, but your news items were not"
					);
				}
				else
				{
					$retval = array(
						'code' => 2,
						'message' => "Your news categories were upgraded, but your news items were not"
					);
				}
			}
			else
			{
				if ($count_news_new == $count_news_old and $count_cats_new == $count_cats_old)
				{
					$retval = array(
						'code' => 1,
						'message' => ''
					);
				}
				elseif ($count_news_new == $count_news_old and $count_cats_new != $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your news items and ".$count_cats_new." of ".$count_cats_old." news categories were upgraded"
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new == $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your news categories and ".$count_news_new." of ".$count_news_old." news items were upgraded"
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new != $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => $count_news_new." of ".$count_news_old." news items and ".$count_cats_new." of ".$count_cats_old." news categories were upgraded"
					);
				}
			}
			
			$this->dbutil->optimize_table('news');
			$this->dbutil->optimize_table('news_categories');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_quick_install()
	{
		try {
			$this->load->helper('directory');
			
			// do the quick installs
			Util::install_rank();
			Util::install_skin();
			
			// get the directory listing for the genre
			$dir = directory_map(APPPATH.'assets/common/'.GENRE.'/ranks/', true);
			
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
			$dir = directory_map(APPPATH.'views/', true);
			
			// create an array of items to remove
			$pop = array('index.html', '_base_override');
			
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
			$db_ranks = $this->db->count_all('catalogue_ranks');
			
			// get the catalogue count for skins
			$db_skins = $this->db->count_all('catalogue_skins');

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
					'message' => "Your skins were installed but not all of your rank sets were installed. Please try to install your ranks sets manually from the rank catalogue page."
				);
			}
			elseif ($dir_ranks == $db_ranks and $dir_skins != $db_skins)
			{
				$retval = array(
					'code' => 2,
					'message' => "Your rank sets were installed but not all of your skins were installed. Please try to install your skins manually from the skin catalogue page."
				);
			}
			elseif ($dir_ranks != $db_ranks and $dir_skins != $db_skins)
			{
				$retval = array(
					'code' => 0,
					'message' => "Additional ranks and skins were not installed. Please try to do so manually from the catalogue pages."
				);
			}
			
			$this->dbutil->optimize_table('catalogue_ranks');
			$this->dbutil->optimize_table('catalogue_skins');
			$this->dbutil->optimize_table('catalogue_skinsecs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_settings()
	{
		$this->load->model('settings_model', 'settings');
		$this->load->model('messages_model', 'msgs');
		
		// figure out what the name of the table is
		$sql = ($this->db->table_exists('sms_settings'))
			? "SELECT * FROM sms_settings WHERE globalid = 1"
			: "SELECT * FROM sms_globals WHERE globalid = 1";
		
		$query = $this->db->query($sql);
		
		// create arrays for checking to see if everything was saved
		$settings = array();
		$messages = array();
		
		foreach ($query->result() as $r)
		{
			$value = array('setting_value' => $r->shipPrefix.' '.$r->shipName.' '.$r->shipRegistry);
			$settings[] = $this->settings->update_setting('sim_name', $value);
			
			$value = array('setting_value' => $r->simmYear);
			$settings[] = $this->settings->update_setting('sim_year', $value);
			
			$value = array('setting_value' => ($r->jpCount == 'y') ? 'multiple' : 'single');
			$settings[] = $this->settings->update_setting('post_count', $value);
			
			$value = array('setting_value' => $r->emailSubject);
			$settings[] = $this->settings->update_setting('email_subject', $value);
		}
		
		// get the messages
		$query = $this->db->query("SELECT * FROM sms_messages WHERE messageid = 1");
		
		foreach ($query->result() as $r)
		{
			$value = array('message_content' => $r->welcomeMessage);
			$messages[] = $this->msgs->update_message($value, 'welcome_msg');
			
			$value = array('message_content' => $r->simmMessage);
			$messages[] = $this->msgs->update_message($value, 'sim');
			
			$value = array('message_content' => $r->joinDisclaimer);
			$messages[] = $this->msgs->update_message($value, 'join_disclaimer');
			
			$value = array('message_content' => $r->acceptMessage);
			$messages[] = $this->msgs->update_message($value, 'accept_message');
			
			$value = array('message_content' => $r->rejectMessage);
			$messages[] = $this->msgs->update_message($value, 'reject_message');
			
			$value = array('message_content' => $r->samplePostQuestion);
			$messages[] = $this->msgs->update_message($value, 'join_post');
			
			$value = array('message_content' => $r->rules);
			$messages[] = $this->msgs->update_message($value, 'rules');
		}
		
		// optmize the tables
		$this->dbutil->optimize_table('settings');
		$this->dbutil->optimize_table('messages');
		
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
				$retval['message'] = "All of your settings were upgraded, but some of your messages couldn't be upgraded";
			}
			
			if ($settings_count === false and $messages_count === true)
			{
				$retval['code'] = 2;
				$retval['message'] = "All of your messages were upgraded, but some of your settings couldn't be upgraded";
			}
			
			if ($settings_count === false and $messages_count === false)
			{
				$retval['code'] = 0;
				$retval['message'] = "None of your settings or messages could be upgraded";
			}
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_specs()
	{
		$this->load->model('specs_model', 'specs');
		$this->load->model('settings_model', 'settings');
		
		try {
			// get the specs from the sms table
			$query = $this->db->query("SELECT * FROM sms_specs WHERE specid = 1");
			
			// create the spec item
			$specValues = array(
				'specs_name' => $this->settings->get_setting('sim_name'),
				'specs_order' => 0
			);
			$this->specs->add_spec_item($specValues);
			
			// create an empty array for validating the specs upgrade
			$specs = array();
			
			foreach ($query->result() as $r)
			{
				$specData = array(
					array(
						'data_field' => 1,
						'data_value' => $r->shipClass,
						'data_item' => 1),
					array(
						'data_field' => 2,
						'data_value' => $r->shipRole,
						'data_item' => 1),
					array(
						'data_field' => 3,
						'data_value' => $r->duration,
						'data_item' => 1),
					array(
						'data_field' => 4,
						'data_value' => $r->refit.' '.$r->refitUnit,
						'data_item' => 1),
					array(
						'data_field' => 5,
						'data_value' => $r->resupply.' '.$r->resupplyUnit,
						'data_item' => 1),
					array(
						'data_field' => 6,
						'data_value' => $r->length,
						'data_item' => 1),
					array(
						'data_field' => 7,
						'data_value' => $r->width,
						'data_item' => 1),
					array(
						'data_field' => 8,
						'data_value' => $r->height,
						'data_item' => 1),
					array(
						'data_field' => 9,
						'data_value' => $r->decks,
						'data_item' => 1),
					array(
						'data_field' => 10,
						'data_value' => $r->complimentOfficers,
						'data_item' => 1),
					array(
						'data_field' => 11,
						'data_value' => $r->complimentEnlisted,
						'data_item' => 1),
					array(
						'data_field' => 12,
						'data_value' => $r->complimentMarines,
						'data_item' => 1),
					array(
						'data_field' => 13,
						'data_value' => $r->complimentCivilians,
						'data_item' => 1),
					array(
						'data_field' => 14,
						'data_value' => $r->complimentEmergency,
						'data_item' => 1),
					array(
						'data_field' => 15,
						'data_value' => $r->warpCruise,
						'data_item' => 1),
					array(
						'data_field' => 16,
						'data_value' => $r->warpMaxCruise.' '.$r->warpMaxTime,
						'data_item' => 1),
					array(
						'data_field' => 17,
						'data_value' => $r->warpEmergency.' '.$r->warpEmergencyTime,
						'data_item' => 1),
					array(
						'data_field' => 18,
						'data_value' => $r->shields."\r\n\r\n".$r->defensive,
						'data_item' => 1),
					array(
						'data_field' => 19,
						'data_value' => $r->phasers."\r\n\r\n".$r->torpedoLaunchers,
						'data_item' => 1),
					array(
						'data_field' => 20,
						'data_value' => $r->torpedoCompliment,
						'data_item' => 1),
					array(
						'data_field' => 21,
						'data_value' => $r->shuttlebays,
						'data_item' => 1),
					array(
						'data_field' => 22,
						'data_value' => $r->shuttles,
						'data_item' => 1),
					array(
						'data_field' => 23,
						'data_value' => $r->fighters,
						'data_item' => 1),
					array(
						'data_field' => 24,
						'data_value' => $r->runabouts,
						'data_item' => 1),
				);
				
				foreach ($specData as $key => $value)
				{
					$specs[] = (bool) $this->specs->add_spec_field_data($value);
				}
			}
			
			if (in_array(false, $specs) and ! in_array(true, $specs))
			{
				$retval = array(
					'code' => 0,
					'message' => "Your specifications were not upgraded"
				);
			}
			elseif (in_array(false, $specs) and in_array(true, $specs))
			{
				$retval = array(
					'code' => 2,
					'message' => "Some of your specifications were upgraded, but others were not"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('specs');
			$this->dbutil->optimize_table('specs_data');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_tour()
	{
		$this->load->model('tour_model', 'tour');
		
		try {
			// get the tour items
			$query = $this->db->query("SELECT * FROM sms_tour");
			
			// create an array for validating
			$tour = array();
			
			foreach ($query->result() as $r)
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
				
				$tourValues = array(
					'tour_name' => $r->tourName,
					'tour_order' => $r->tourOrder,
					'tour_display' => $r->tourDisplay,
					'tour_summary' => $r->tourSummary,
					'tour_images' => $images,
					'tour_spec_item' => 1
				);
				$tour[] = (bool) $this->tour->add_tour_item($tourValues);
				
				// get the insert ID
				$tourid = $this->db->insert_id();
				
				$tourData = array(
					array(
						'data_field' => 1,
						'data_value' => $r->tourLocation,
						'data_tour_item' => $tourid),
					array(
						'data_field' => 2,
						'data_value' => $r->tourDesc,
						'data_tour_item' => $tourid),
				);
				
				$tour[] = (bool) $this->tour->add_tour_field_data($tourData[0]);
				$tour[] = (bool) $this->tour->add_tour_field_data($tourData[1]);
			}
			
			if (in_array(false, $tour) and ! in_array(true, $tour))
			{
				$retval = array(
					'code' => 0,
					'message' => "Your tour items were not upgraded"
				);
			}
			elseif (in_array(false, $tour) and in_array(true, $tour))
			{
				$retval = array(
					'code' => 2,
					'message' => "Some of your tour items were upgraded, but others were not"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('tour');
			$this->dbutil->optimize_table('tour_data');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_user_awards()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('awards_model', 'award');
		
		try {
			// get the crew from the sms table
			$query = $this->db->query('SELECT * FROM sms_crew');
			
			// create an array for saved entries
			$saved = array();
			
			foreach ($query->result() as $c)
			{
				$user = $this->char->get_character($c->crewid, 'user');
				
				if ( ! empty($c->awards))
				{
					$awards = explode(';', $c->awards);
					
					foreach ($awards as $a)
					{
						if (strstr($a, '|') !== false)
						{
							$x = explode('|', $a);
							
							$awardaction = array(
								'awardrec_character' => $c->crewid,
								'awardrec_user' => $user,
								'awardrec_award' => $x[0],
								'awardrec_date' => $x[1],
								'awardrec_reason' => $x[2]
							);
							$saved[] = $this->award->add_nominated_award($awardaction);
						}
						else
						{
							$awardaction = array(
								'awardrec_character' => $c->crewid,
								'awardrec_user' => $user,
								'awardrec_award' => $a,
								'awardrec_date' => 0
							);
							$saved[] = $this->award->add_nominated_award($awardaction);
						}
					}
				}
			}
			
			if ( ! in_array(true, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => "Your given awards could not be upgraded"
				);
			}
			elseif (in_array(true, $saved) and in_array(false, $saved))
			{
				$retval = array(
					'code' => 2,
					'message' => "All of your given awards could not be upgraded"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('awards_received');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_user_defaults()
	{
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('system_model', 'sys');
		$this->load->model('users_model', 'users');
		
		try {
			// get the total number of users
			$users = $this->db->count_all('users');
			
			// get the total number of characters
			$characters = $this->db->count_all('characters');
			
			if ($users > 0 and $characters > 0)
			{
				// pull the defaults for skins and ranks
				$defaults = array(
					'skin_main'			=> $this->sys->get_skinsec_default('main'),
					'skin_admin'		=> $this->sys->get_skinsec_default('admin'),
					'skin_wiki'			=> $this->sys->get_skinsec_default('wiki'),
					'display_rank'		=> $this->ranks->get_rank_default(),
					'my_links'			=> '',
					'language'			=> 'english',
					'daylight_savings'	=> 0,
				);
				
				// update all users
				$this->users->update_all_users($defaults);
				
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 0,
					'message' => "User defaults could not be upgraded"
				);
			}
			
			$this->dbutil->optimize_table('characters');
			$this->dbutil->optimize_table('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_user_logs()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('personallogs_model', 'logs');
		
		try {
			// get the crew from the sms table
			$query = $this->db->query('SELECT * FROM sms_crew');
			
			foreach ($query->result() as $c)
			{
				$user = $this->char->get_character($c->crewid, 'user');
				
				if ( ! is_null($user) and $user > 0)
				{
					$logs = $this->logs->update_log($c->crewid, array('log_author_user' => $user), 'log_author_character');
				}
			}
			
			// count the number of personal logs that don't have a user (there shouldn't be any)
			$blankCount = $this->db->from('personallogs')->where('log_author_user', '')->get();
			$blank = $blankCount->num_rows();
			
			if ($blank > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Some of your personal logs could not be upgraded and as a result, may not be associated with some users properly"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('personallogs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_user_news()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('news_model', 'news');
		
		try {
			// get the crew from the sms table
			$query = $this->db->query('SELECT * FROM sms_crew');
			
			foreach ($query->result() as $c)
			{
				$user = $this->char->get_character($c->crewid, 'user');
				
				if ( ! is_null($user) and $user > 0)
				{
					$news = $this->news->update_news_item($c->crewid, array('news_author_user' => $user), 'news_author_character');
				}
			}
			
			// count the number of news items without a user (there shouldn't be any)
			$blankCount = $this->db->from('news')->where('news_author_user', '')->get();
			$blank = $blankCount->num_rows();
			
			if ($blank > 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Some of your news items could not be upgraded and as a result, may not be associated with some users properly"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			
			$this->dbutil->optimize_table('news');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_user_posts()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('posts_model', 'posts');
		
		try {
			// get all the posts
			$posts = $this->posts->get_post_list('', 'desc', '', '');
			
			// set a temp array to collect saves
			$saved = array();
			
			foreach ($posts->result() as $p)
			{
				// grab the authors and put them into an array
				$authors = explode(',', $p->post_authors);
				
				// make sure we have an array
				$array = array();
				
				foreach ($authors as $a)
				{
					if ($a > 0)
					{
						// get the user id
						$user = $this->char->get_character($a, 'user');
					
						if ( ! is_null($user) and ! in_array($user, $array))
						{
							$array[] = $user;
						}
					}
				}
				
				// create a string from the array
				$users = implode(',', $array);
				
				// update the post
				$saved[] = $this->posts->update_post($p->post_id, array('post_authors_users' => $users));
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
					'message' => "Not all of your mission posts could be upgraded"
				);
			}
			
			$this->dbutil->optimize_table('posts');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function upgrade_welcome()
	{
		$this->load->model('settings_model', 'settings');
		$this->load->model('messages_model', 'msgs');
		
		try {
			$header = 'Welcome to the '.$this->settings->get_setting('sim_name').'!';
			$msg = $this->msgs->update_message(array('message_content' => $header), 'welcome_head');
			
			if ($msg > 0)
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
					'message' => "Your welcome message couldn't be upgraded, please do so manually"
				);
			}
			
			$this->dbutil->optimize_table('messages');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
}
