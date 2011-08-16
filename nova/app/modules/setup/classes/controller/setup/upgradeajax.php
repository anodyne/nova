<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Nova 1 Upgrade Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Setup_Upgradeajax extends Controller_Template {
	
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
		$c = $this->db->query(Database::SELECT, "SELECT award_id FROM `nova2_awards`", true);
		$count_old = $c->count();
		
		// drop the nova version of the tables
		DBForge::drop_table('awards');
		DBForge::drop_table('awards_queue');
		DBForge::drop_table('awards_received');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."awards SELECT * FROM `nova2_awards`", true);
			
			// rename the fields
			$fields = array(
				'award_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'award_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255),
				'award_image' => array(
					'name' => 'image',
					'type' => 'VARCHAR',
					'constraint' => 100),
				'award_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'award_desc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
				'award_cat' => array(
					'name' => 'category',
					'type' => 'ENUM',
					'constraint' => "'ic','ooc','both'",
					'default' => 'ic'),
				'award_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
			);
			
			// modify the columns
			DBForge::modify_column('awards', $fields);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get all the awards
			$awards = Model_Award::find('all');
			
			if (count($awards) > 0)
			{
				foreach ($awards as $award)
				{
					$a = Model_Award::find($award->id);
					$a->display = (int) ($a->display == 'y');
					$a->save();
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'display' => array(
					'name' => 'display',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('awards', $fields);
			
			/**
			 * Award Nominations
			 */
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."awards_queue SELECT * FROM `nova2_awards_queue`", true);
			$fields = array(
				'queue_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'queue_receive_character' => array(
					'name' => 'receive_character_id',
					'type' => 'INT',
					'constraint' => 8),
				'queue_receive_user' => array(
					'name' => 'receive_user_id',
					'type' => 'INT',
					'constraint' => 8),
				'queue_nominate' => array(
					'name' => 'nominate_character_id',
					'type' => 'INT',
					'constraint' => 8),
				'queue_award' => array(
					'name' => 'award_id',
					'type' => 'INT',
					'constraint' => 5),
				'queue_reason' => array(
					'name' => 'reason',
					'type' => 'TEXT'),
				'queue_status' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'pending','accepted','rejected'",
					'default' => 'pending'),
				'queue_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			DBForge::modify_column('awards_queue', $fields);
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards_queue MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
			
			/**
			 * Received Awards
			 */
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."awards_received SELECT * FROM `nova2_awards_received`", true);
			$fields = array(
				'awardrec_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'awardrec_character' => array(
					'name' => 'receive_character_id',
					'type' => 'INT',
					'constraint' => 8),
				'awardrec_user' => array(
					'name' => 'receive_user_id',
					'type' => 'INT',
					'constraint' => 8),
				'awardrec_nominated_by' => array(
					'name' => 'nominate_character_id',
					'type' => 'INT',
					'constraint' => 8),
				'awardrec_award' => array(
					'name' => 'award_id',
					'type' => 'INT',
					'constraint' => 5),
				'awardrec_reason' => array(
					'name' => 'reason',
					'type' => 'TEXT'),
				'awardrec_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			DBForge::modify_column('awards_received', $fields);
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards_received MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
			
			// get the number of records in the new table
			$count_new = Model_Award::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Awards were not migrated"
				);
			}
			elseif ($count_new == $count_old)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "All awards were not properly migrated"
				);
			}
			
			DBForge::optimize('awards');
			DBForge::optimize('awards_queue');
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
	 * Upgrade the characters and users.
	 */
	public function action_upgrade_characters()
	{
		// set up some holding arrays
		$codes = array();
		$messages = array();
		
		// characters
		$characters = $this->_upgrade_characters();
		$codes['characters'] = $characters['code'];
		$messages['characters'] = $characters['message'];
		
		// chain of command
		$coc = $this->_upgrade_coc();
		$codes['coc'] = $coc['code'];
		$messages['coc'] = $coc['message'];
		
		// promotions
		$promotions = $this->_upgrade_character_promotions();
		$codes['promotions'] = $promotions['code'];
		$messages['promotions'] = $promotions['message'];
		
		// dynamic form
		$form = $this->_upgrade_character_form();
		$codes['form'] = $form['code'];
		$messages['form'] = $form['message'];
		
		// applications
		$applications = $this->_upgrade_applications();
		$codes['applications'] = $applications['code'];
		$messages['applications'] = $applications['message'];
		
		// users
		$users = $this->_upgrade_users();
		$codes['users'] = $users['code'];
		$messages['users'] = $users['message'];
		
		// user LOAs
		$user_loas = $this->_upgrade_user_loa();
		$codes['user_loas'] = $user_loas['code'];
		$messages['user_loas'] = $user_loas['message'];
		
		if ( ! in_array(1, $codes))
		{
			$retval = array(
				'code' => 0,
				'message' => "There was a problem with the upgrade and none of your data could be migrated."
			);
		}
		elseif (in_array(1, $codes) and in_array(0, $codes))
		{
			foreach ($codes as $key => $c)
			{
				if ($c == 1)
				{
					unset($codes[$key]);
				}
			}
			
			// get an array of just the error messages we need
			$errors = array_intersect_key($messages, $codes);
			
			$retval = array(
				'code' => 2,
				'message' => implode('. ', $errors)
			);
		}
		else
		{
			$retval = array(
				'code' => 1,
				'message' => ''
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
					'constraint' => 20),
				'participants' => array(
					'type' => 'TEXT'),
				'updated_at' => array(
					'type' => 'BIGINT',
					'constraint' => 20),
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
	 * Upgrade the settings, site content (messages) and bans.
	 */
	public function action_upgrade_settings()
	{
		$c = $this->db->query(Database::SELECT, "SELECT setting_id FROM `nova2_settings`", true);
		$count_settings_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT message_id FROM `nova2_messages`", true);
		$count_messages_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT ban_id FROM `nova2_bans`", true);
		$count_bans_old = $c->count();
		
		// drop the nova version of the table
		DBForge::drop_table('settings');
		DBForge::drop_table('site_contents');
		DBForge::drop_table('bans');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."settings SELECT * FROM `nova2_settings`", true);
			
			// rename the fields
			$fields = array(
				'setting_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'setting_key' => array(
					'name' => 'key',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'setting_value' => array(
					'name' => 'value',
					'type' => 'TEXT'),
				'setting_label' => array(
					'name' => 'label',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'setting_user_created' => array(
					'name' => 'user_created',
					'type' => 'TEXT'),
			);
			
			// modify the columns
			DBForge::modify_column('settings', $fields);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."settings MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get all the awards
			$settings = Model_Settings::find('all');
			
			if (count($settings) > 0)
			{
				foreach ($settings as $setting)
				{
					$s = Model_Settings::find($setting->id);
					
					switch ($setting->key)
					{
						case 'skin_wiki':
						case 'allowed_chars_playing':
						case 'allowed_chars_npc':
							$s->delete();
						break;
						
						case 'maintenance':
						case 'daylight_savings':
							$s->value = (int) false;
							$s->user_created = (int) ($s->user_created == 'y');
							$s->save();
						break;
						
						case 'system_email':
							$s->value = (int) true;
							$s->user_created = (int) ($s->user_created == 'y');
							$s->save();
						break;
						
						case 'timezone':
							$s->value = 'UTC';
							$s->user_created = (int) ($s->user_created == 'y');
							$s->save();
						break;
						
						case 'show_news':
						case 'use_mission_notes':
							$s->value = (int) ($s->value == 'y');
							$s->user_created = (int) ($s->user_created == 'y');
							$s->save();
						break;
						
						default:
							$s->user_created = (int) ($s->user_created == 'y');
							$s->save();
						break;
					}
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'user_created' => array(
					'name' => 'user_created',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('settings', $fields);
			
			// get the number of records in the new table
			$count_settings_new = Model_Settings::count();
			
			/**
			 * Messages
			 */
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."site_contents SELECT * FROM `nova2_messages`", true);
			
			// rename the fields
			$fields = array(
				'message_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'message_key' => array(
					'name' => 'key',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'message_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'message_label' => array(
					'name' => 'label',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'message_type' => array(
					'name' => 'type',
					'type' => 'ENUM',
					'constraint' => "'title','message','other'",
					'default' => 'message'),
				'message_protected' => array(
					'name' => 'protected',
					'type' => 'TEXT'),
			);
			
			// modify the columns
			DBForge::modify_column('site_contents', $fields);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."site_contents MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
			
			// get all the awards
			$contents = Model_SiteContent::find('all');
			
			if (count($contents) > 0)
			{
				foreach ($contents as $content)
				{
					$c = Model_SiteContent::find($content->id);
					$c->protected = (int) ($c->protected == 'y');
					$c->save();
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'protected' => array(
					'name' => 'protected',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('site_contents', $fields);
			
			// get the number of records in the new table
			$count_messages_new = Model_SiteContent::count();
			
			/**
			 * Bans
			 */
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."bans SELECT * FROM `nova2_bans`", true);
			
			// rename the fields
			$fields = array(
				'ban_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'ban_level' => array(
					'name' => 'level',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
				'ban_ip' => array(
					'name' => 'ip_address',
					'type' => 'VARCHAR',
					'constraint' => 16,
					'default' => ''),
				'ban_email' => array(
					'name' => 'email',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'ban_reason' => array(
					'name' => 'reason',
					'type' => 'TEXT'),
				'ban_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			
			// modify the columns
			DBForge::modify_column('bans', $fields);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."bans MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get the number of records in the new table
			$count_bans_new = Model_Ban::count();
			
			if ($count_settings_new == ($count_settings_old - 3) and $count_messages_old == $count_messages_new and $count_bans_old == $count_bans_new)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all of your settings and site content (messages) were properly migrated"
				);
			}
			
			DBForge::optimize('settings');
			DBForge::optimize('site_contents');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM nova2_applications", true);
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Application records were not migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all application records could be properly migrated"
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('applications');
		
		return $retval;
	}
	
	private function _upgrade_character_form()
	{
		$c = $this->db->query(Database::SELECT, "SELECT tab_id FROM `nova2_characters_tabs`", true);
		$count_tabs_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT section_id FROM `nova2_characters_sections`", true);
		$count_sections_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT field_id FROM `nova2_characters_fields`", true);
		$count_fields_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT value_id FROM `nova2_characters_values`", true);
		$count_values_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT data_id FROM `nova2_characters_data`", true);
		$count_data_old = $c->count();
		
		try {
			/**
			 * Bio Tabs
			 */
			 
			// clear out the existing the tabs
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_tabs` WHERE `form_key` = 'bio'", true);
			
			// pull the tabs from n1
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_characters_tabs`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_characters_sections`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_characters_fields`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_characters_values`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_characters_data`", true);
			
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
			 
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_users`", true);
			
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
			
			// check the new counts
			$count_tabs_new = Model_FormTab::count(array('where' => array('form_key' => 'bio')));
			$count_sections_new = Model_FormSection::count(array('where' => array('form_key' => 'bio')));
			$count_fields_new = Model_FormField::count(array('where' => array('form_key' => 'bio')));
			$count_values_new = Model_FormValue::count();
			$count_data_new = Model_FormData::count(array('where' => array('form_key' => 'bio')));
			
			if ($count_tabs_old == $count_tabs_new and $count_sections_old == $count_sections_new and $count_fields_old == $count_fields_new
					and $count_values_old == $count_values_new and $count_data_old == $count_data_new)
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
					'message' => "Bio form information could not be properly migrated"
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
	}
	
	private function _upgrade_character_promotions()
	{
		try {
			$result = $this->db->query(Database::SELECT, "SELECT * FROM nova2_characters_promotions", true);
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Character promotion records were not migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all character promotion records could be properly migrated"
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
		$c = $this->db->query(Database::SELECT, "SELECT charid FROM nova2_characters", true);
		$count_old = $c->count();
		
		DBForge::drop_table('characters');
		
		try {
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."characters SELECT * FROM nova2_characters", true);
			
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Characters were not migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all characters could be properly migrated"
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('characters');
		
		return $retval;
	}
	
	private function _upgrade_coc()
	{
		$c = $this->db->query(Database::SELECT, "SELECT coc_id FROM nova2_coc", true);
		$count_old = $c->count();
		
		DBForge::drop_table('coc');
		
		try {
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."coc SELECT * FROM `nova2_coc`", true);
			
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Chain of command could not be properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "The entire chain of command could not be properly migrated"
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_docking_sections`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_docking_fields`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_docking_values`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_docking_data`", true);
			
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
	
	private function _upgrade_settings()
	{
		$c = $this->db->query(Database::SELECT, "SELECT setting_id FROM `nova2_settings`", true);
		$count_settings_old = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT message_id FROM `nova2_messages`", true);
		$count_messages_old = $c->count();
		
		// drop the nova version of the table
		DBForge::drop_table('settings');
		DBForge::drop_table('message');
		
		try {
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."settings SELECT * FROM `nova2_settings`", true);
			
			// rename the fields
			$fields = array(
				'setting_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'setting_key' => array(
					'name' => 'key',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'setting_value' => array(
					'name' => 'value',
					'type' => 'TEXT'),
				'setting_label' => array(
					'name' => 'label',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'setting_user_created' => array(
					'name' => 'user_created',
					'type' => 'TEXT'),
			);
			
			// modify the columns
			DBForge::modify_column('settings', $fields);
			
			// make award_id auto increment and the primary key
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."settings MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get all the awards
			$settings = Model_Settings::find('all');
			
			if (count($settings) > 0)
			{
				foreach ($settings as $setting)
				{
					$s = Model_Settings::find($setting->id);
					$s->user_created = (int) ($s->user_created == 'y');
					$s->save();
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'user_created' => array(
					'name' => 'user_created',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('settings', $fields);
			
			// get the number of records in the new table
			$count_settings_new = Model_Settings::count();
			
			/**
			 * Messages
			 */
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Awards were not migrated"
				);
			}
			elseif ($count_new == $count_old)
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "All awards were not properly migrated"
				);
			}
			
			DBForge::optimize('awards');
			DBForge::optimize('awards_queue');
			DBForge::optimize('awards_received');
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		return $retval;
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_specs_sections`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_specs_fields`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_specs_values`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_specs_data`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_tour_fields`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_tour_values`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_tour_data`", true);
			
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
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_user_loa`", true);
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "LOA records could not be properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all LOA records could be properly migrated"
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
		$c = $this->db->query(Database::SELECT, "SELECT userid FROM `nova2_users`", true);
		$count_old = $c->count();
		
		DBForge::drop_table('users');
		
		try {
			$this->db->query(null, "CREATE TABLE `".$this->db->table_prefix()."users` SELECT * FROM `nova2_users`", true);
			
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
			
			foreach ($drop as $d)
			{
				DBForge::drop_column('users', $d);
			}
			
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
			elseif ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Users were not migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => "Not all users could be properly migrated"
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
		echo Model_FormTab::count(array('where' => array('form_key' => 'bio')));
	}
}
