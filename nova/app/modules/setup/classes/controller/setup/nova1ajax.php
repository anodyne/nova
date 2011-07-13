<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Nova 1 Upgrade Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Setup_Nova1ajax extends Controller_Template {
	
	public $db;
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory(Location::file('ajax', null, 'structure'));
		
		// set the variables in the template
		$this->template->content = false;
		
		// get an instance of the database
		$this->db = Database::instance();
	}
	
	/**
	 * Upgrade the awards.
	 */
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
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'awardName' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'awardImage' => array(
					'name' => 'image',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'awardOrder' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'awardDesc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
				'awardCat' => array(
					'name' => 'category',
					'type' => 'ENUM',
					'constraint' => "'ic','ooc','both'",
					'default' => 'ic'),
			);
			
			// modify the columns
			DBForge::modify_column('awards', $fields);
			
			// add the award_display column
			$add = array(
				'display' => array(
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1)
			);
			
			// do the add action
			DBForge::add_column('awards', $add);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get the number of records in the new table
			$count_new = Model_Award::count();
			
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
					'message' => "Not all of the awards were transferred to the Nova 3 format"
				);
			}
			
			DBForge::optimize('awards');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the characters and users.
	 */
	public function action_upgrade_characters()
	{
		// characters
		$retval['characters'] = $this->_upgrade_characters();
		
		// chain of command
		$retval['coc'] = $this->_upgrade_coc();
		
		// promotions
		$retval['promotions'] = $this->_upgrade_character_promotions();
		
		// dynamic form
		$retval['form'] = $this->_upgrade_character_form();
		
		// applications
		$retval['applications'] = $this->_upgrade_applications();
		
		// users
		$retval['users'] = $this->_upgrade_users();
		
		// user LOAs
		$retval['user_loas'] = $this->_upgrade_user_loa();
		
		echo json_encode($retval);
	}
	
	/**
	 * Take the password the admin chose and make sure every user has that password.
	 */
	public function action_upgrade_final_password()
	{
		// grab the password
		$password = $_POST['password'];
		
		try {
			// hash the password
			$new_password = Auth::hash($password);
			
			// update everyone
			Model_User::update_user(null, array('password' => $new_password));
			
			// find out how many users don't have the right password
			$count = Model_User::find()->where('password', '!=', $new_password)->count();
			
			// pull all the users
			$users = Model_User::find('all');
			
			// loop through and get all the email addresses
			foreach ($users as $u)
			{
				if ($u->get_status() == 'active')
				{
					$emails[] = $u->email;
				}
			}
			
			// get the settings
			$settings = Model_Settings::get_settings(array('sim_name', 'default_email_address', 'default_email_name'));
			
			# TODO: need to remove these comments for the final release
			
			/*
			// set up the content
			$content = "The ".$settings->sim_name." has just upgraded from SMS to Nova 3. As part of the upgrade process, your password needed to be reset. You'll log in to the ".$settings->sim_name." site with the password '".$password."' (without the single quotes). The first time you log in, you'll be prompted to change your password. Do not reply to this automatically generated email. If you have questions, please contact your game master.";
			
			// send an email out to the entire crew with the new password
			$email = Email::factory($content)
				->to($emails)
				->from($settings->default_email_address, $settings->default_email_name)
				->send();
			*/
			
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
			
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Set the users who the admin selected to have system administrator privileges.
	 */
	public function action_upgrade_final_roles()
	{
		// grab the user IDs that should have the sys admin role
		$roles = $_POST['roles'];
		
		try {
			// temporary array
			$saved = array();
			
			foreach ($roles as $r)
			{
				$user = Model_User::update_user($r, array('role_id' => 1));
				$saved[] = (is_object($user)) ? true : false;
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
			
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the personal logs from SMS to Nova.
	 */
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
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'logAuthor' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'logPosted' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'logTitle' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => 'upcoming'),
				'logContent' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'logStatus' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
			);
			
			// do the modification
			DBForge::modify_column('personal_logs', $fields);
			
			// add the other columns
			$add = array(
				'user_id' => array(
					'type' => 'INT',
					'constraint' => 8),
				'tags' => array(
					'type' => 'TEXT'),
				'updated_at' => array(
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the modification
			DBForge::add_column('personal_logs', $add);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."personal_logs MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get the new count of logs
			$count_new = Model_PersonalLog::count();
			
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
			
			DBForge::optimize('personal_logs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the missions and posts from the SMS format to Nova.
	 */
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
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'missionOrder' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'missionTitle' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'missionImage' => array(
					'name' => 'images',
					'type' => 'TEXT'),
				'missionStatus' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'upcoming','current','completed'",
					'default' => 'upcoming'),
				'missionStart' => array(
					'name' => 'start',
					'type' => 'BIGINT',
					'constraint' => 20),
				'missionEnd' => array(
					'name' => 'end',
					'type' => 'BIGINT',
					'constraint' => 20),
				'missionDesc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
				'missionSummary' => array(
					'name' => 'summary',
					'type' => 'TEXT'),
				'missionNotes' => array(
					'name' => 'notes',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('missions', $fields);
			
			// add the other fields
			$add = array(
				'notes_updated' => array(
					'type' => 'BIGINT',
					'constraint' => 20),
				'group_id' => array(
					'type' => 'INT',
					'constraint' => 5)
			);
			
			// do the modifications
			DBForge::add_column('missions', $add);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'missions MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
			// drop the nova version of the table
			DBForge::drop_table('posts');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'posts SELECT * FROM sms_posts', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'postid' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'postPosted' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'postTitle' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'postContent' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'postStatus' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
				'postLocation' => array(
					'name' => 'location',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'postTimeline' => array(
					'name' => 'timeline',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'postMission' => array(
					'name' => 'mission_id',
					'type' => 'INT',
					'constraint' => 8),
				'postSave' => array(
					'name' => 'saved_user_id',
					'type' => 'INT',
					'constraint' => 11),
				'postAuthor' => array(
					'name' => 'authors',
					'type' => 'TEXT'),
			);
			
			// do the modifications
			DBForge::modify_column('posts', $fields);
			
			// add the other fields
			$add = array(
				'tags' => array(
					'type' => 'TEXT'),
				'updated_at' => array(
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the modifications
			DBForge::add_column('posts', $add);
			
			// remove the tag column
			DBForge::drop_column('posts', 'postTag');
			
			// make sure the auto increment and primary key are correct
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'posts MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
			// count the missions
			$count_missions_new = Model_Mission::count();
			
			// count the posts
			$count_posts_new = Model_Post::count();
			
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
						'message' => "$count_missions_new of $count_missions_old missions were upgraded, but your mission posts were not", 
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
						'message' => "$count_posts_new of $count_posts_old mission posts were upgraded, but your missions were not",
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
						'message' => "All of your missions and $count_posts_new of $count_posts_old mission posts were upgraded",
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new == $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your mission posts and $count_missions_new of $count_missions_old missions were upgraded",
					);
				}
				elseif ($count_missions_new != $count_missions_old and $count_posts_new != $count_posts_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "$count_missions_new of $count_missions_old missions and $count_posts_new of $count_posts_old mission posts were upgraded",
					);
				}
			}
			
			DBForge::optimize('missions');
			DBForge::optimize('posts');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the news items and categories from SMS to Nova.
	 */
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
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'catName' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'catVisible' => array(
					'name' => 'display',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			
			// do the modifications
			DBForge::modify_column('news_categories', $fields);
			
			// remove the user level column
			DBForge::drop_column('news_categories', 'catUserLevel');
			
			// make sure the auto increment and primary id are correct
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news_categories MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."news SELECT * FROM sms_news", true);
			
			// rename the fields to appropriate names
			$fields = array(
				'newsid' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'newsCat' => array(
					'name' => 'category_id',
					'type' => 'INT',
					'constraint' => 3),
				'newsAuthor' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'newsPosted' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'newsTitle' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => 'upcoming'),
				'newsContent' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'newsStatus' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
				'newsPrivate' => array(
					'name' => 'private',
					'type' => 'ENUM',
					'constraint' => "'y','n'",
					'default' => 'n'),
			);
			
			// do the modifications
			DBForge::modify_column('news', $fields);
			
			// add the user_id column
			$add = array(
				'user_id' => array(
					'type' => 'INT',
					'constraint' => 8),
				'tags' => array(
					'type' => 'TEXT'),
				'updated_at' => array(
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the add action
			DBForge::add_column('news', $add);
			
			// get all the news items
			$private = Model_News::find('all');
			
			// loop through all the records and make sure the private column is correct
			foreach ($private as $p)
			{
				$p->private = ($p->private == 'y') ? (int) true : (int) false;
				$p->save();
			}
			
			// rename the fields to appropriate names
			$fields = array(
				'private' => array(
					'name' => 'private',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0),
			);
			
			// do the modifications
			DBForge::modify_column('news', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
			
			// count the news items
			$count_news_new = Model_News::count();
			
			// count the news categories
			$count_cats_new = Model_NewsCategory::count();
			
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
						'message' => "$count_news_new of $count_news_old news items were upgraded, but your news categories were not",
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
						'message' => "$count_cats_new of $count_cats_old news categories were upgraded, but your news items were not",
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
						'message' => "All of your news items and $count_cats_new of $count_cats_old news categories were upgraded",
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new == $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All of your news categories and $count_news_new of $count_news_old news items were upgraded",
					);
				}
				elseif ($count_news_new != $count_news_old and $count_cats_new != $count_cats_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "$count_news_new of $count_news_old news items and $count_cats_new of $count_cats_old news categories were upgraded", 
					);
				}
			}
			
			DBForge::optimize('news');
			DBForge::optimize('news_categories');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Do the quick install for ranks and skins.
	 */
	public function action_upgrade_quick_install()
	{
		try {
			// do the quick installs
			Utility::install_rank();
			Utility::install_skin();
			
			// get the directory listing for the genre
			$dir = Utility::directory_map(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/', true);
			
			// get the count of ranks
			$dir_ranks = count($dir);
			
			// pause the script for 1 second
			sleep(1);
			
			// reset the variables
			$pop = null;
			$dir = null;
			
			// get the listing of the directory
			$dir = Utility::directory_map(APPPATH.'views/', true);
			
			# TODO: remove this after the application directory has been cleaned out
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
			$db_ranks = count(Model_CatalogueRank::get_all_items());
			
			// get the catalogue count for skins
			$db_skins = count(Model_CatalogueSkin::get_all_items());

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
	
	/**
	 * Upgrade the settings and site content (messages) from SMS to Nova.
	 */
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
		
		foreach ($result as $r)
		{
			$settings = array(
				'sim_name' => $r->shipPrefix.' '.$r->shipName.' '.$r->shipRegistry,
				'sim_year' => $r->simmYear,
				'post_count_format' => ($r->jpCount == 'y') ? 'multiple' : 'single',
				'email_subject' => $r->emailSubject
			);
		}
		
		// save the settings
		Model_Settings::update_settings($settings);
		
		// get the messages
		$result = $this->db->query(Database::SELECT, "SELECT * FROM sms_messages WHERE messageid = 1", true);
		
		foreach ($result as $r)
		{
			$messages = array(
				'welcome_msg' => $r->welcomeMessage,
				'sim' => $r->simmMessage,
				'join_disclaimer' => $r->joinDisclaimer,
				'accept_message' => $r->acceptMessage,
				'reject_message' => $r->rejectMessage,
				'join_post' => $r->samplePostQuestion,
			);
		}
		
		// save the messages
		Model_SiteContent::update_messages($messages);
		
		// optmize the tables
		DBForge::optimize('settings');
		DBForge::optimize('site_content');
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the specs from SMS to Nova.
	 */
	public function action_upgrade_specs()
	{
		try {
			// get the specs from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_specs WHERE specid = 1', true);
			
			// set the data for the new spec item
			$specitem = array(
				'name' => Model_Settings::get_settings('sim_name'),
				'order' => 0
			);
			
			// create the spec item
			$item = Model_Spec::create_spec($specitem);
			
			// loop through the results and build the array for updating the data
			foreach ($result as $r)
			{
				$specsdata = array(
					24 => $r->shipClass,
					25 => $r->shipRole,
					26 => $r->duration,
					27 => $r->refit.' '.$r->refitUnit,
					28 => $r->resupply.' '.$r->resupplyUnit,
					29 => $r->length,
					30 => $r->width,
					31 => $r->height,
					32 => $r->decks,
					33 => $r->complimentOfficers,
					34 => $r->complimentEnlisted,
					35 => $r->complimentMarines,
					36 => $r->complimentCivilians,
					37 => $r->complimentEmergency,
					38 => $r->warpCruise,
					39 => $r->warpMaxCruise.' '.$r->warpMaxTime,
					40 => $r->warpEmergency.' '.$r->warpEmergencyTime,
					41 => $r->shields."\r\n\r\n".$r->defensive,
					42 => $r->phasers."\r\n\r\n".$r->torpedoLaunchers,
					43 => $r->torpedoCompliment,
					44 => $r->shuttlebays,
					45 => $r->shuttles,
					46 => $r->fighters,
					47 => $r->runabouts,
				);
			}
			
			// update the dynamic data
			Model_FormData::update_data('specs', $item->id, $specsdata);
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
			
			DBForge::optimize('specs');
			DBForge::optimize('form_data');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the tour items from SMS to Nova.
	 */
	public function action_upgrade_tour()
	{
		try {
			// get the tour items
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_tour', true);
			
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
				
				// an array of data with the info for creating a tour item
				$tour = array(
					'name' => $r->tourName,
					'order' => $r->tourOrder,
					'display' => ($r->tourDisplay == 'y') ? (int) true : (int) false,
					'summary' => $r->tourSummary,
					'images' => $images,
					'spec_id' => 1,
				);
				
				// create the tour item
				$item = Model_Tour::create_tour_item($tour);
				
				// an array of data with the info for updating tour data
				$tourdata = array(
					48 => $r->tourLocation,
					49 => $r->tourDesc,
				);
				
				// update the data
				Model_FormData::update_data('tour', $item->id, $tourdata);
			}
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
			
			DBForge::optimize('tour');
			DBForge::optimize('form_data');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Take the awards from the old crew table and put it into the awards_received table.
	 */
	public function action_upgrade_user_awards()
	{
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			// create an array for saved entries
			$saved = array();
			
			foreach ($result as $c)
			{
				$user = Model_Character::find($c->crewid)->user;
				
				if ( ! empty($c->awards))
				{
					$awards = explode(';', $c->awards);
					
					foreach ($awards as $a)
					{
						if (strstr($a, '|') !== false)
						{
							$x = explode('|', $a);
							
							// set the data to be put into the database
							$awarddata = array(
								'receive_character_id' => $c->crewid,
								'receive_user_id' => $user->id,
								'award_id' => $x[0],
								'date' => $x[1],
								'reason' => $x[2]
							);
						}
						else
						{
							// set the data to be put into the database
							$awarddata = array(
								'receive_character_id' => $c->crewid,
								'receive_user_id' => $user->id,
								'award_id' => $a,
								'date' => null
							);
						}
						
						// create the item
						$item = Model_AwardRec::create_item($awarddata);
						
						$saved[] = (is_object($item)) ? true : false;
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
			
			DBForge::optimize('awards_received');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Update all the users to make sure they have proper defaults.
	 */
	public function action_upgrade_user_defaults()
	{
		try {
			// get the total number of users
			$users = Model_User::count();
			
			// get the total number of characters
			$characters = Model_Character::count();
			
			if ($users > 0 and $characters > 0)
			{
				// pull the defaults for skins and ranks
				$defaults = array(
					'skin_main'			=> Model_CatalogueSkinSec::get_default('main')->skins->location,
					'skin_admin'		=> Model_CatalogueSkinSec::get_default('admin')->skins->location,
					'display_rank'		=> Model_CatalogueRank::get_default(true),
					'my_links'			=> '',
					'language'			=> 'en-us',
					'daylight_savings'	=> (int) false,
				);
				
				// update all users
				Model_User::update_user(null, $defaults);
				
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
	
	/**
	 * Upgrade the user_id field in the personal logs table.
	 */
	public function action_upgrade_user_logs()
	{
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			foreach ($result as $c)
			{
				$user = Model_Character::find($c->crewid)->user;
				
				if ( ! is_null($user) and $user->id > 0)
				{
					// get all of a character's logs
					$logs = Model_PersonalLog::find()->where('character_id', $c->crewid)->get();
					
					foreach ($logs as $l)
					{
						$l->user_id = $user->id;
						$l->save();
					}
				}
			}
			
			// count the number of personal logs that don't have a user (there shouldn't be any)
			$blank = Model_PersonalLog::find()->where('user_id', '')->count();
			
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
			
			DBForge::optimize('personal_logs');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Upgrade the user_id field in the news table.
	 */
	public function action_upgrade_user_news()
	{
		try {
			// get the crew from the sms table
			$result = $this->db->query(Database::SELECT, 'SELECT * FROM sms_crew', true);
			
			foreach ($result as $c)
			{
				$user = Model_Character::find($c->crewid)->user;
				
				if ( ! is_null($user) and $user->id > 0)
				{
					// get all of a character's logs
					$news = Model_News::find()->where('character_id', $c->crewid)->get();
					
					foreach ($news as $n)
					{
						$n->user_id = $user->id;
						$n->save();
					}
				}
			}
			
			// count the number of news items without a user (there shouldn't be any)
			$blank = Model_News::find()->where('user_id', '')->count();
			
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
			
			DBForge::optimize('news');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Go through the posts table and add records for the post_authors through table.
	 */
	public function action_upgrade_user_posts()
	{
		try {
			// get all the posts
			$posts = Model_Post::find('all');
			
			// set a temp array to collect saves
			$saved = array();
			
			foreach ($posts as $p)
			{
				/**
				 * Grab the authors from the table (we need to do it this way because 
				 * there's no reason to be adding a field we're just going to be using 
				 * here to the ORM)
				 */
				$post_item = $this->db->query(Database::SELECT, "SELECT authors FROM `".$this->db->table_prefix()."posts` WHERE id = ".$p->id)
					->current();
				
				// make the authors listing an array
				$authors = explode(',', $post_item['authors']);
				
				foreach ($authors as $a)
				{
					// get the character
					$char = Model_Character::find($a);
					
					if ($char !== null)
					{
						// build the information that's going into the post_authors table
						$through = array(
							'post_id' => $p->id,
							'character_id' => $a,
							'user_id' => ($a === 0 or $a === null or $char->user === null) ? 0 : $char->user->id,
						);
						
						// add the record to the table
						Model_PostAuthor::create_item($through);
					}
				}
			}
			
			if ( ! in_array(false, $saved))
			{
				// since we know this was successful, we're going to remove the columns we don't need
				DBForge::drop_column('posts', 'authors');
				
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
			
			DBForge::optimize('posts');
			DBForge::optimize('post_authors');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	/**
	 * Update the welcome page title.
	 */
	public function action_upgrade_welcome()
	{
		try {
			// do the update
			Model_SiteContent::update_messages(array('welcome_head' => "Welcome to the ".Model_Settings::get_settings('sim_name')."!"));
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
			
			DBForge::optimize('site_contents');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _upgrade_applications()
	{
		try {
			$result = $this->db->query(Database::SELECT, "SELECT * FROM nova1_applications", true);
			$count_old= $result->count();
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'email'				=> $r->app_email,
						'ip_address'		=> $r->app_ip,
						'user_id'			=> $r->app_user,
						'user_name'			=> $r->app_user_name,
						'character_id'		=> $r->app_character,
						'character_name'	=> $r->app_character_name,
						'position'			=> $r->app_position,
						'date'				=> $r->app_date,
						'action'			=> $r->app_action,
						'message'			=> $r->app_message,
					);
					
					Model_Application::create_item($data);
				}
			}
			
			$count_new = Model_Application::count();
			
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
					'message' => "The applications could not be properly upgraded."
				);
			}
			
			DBForge::optimize('applications');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_character_form()
	{
		try {
			/**
			 * Bio Tabs
			 */
			 
			// clear out the existing the tabs
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_tabs` WHERE `form_key` = 'bio'", true);
			
			// pull the tabs from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_characters_tabs`", true);
			
			if (count($result) > 0)
			{
				$tabs = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 	=> 'bio',
						'name' 		=> $r->tab_name,
						'link_id' 	=> $r->tab_link_id,
						'order' 	=> $r->tab_order,
						'display' 	=> (int) true
					);
					
					// create the tab record
					$item = Model_FormTab::create_item($data);
					
					// track the old and new IDs
					$tabs[$r->tab_id] = $item->id;
				}
			}
			
			/**
			 * Bio Sections
			 */
			 
			// clear out the existing sections
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_sections` WHERE `form_key` = 'bio'", true);
			
			// pull the sections from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_characters_sections`", true);
			
			if (count($result) > 0)
			{
				$sections = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 	=> 'bio',
						'tab_id' 	=> $tabs[$r->section_tab],
						'name' 		=> $r->section_name,
						'order' 	=> $r->section_order
					);
					
					// create the section record
					$item = Model_FormSection::create_item($data);
					
					// track the old and new IDs
					$sections[$r->section_id] = $item->id;
				}
			}
			
			/**
			 * Bio Fields
			 */
			
			// clear out the existing fields
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_fields` WHERE `form_key` = 'bio'", true);
			
			// pull the fields from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_characters_fields`", true);
			
			if (count($result) > 0)
			{
				$fields = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'bio',
						'section_id' 	=> $sections[$r->field_section],
						'type' 			=> $r->field_type,
						'html_name' 	=> $r->field_name,
						'html_id' 		=> $r->field_fid,
						'html_class' 	=> $r->field_class,
						'html_rows' 	=> $r->field_rows,
						'selected' 		=> '',
						'value' 		=> $r->field_value,
						'label' 		=> $r->field_label_page,
						'placeholder' 	=> '',
						'order' 		=> $r->field_order,
						'display' 		=> ($r->field_display == 'y') ? 1 : 0,
						'updated_at' 	=> Date::now(),
					);
					
					// create the field record
					$item = Model_FormField::create_item($data);
					
					// track the old and new IDs
					$fields[$r->field_id] = $item->id;
				}
			}
			
			/**
			 * Bio Field Values
			 */
			
			// clear out the existing values
			$this->db->query(Database::DELETE, "TRUNCATE TABLE `".$this->db->table_prefix()."form_values`", true);
			
			// pull the values from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_characters_values`", true);
			
			if (count($result) > 0)
			{
				$values = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'field_id' 		=> $fields[$r->value_field],
						'html_name' 	=> '',
						'html_value' 	=> $r->value_field_value,
						'html_id' 		=> '',
						'selected' 		=> $r->value_selected,
						'content' 		=> $r->value_content,
						'order' 		=> $r->value_order,
					);
					
					// create the value record
					$item = Model_FormValue::create_item($data);
					
					// track the old and new IDs
					$values[$r->value_id] = $item->id;
				}
			}
			
			/**
			 * Bio Field Data
			 */
			
			// clear out the existing data
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_data` WHERE `form_key` = 'bio'", true);
			
			// pull the data from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_characters_data`", true);
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'bio',
						'field_id' 		=> $fields[$r->data_field],
						'user_id' 		=> $r->data_user,
						'character_id' 	=> $r->data_char,
						'item_id' 		=> null,
						'value' 		=> $r->data_value,
						'updated_at' 	=> Date::now(),
					);
					
					// create the data record
					Model_FormData::create_item($data);
				}
			}
			
			/**
			 * User Information
			 */
			 
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_users`", true);
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'location' => array(
							'form_key' 		=> 'user',
							'field_id' 		=> 50,
							'user_id' 		=> $r->userid,
							'character_id' 	=> null,
							'item_id' 		=> null,
							'value' 		=> $r->location,
							'updated_at' 	=> Date::now()),
						'interests' => array(
							'form_key' 		=> 'user',
							'field_id' 		=> 51,
							'user_id' 		=> $r->userid,
							'character_id'	=> null,
							'item_id'		=> null,
							'value'			=> $r->interests,
							'updated_at'	=> Date::now()),
						'bio' => array(
							'form_key'		=> 'user',
							'field_id'		=> 52,
							'user_id'		=> $r->userid,
							'character_id'	=> null,
							'item_id'		=> null,
							'value'			=> $r->bio,
							'updated_at'	=> Date::now()),
					);
					
					// insert the records
					Model_FormData::create_item($data['location']);
					Model_FormData::create_item($data['interests']);
					Model_FormData::create_item($data['bio']);
				}
			}
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _upgrade_character_promotions()
	{
		try {
			$result = $this->db->query(Database::SELECT, "SELECT * FROM nova1_characters_promotions", true);
			$count_old= $result->count();
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'user_id'		=> $r->prom_user,
						'character_id'	=> $r->prom_char,
						'old_order'		=> $r->prom_old_order,
						'old_rank'		=> $r->prom_old_rank,
						'new_order'		=> $r->prom_new_order,
						'new_rank'		=> $r->prom_new_rank,
						'date'			=> $r->prom_date,
					);
					
					Model_CharacterPromotion::create_item($data);
				}
			}
			
			$count_new = Model_CharacterPromotion::count();
			
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
					'message' => "The character promotion records could not be properly upgraded."
				);
			}
			
			DBForge::optimize('character_promotions');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_characters()
	{
		$c = $this->db->query(Database::SELECT, "SELECT charid FROM nova1_characters", true);
		$count_old = $c->count();
		
		DBForge::drop_table('characters');
		
		try {
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."characters SELECT * FROM nova1_characters", true);
			
			$fields = array(
				'charid' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'first_name' => array(
					'name' => 'first_name',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'middle_name' => array(
					'name' => 'middle_name',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'last_name' => array(
					'name' => 'last_name',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'suffix' => array(
					'name' => 'suffix',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'crew_type' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'active','inactive','pending','archived'",
					'default' => 'pending'),
				'date_activate' => array(
					'name' => 'activated',
					'type' => 'BIGINT',
					'constraint' => 20),
				'date_deactivate' => array(
					'name' => 'deactivated',
					'type' => 'BIGINT',
					'constraint' => 20),
				'rank' => array(
					'name' => 'rank_id',
					'type' => 'INT',
					'constraint' => 10),
				'position_1' => array(
					'name' => 'position1_id',
					'type' => 'INT',
					'constraint' => 10),
				'position_2' => array(
					'name' => 'position2_id',
					'type' => 'INT',
					'constraint' => 10),
				'last_post' => array(
					'name' => 'last_post',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			
			DBForge::modify_column('characters', $fields);
			
			$add = array(
				'updated_at' => array(
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			DBForge::add_column('characters', $add);
			
			$count_new = Model_Character::count();
			
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
					'message' => "Not all of the characters were transferred to the Nova 3 format"
				);
			}
			
			DBForge::optimize('characters');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_coc()
	{
		$c = $this->db->query(Database::SELECT, "SELECT coc_id FROM nova1_coc", true);
		$count_old = $c->count();
		
		DBForge::drop_table('coc');
		
		try {
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."coc SELECT * FROM nova1_coc", true);
			
			$fields = array(
				'coc_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'coc_crew' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'coc_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
			);
			
			DBForge::modify_column('coc', $fields);
			
			$add = array(
				'user_id' => array(
					'type' => 'INT',
					'constraint' => 8)
			);
			
			DBForge::add_column('coc', $add);
			
			$all = Model_Coc::find('all');
			
			if (count($all) > 0)
			{
				foreach ($all as $a)
				{
					$char = Model_Character::find($a->character_id);
					
					if ($char !== null)
					{
						$a->user_id = ($char->user === 0 or $char->user === null) ? 0 : $char->user->id;
						$a->save();
					}
				}
			}
			
			$count_new = Model_Coc::count();
			
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
					'message' => "The chain of command could not be properly upgraded."
				);
			}
			
			DBForge::optimize('coc');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_docking_form()
	{
		try {
			/**
			 * Docking Sections
			 */
			 
			// clear out the existing sections
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_sections` WHERE `form_key` = 'docking'", true);
			
			// pull the sections from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_docking_sections`", true);
			
			if (count($result) > 0)
			{
				$sections = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 	=> 'docking',
						'name' 		=> $r->section_name,
						'order' 	=> $r->section_order
					);
					
					// create the section record
					$item = Model_FormSection::create_item($data);
					
					// track the old and new IDs
					$sections[$r->section_id] = $item->id;
				}
			}
			
			/**
			 * Docking Fields
			 */
			
			// clear out the existing fields
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_fields` WHERE `form_key` = 'docking'", true);
			
			// pull the fields from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_docking_fields`", true);
			
			if (count($result) > 0)
			{
				$fields = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'docking',
						'section_id' 	=> $sections[$r->field_section],
						'type' 			=> $r->field_type,
						'html_name' 	=> $r->field_name,
						'html_id' 		=> $r->field_fid,
						'html_class' 	=> $r->field_class,
						'html_rows' 	=> $r->field_rows,
						'selected' 		=> '',
						'value' 		=> $r->field_value,
						'label' 		=> $r->field_label_page,
						'placeholder' 	=> '',
						'order' 		=> $r->field_order,
						'display' 		=> ($r->field_display == 'y') ? 1 : 0,
						'updated_at' 	=> Date::now(),
					);
					
					// create the field record
					$item = Model_FormField::create_item($data);
					
					// track the old and new IDs
					$fields[$r->field_id] = $item->id;
				}
			}
			
			/**
			 * Docking Field Values
			 */
			
			// pull the values from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_docking_values`", true);
			
			if (count($result) > 0)
			{
				$values = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'field_id' 		=> $fields[$r->value_field],
						'html_name' 	=> '',
						'html_value' 	=> $r->value_field_value,
						'html_id' 		=> '',
						'selected' 		=> $r->value_selected,
						'content' 		=> $r->value_content,
						'order' 		=> $r->value_order,
					);
					
					// create the value record
					$item = Model_FormValue::create_item($data);
					
					// track the old and new IDs
					$values[$r->value_id] = $item->id;
				}
			}
			
			/**
			 * Docking Field Data
			 */
			
			// clear out the existing data
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_data` WHERE `form_key` = 'docking'", true);
			
			// pull the data from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_docking_data`", true);
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'docking',
						'field_id' 		=> $fields[$r->data_field],
						'user_id' 		=> null,
						'character_id' 	=> null,
						'item_id' 		=> $r->data_docking_item,
						'value' 		=> $r->data_value,
						'updated_at' 	=> Date::now(),
					);
					
					// create the data record
					Model_FormData::create_item($data);
				}
			}
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _upgrade_specs_form()
	{
		try {
			/**
			 * Specs Sections
			 */
			 
			// clear out the existing sections
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_sections` WHERE `form_key` = 'specs'", true);
			
			// pull the sections from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_specs_sections`", true);
			
			if (count($result) > 0)
			{
				$sections = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 	=> 'specs',
						'name' 		=> $r->section_name,
						'order' 	=> $r->section_order
					);
					
					// create the section record
					$item = Model_FormSection::create_item($data);
					
					// track the old and new IDs
					$sections[$r->section_id] = $item->id;
				}
			}
			
			/**
			 * Specs Fields
			 */
			
			// clear out the existing fields
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_fields` WHERE `form_key` = 'specs'", true);
			
			// pull the fields from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_specs_fields`", true);
			
			if (count($result) > 0)
			{
				$fields = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'specs',
						'section_id' 	=> $sections[$r->field_section],
						'type' 			=> $r->field_type,
						'html_name' 	=> $r->field_name,
						'html_id' 		=> $r->field_fid,
						'html_class' 	=> $r->field_class,
						'html_rows' 	=> $r->field_rows,
						'selected' 		=> '',
						'value' 		=> $r->field_value,
						'label' 		=> $r->field_label_page,
						'placeholder' 	=> '',
						'order' 		=> $r->field_order,
						'display' 		=> ($r->field_display == 'y') ? 1 : 0,
						'updated_at' 	=> Date::now(),
					);
					
					// create the field record
					$item = Model_FormField::create_item($data);
					
					// track the old and new IDs
					$fields[$r->field_id] = $item->id;
				}
			}
			
			/**
			 * Specs Field Values
			 */
			
			// pull the values from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_specs_values`", true);
			
			if (count($result) > 0)
			{
				$values = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'field_id' 		=> $fields[$r->value_field],
						'html_name' 	=> '',
						'html_value' 	=> $r->value_field_value,
						'html_id' 		=> '',
						'selected' 		=> $r->value_selected,
						'content' 		=> $r->value_content,
						'order' 		=> $r->value_order,
					);
					
					// create the value record
					$item = Model_FormValue::create_item($data);
					
					// track the old and new IDs
					$values[$r->value_id] = $item->id;
				}
			}
			
			/**
			 * Specs Field Data
			 */
			
			// clear out the existing data
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_data` WHERE `form_key` = 'specs'", true);
			
			// pull the data from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_specs_data`", true);
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'specs',
						'field_id' 		=> $fields[$r->data_field],
						'user_id' 		=> null,
						'character_id' 	=> null,
						'item_id' 		=> 1,
						'value' 		=> $r->data_value,
						'updated_at' 	=> Date::now(),
					);
					
					// create the data record
					Model_FormData::create_item($data);
				}
			}
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _upgrade_tour_form()
	{
		try {
			/**
			 * Tour Fields
			 */
			
			// clear out the existing fields
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_fields` WHERE `form_key` = 'tour'", true);
			
			// pull the fields from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_tour_fields`", true);
			
			if (count($result) > 0)
			{
				$fields = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'tour',
						'section_id' 	=> null,
						'type' 			=> $r->field_type,
						'html_name' 	=> $r->field_name,
						'html_id' 		=> $r->field_fid,
						'html_class' 	=> $r->field_class,
						'html_rows' 	=> $r->field_rows,
						'selected' 		=> '',
						'value' 		=> $r->field_value,
						'label' 		=> $r->field_label_page,
						'placeholder' 	=> '',
						'order' 		=> $r->field_order,
						'display' 		=> ($r->field_display == 'y') ? 1 : 0,
						'updated_at' 	=> Date::now(),
					);
					
					// create the field record
					$item = Model_FormField::create_item($data);
					
					// track the old and new IDs
					$fields[$r->field_id] = $item->id;
				}
			}
			
			/**
			 * Tour Field Values
			 */
			
			// pull the values from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_tour_values`", true);
			
			if (count($result) > 0)
			{
				$values = array();
				
				foreach ($result as $r)
				{
					$data = array(
						'field_id' 		=> $fields[$r->value_field],
						'html_name' 	=> '',
						'html_value' 	=> $r->value_field_value,
						'html_id' 		=> '',
						'selected' 		=> $r->value_selected,
						'content' 		=> $r->value_content,
						'order' 		=> $r->value_order,
					);
					
					// create the value record
					$item = Model_FormValue::create_item($data);
					
					// track the old and new IDs
					$values[$r->value_id] = $item->id;
				}
			}
			
			/**
			 * Tour Field Data
			 */
			
			// clear out the existing data
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_data` WHERE `form_key` = 'tour'", true);
			
			// pull the data from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_tour_data`", true);
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'form_key' 		=> 'tour',
						'field_id' 		=> $fields[$r->data_field],
						'user_id' 		=> null,
						'character_id' 	=> null,
						'item_id' 		=> $r->data_tour_item,
						'value' 		=> $r->data_value,
						'updated_at' 	=> Date::now(),
					);
					
					// create the data record
					Model_FormData::create_item($data);
				}
			}
			
			$retval = array(
				'code' => 1,
				'message' => ''
			);
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _upgrade_user_loa()
	{
		try {
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova1_user_loa`", true);
			$count_old= $result->count();
			
			if (count($result) > 0)
			{
				foreach ($result as $r)
				{
					$data = array(
						'user_id'	=> $r->loa_user,
						'start'		=> $r->loa_start_date,
						'end'		=> $r->loa_end_date,
						'duration'	=> $r->loa_duration,
						'reason'	=> $r->loa_reason,
						'type'		=> $r->loa_type,
					);
					
					Model_UserLoa::create_item($data);
				}
			}
			
			$count_new = Model_UserLoa::count();
			
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
					'message' => "The LOA records could not be properly upgraded."
				);
			}
			
			DBForge::optimize('user_loas');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_users()
	{
		$c = $this->db->query(Database::SELECT, "SELECT userid FROM `nova1_users`", true);
		$count_old = $c->count();
		
		DBForge::drop_table('users');
		
		try {
			$this->db->query(null, "CREATE TABLE `".$this->db->table_prefix()."users` SELECT * FROM `nova1_users`", true);
			
			/**
			 * Update the schema with all the changes.
			 */
			$fields = array(
				'userid' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'email' => array(
					'name' => 'email',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'password' => array(
					'name' => 'password',
					'type' => 'VARCHAR',
					'constraint' => 40),
				'date_of_birth' => array(
					'name' => 'date_of_birth',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'main_char' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'access_role' => array(
					'name' => 'role_id',
					'type' => 'INT',
					'constraint' => 5),
				'is_sysadmin' => array(
					'name' => 'is_sysadmin',
					'type' => 'TEXT'),
				'is_game_master' => array(
					'name' => 'is_game_master',
					'type' => 'TEXT'),
				'is_webmaster' => array(
					'name' => 'is_webmaster',
					'type' => 'TEXT'),
				'is_firstlaunch' => array(
					'name' => 'is_firstlaunch',
					'type' => 'TEXT'),
				'timezone' => array(
					'name' => 'timezone',
					'type' => 'VARCHAR',
					'constraint' => 5),
				'daylight_savings' => array(
					'name' => 'daylight_savings',
					'type' => 'VARCHAR',
					'constraint' => 1),
				'language' => array(
					'name' => 'language',
					'type' => 'VARCHAR',
					'constraint' => 50),
				'join_date' => array(
					'name' => 'join_date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'leave_date' => array(
					'name' => 'leave_date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'last_post' => array(
					'name' => 'last_post',
					'type' => 'BIGINT',
					'constraint' => 20),
				'last_login' => array(
					'name' => 'last_login',
					'type' => 'BIGINT',
					'constraint' => 20),
				'loa' => array(
					'name' => 'loa',
					'type' => 'ENUM',
					'constraint' => "'active','loa','eloa'"),
				'display_rank' => array(
					'name' => 'display_rank',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'skin_main' => array(
					'name' => 'skin_main',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'skin_admin' => array(
					'name' => 'skin_admin',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'security_question' => array(
					'name' => 'security_question',
					'type' => 'INT',
					'constraint' => 5),
				'security_answer' => array(
					'name' => 'security_answer',
					'type' => 'VARCHAR',
					'constraint' => 40),
				'password_reset' => array(
					'name' => 'password_reset',
					'type' => 'TINYINT',
					'constraint' => 1),
				'my_links' => array(
					'name' => 'my_links',
					'type' => 'TEXT'),
				'last_update' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			DBForge::modify_column('users', $fields);
			
			/**
			 * Add the email format field for figuring out which emails should
			 * be sent.
			 */
			$add = array(
				'email_format' => array(
					'type' => 'VARCHAR',
					'constraint' => 4)
			);
			DBForge::add_column('users', $add);
			
			/**
			 * Pull all the users and loop through to set the new moderation
			 * and make changes to some of the data to reflect the new changes
			 * to the schema.
			 */
			$all = $this->db->query(Database::SELECT, "SELECT * FROM `".$this->db->table_prefix()."users`", true);
			
			if (count($all) > 0)
			{
				foreach ($all as $user)
				{
					if ($user->moderate_posts == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'posts',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_logs== 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'logs',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_news == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'news',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_post_comments == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'post_comments',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_log_comments == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'log_comments',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_news_comments == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'news_comments',
							'date' => Date::now()
						));
					}
					
					if ($user->moderate_wiki_comments == 'y')
					{
						Model_Moderation::create_item(array(
							'user_id' => $user->userid,
							'character_id' => null,
							'type' => 'wiki_comments',
							'date' => Date::now()
						));
					}
					
					$u = Model_User::find($user->id);
					$u->role_id = Model_AccessRole::STANDARD;
					$u->language = 'en-us';
					$u->email_format = 'html';
					$u->is_sysadmin = (int) ($user->is_sysadmin == 'y');
					$u->is_game_master = (int) ($user->is_game_master == 'y');
					$u->is_webmaster = (int) ($user->is_webmaster == 'y');
					$u->is_firstlaunch = (int) true;
					$u->updated_at = Date::now();
					$u->save();
				}
			}
			
			/**
			 * Drop these columns. Status isn't needed any more because we determine
			 * that dynamically. The wiki template is being pulled in to the main
			 * template. Location, interests and bio are now dynamic user fields.
			 * Moderation is handled in its own table. Instant message is going away.
			 */
			$drop = array(
				'status',
				'instant_message',
				'skin_wiki',
				'location',
				'interests',
				'bio',
				'moderate_posts',
				'moderate_logs',
				'moderate_news',
				'moderate_post_comments',
				'moderate_log_comments',
				'moderate_news_comments',
				'moderate_wiki_comments'
			);
			DBForge::drop_column('users', $add);
			
			/**
			 * We need to do a second round of modifications after updating users
			 * with the new TINYINT fields.
			 */
			$fields = array(
				'is_sysadmin' => array(
					'name' => 'is_sysadmin',
					'type' => 'TINYINT',
					'constraint' => 1),
				'is_game_master' => array(
					'name' => 'is_game_master',
					'type' => 'TINYINT',
					'constraint' => 1),
				'is_webmaster' => array(
					'name' => 'is_webmaster',
					'type' => 'TINYINT',
					'constraint' => 1),
				'is_firstlaunch' => array(
					'name' => 'is_firstlaunch',
					'type' => 'TINYINT',
					'constraint' => 1),
			);
			DBForge::modify_column('users', $fields);
			
			// get the user count
			$count_new = Model_User::count();
			
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
					'message' => "Not all of the characters were transferred to the Nova 3 format"
				);
			}
			
			DBForge::optimize('users');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	public function action_upgrade()
	{
		$this->_upgrade_users();
	}
}
