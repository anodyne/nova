<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Upgrade Ajax Controller
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
		
		// make sure the script doesn't time out
		set_time_limit(0);
	}
	
	/**
	 * Migrate the characters and user data.
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
		
		// images
		$images = $this->_upgrade_character_images();
		$codes['images'] = $images['code'];
		$messages['images'] = $images['message'];
		
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
	 * Migrate awards, award nominations and received awards.
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
			// copy the table along with all its data
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
					'constraint' => 255,
					'default' => ''),
				'award_image' => array(
					'name' => 'image',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
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
			
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards_queue MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('awards');
		DBForge::optimize('awards_queue');
		DBForge::optimize('awards_received');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate site settings, site messages (to site contents) and bans.
	 */
	public function action_upgrade_settings()
	{
		try {
			/**
			 * System Settings
			 */
			$settings = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_settings` ORDER BY setting_id ASC", true);
			
			if (count($settings) > 0)
			{
				foreach ($settings as $s)
				{
					switch ($s->setting_key)
					{
						case 'sim_name':
						case 'sim_year':
						case 'sim_type':
						case 'bio_num_awards':
						case 'list_logs_num':
						case 'list_posts_num':
						case 'updates':
						case 'post_count_format':
						case 'default_email_address':
						case 'posting_requirement':
							$new = Model_Settings::get_settings($s->setting_key, false);
							$new->value = $s->setting_value;
							$new->save();
						break;
						
						case 'email_subject':
						case 'default_email_name':
							$start = ($s->setting_key == 'email_subject') ? '[' : '';
							$end = ($s->setting_key == 'email_subject') ? ']' : '';
							
							$new = Model_Settings::get_settings($s->setting_key, false);
							$new->value = $start.Model_Settings::get_settings('sim_name').$end;
							$new->save();
						break;
						
						case 'show_news':
						case 'use_mission_notes':
						case 'use_sample_post':
							$new = Model_Settings::get_settings($s->setting_key, false);
							$new->value = (int) true;
							$new->save();
						break;
						
						case 'maintenance':
						case 'skin_main':
						case 'skin_admin':
						case 'skin_wiki':
						case 'display_rank':
						case 'allowed_chars_playing':
						case 'allowed_chars_npc':
						case 'timezone':
						case 'daylight_savings':
						case 'date_format':
						case 'manifest_defaults':
						case 'online_timespan':
						case 'use_post_participants':
						case 'system_email':
							// do nothing with these items
						break;
						
						default:
							// build an array of user-created setting data
							$new_data = array(
								'key' => $s->setting_key,
								'value' => $s->setting_value,
								'label' => $s->setting_label,
								'user_created' => (int) true
							);
							
							// add the user-created data to the settings table
							Model_Settings::create_item($new_data);
						break;
					}
				}
			}
			
			/**
			 * Site Contents
			 */
			$messages = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_messages` ORDER BY message_id ASC", true);
			
			if (count($messages) > 0)
			{
				foreach ($messages as $m)
				{
					switch ($m->message_key)
					{
						case 'welcome_msg':
							$new = Model_SiteContent::get_content('main_index_message', false);
							$new->content = $m->message_content;
							$new->save();
						break;
						
						case 'welcome_head':
							$new = Model_SiteContent::get_content('main_index_header', false);
							$new->content = $m->message_content;
							$new->save();
						break;
						
						case 'join_instructions':
							if ( ! empty($m->message_content))
							{
								$new_data = array(
									'key' => 'main_join_message',
									'content' => $m->message_content,
									'label' => $m->message_label,
									'type' => 'message',
									'section' => 'main',
									'page' => 'join',
								);
								Model_SiteContent::create_item($new_data);
							}
						break;
						
						case 'contact':
							if ( ! empty($m->message_content))
							{
								$new_data = array(
									'key' => 'main_contact_message',
									'content' => $m->message_content,
									'label' => $m->message_label,
									'type' => 'message',
									'section' => 'main',
									'page' => 'contact',
								);
								Model_SiteContent::create_item($new_data);
							}
						break;
						
						case 'credits':
							$new = Model_SiteContent::get_content('main_credits_message', false);
							$new->content = $m->message_content;
							$new->save();
						break;
						
						case 'sim':
							$new = Model_SiteContent::get_content('sim_index_message', false);
							$new->content = $m->message_content;
							$new->save();
						break;
						
						case 'join_disclaimer':
						case 'join_post':
						case 'accept_message':
						case 'reject_message':
						case 'docking_accept_message':
						case 'docking_reject_message':
							$new = Model_SiteContent::get_content($m->message_key, false);
							$new->content = $m->message_content;
							$new->save();
						break;
						
						case 'wiki_main':
						case 'credits_perm':
						case 'main_credits_title':
						case 'main_join_title':
							// don't do anything with these items
						break;
						
						default:
							$new_data = array(
								'key' => $m->message_key,
								'content' => $m->message_content,
								'label' => $m->message_label,
								'type' => $m->message_type,
							);
							Model_SiteContent::create_item($new_data);
						break;
					}
				}
			}
			
			/**
			 * Bans
			 */
			// drop the tables
			DBForge::drop_table('bans');
			
			// copy the table along with all its data
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
			
			/**
			 * System UID - need to do this so that passwords don't break
			 */
			$uid = DB::query(Database::SELECT, "SELECT * FROM `nova2_system_info` WHERE sys_id = 1")
				->as_object()
				->execute()
				->current()
				->sys_uid;
				
			$sys = Model_System::find('first');
			
			if (count($sys) > 0)
			{
				$sys->uid = $uid;
				$sys->save();
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
		
		DBForge::optimize('settings');
		DBForge::optimize('site_contents');
		DBForge::optimize('bans');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate personal logs and personal log comments.
	 */
	public function action_upgrade_logs()
	{
		// get the number of logs in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT log_id FROM `nova2_personallogs`", true);
		$count_old = $c->count();
		
		try {
			// drop the nova version of the table
			DBForge::drop_table('personal_logs');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."personal_logs SELECT * FROM `nova2_personallogs`", true);
			
			// rename the fields to appropriate names
			$fields = array(
				'log_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'log_author_character' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'log_author_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'log_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'log_title' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'log_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'log_status' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
				'log_tags' => array(
					'name' => 'tags',
					'type' => 'TEXT'),
				'log_last_update' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			
			// do the modification
			DBForge::modify_column('personal_logs', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."personal_logs MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get the new count of logs
			$count_new = Model_PersonalLog::count();
			
			/**
			 * Personal Log Comments
			 */
			$comments = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_personallogs_comments` ORDER BY lcomment_date ASC", true);
			
			if (count($comments) > 0)
			{
				foreach ($comments as $c)
				{
					$data = array(
						'user_id'		=> $c->lcomment_author_user,
						'character_id'	=> $c->lcomment_author_character,
						'type'			=> 'log',
						'item_id'		=> $c->lcomment_log,
						'content'		=> $c->lcomment_content,
						'status'		=> $c->lcomment_status,
						'date'			=> $c->lcomment_date,
					);
					Model_Comment::create_item($data);
				}
			}
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Personal logs were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All personal logs were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('personal_logs');
		DBForge::optimize('comments');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate news items, news categories and news item comments.
	 */
	public function action_upgrade_news()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT news_id FROM `nova2_news`", true);
		$count_old = $c->count();
		
		try {
			DBForge::drop_table('news');
			DBForge::drop_table('news_categories');
			
			/**
			 * News Categories
			 */
			// copy the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."news_categories SELECT * FROM `nova2_news_categories`", true);
			
			// rename the fields to appropriate names
			$fields = array(
				'newscat_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'newscat_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'newscat_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
			);
			
			// do the modifications
			DBForge::modify_column('news_categories', $fields);
			
			// make sure the auto increment and primary id are correct
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news_categories MODIFY COLUMN `id` INT(5) auto_increment primary key", true);
			
			// get all the awards
			$contents = Model_NewsCategory::find('all');
			
			if (count($contents) > 0)
			{
				foreach ($contents as $content)
				{
					$c = Model_NewsCategory::find($content->id);
					$c->display = (int) ($c->display == 'y');
					$c->save();
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
			DBForge::modify_column('news_categories', $fields);
			
			/**
			 * News
			 */
			// copy the table along with all its data
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."news SELECT * FROM `nova2_news`", true);
			
			// rename the fields to appropriate names
			$fields = array(
				'news_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'news_cat' => array(
					'name' => 'category_id',
					'type' => 'INT',
					'constraint' => 5),
				'news_author_character' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'news_author_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'news_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'news_title' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'news_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'news_status' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
				'news_private' => array(
					'name' => 'private',
					'type' => 'TEXT'),
				'news_tags' => array(
					'name' => 'tags',
					'type' => 'TEXT'),
				'news_last_update' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the modifications
			DBForge::modify_column('news', $fields);
			
			// get all the news items
			$private = Model_News::find('all');
			
			// loop through all the records and make sure the private column is correct
			foreach ($private as $p)
			{
				$p->private = (int) ($p->private == 'y');
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
			DBForge::modify_column('news', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news MODIFY COLUMN `id` INT(8) auto_increment primary key", true);
			
			/**
			 * News Comments
			 */
			$comments = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_news_comments` ORDER BY ncomment_date ASC", true);
			
			if (count($comments) > 0)
			{
				foreach ($comments as $c)
				{
					$data = array(
						'user_id'		=> $c->ncomment_author_user,
						'character_id'	=> $c->ncomment_author_character,
						'type'			=> 'news',
						'item_id'		=> $c->ncomment_news,
						'content'		=> $c->ncomment_content,
						'status'		=> $c->ncomment_status,
						'date'			=> $c->ncomment_date,
					);
					Model_Comment::create_item($data);
				}
			}
			
			// count the news items
			$count_new = Model_News::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "News items were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All news items were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('news');
		DBForge::optimize('news_categories');
		DBForge::optimize('comments');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate missions, mission groups, mission posts and mission post comments.
	 */
	public function action_upgrade_missions()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT mission_id FROM `nova2_missions`", true);
		$count_missions_old = $c->count();
		
		// get the number of news categories in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT post_id FROM `nova2_posts`", true);
		$count_posts_old = $c->count();
		
		try {
			/**
			 * Missions
			 */
			// drop the nova version of the table
			DBForge::drop_table('missions');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'missions SELECT * FROM `nova2_missions`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'mission_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'mission_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'mission_title' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'mission_images' => array(
					'name' => 'images',
					'type' => 'TEXT'),
				'mission_status' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'upcoming','current','completed'",
					'default' => 'upcoming'),
				'mission_start' => array(
					'name' => 'start',
					'type' => 'BIGINT',
					'constraint' => 20),
				'mission_end' => array(
					'name' => 'end',
					'type' => 'BIGINT',
					'constraint' => 20),
				'mission_desc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
				'mission_summary' => array(
					'name' => 'summary',
					'type' => 'TEXT'),
				'mission_notes' => array(
					'name' => 'notes',
					'type' => 'TEXT'),
				'mission_notes_updated' => array(
					'name' => 'notes_updated',
					'type' => 'BIGINT',
					'constraint' => 20),
				'mission_group' => array(
					'name' => 'group_id',
					'type' => 'INT',
					'constraint' => 5),
			);
			
			// do the modification
			DBForge::modify_column('missions', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'missions MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
			/**
			 * Mission Groups
			 */
			// drop the nova version of the table
			DBForge::drop_table('mission_groups');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'mission_groups SELECT * FROM `nova2_mission_groups`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'misgroup_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'misgroup_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'misgroup_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'misgroup_desc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
				'misgroup_parent' => array(
					'name' => 'parent_id',
					'type' => 'INT',
					'constraint' => 5),
			);
			
			// do the modification
			DBForge::modify_column('mission_groups', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'mission_groups MODIFY COLUMN `id` INT(5) auto_increment primary key', true);
			
			/**
			 * Mission Posts
			 */
			// drop the nova version of the table
			DBForge::drop_table('posts');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'posts SELECT * FROM `nova2_posts`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'post_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'post_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'post_title' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'post_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'post_status' => array(
					'name' => 'status',
					'type' => 'ENUM',
					'constraint' => "'activated','saved','pending'",
					'default' => 'activated'),
				'post_location' => array(
					'name' => 'location',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'post_timeline' => array(
					'name' => 'timeline',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'post_mission' => array(
					'name' => 'mission_id',
					'type' => 'INT',
					'constraint' => 8),
				'post_saved' => array(
					'name' => 'saved_user_id',
					'type' => 'INT',
					'constraint' => 11),
				'post_tags' => array(
					'name' => 'tags',
					'type' => 'TEXT'),
				'post_last_update' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'post_participants' => array(
					'name' => 'participants',
					'type' => 'TEXT'),
				'post_lock_user' => array(
					'name' => 'lock_user_id',
					'type' => 'INT',
					'constraint' => 8),
				'post_lock_date' => array(
					'name' => 'lock_date',
					'type' => 'BIGINT',
					'constraint' => 20)
			);
			
			// do the modifications
			DBForge::modify_column('posts', $fields);
			
			// make sure the auto increment and primary key are correct
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'posts MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
			/**
			 * Mission Post Comments
			 */
			$comments = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_posts_comments` ORDER BY pcomment_date ASC", true);
			
			if (count($comments) > 0)
			{
				foreach ($comments as $c)
				{
					$data = array(
						'user_id'		=> $c->pcomment_author_user,
						'character_id'	=> $c->pcomment_author_character,
						'type'			=> 'post',
						'item_id'		=> $c->pcomment_post,
						'content'		=> $c->pcomment_content,
						'status'		=> $c->pcomment_status,
						'date'			=> $c->pcomment_date,
					);
					Model_Comment::create_item($data);
				}
			}
			
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('missions');
		DBForge::optimize('mission_groups');
		DBForge::optimize('posts');
		DBForge::optimize('post_authors');
		DBForge::optimize('comments');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate specifications and the specifications form.
	 */
	public function action_upgrade_specs()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT specs_id FROM `nova2_specs`", true);
		$count_old = $c->count();
		
		try {
			/**
			 * Specifications
			 */
			// drop the nova version of the table
			DBForge::drop_table('specs');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'specs SELECT * FROM `nova2_specs`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'specs_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'specs_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'specs_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'specs_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
				'specs_images' => array(
					'name' => 'images',
					'type' => 'TEXT'),
				'specs_summary' => array(
					'name' => 'summary',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('specs', $fields);
			
			// get all the news items
			$specs = Model_Spec::find('all');
			
			// loop through all the records and make sure the private column is correct
			foreach ($specs as $s)
			{
				$s->display = (int) ($s->display == 'y');
				$s->save();
			}
			
			// rename the fields to appropriate names
			$fields = array(
				'display' => array(
					'name' => 'display',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('specs', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'specs MODIFY COLUMN `id` INT(5) auto_increment primary key', true);
			
			/**
			 * Specs Form
			 */
			$this->_upgrade_specs_form();
			
			// get a count of the specs
			$count_new = Model_Spec::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Specifications were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All specification items were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('specs');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate tour items, deck listings and the tour form.
	 */
	public function action_upgrade_tour()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT tour_id FROM `nova2_tour`", true);
		$count_old = $c->count();
		
		try {
			/**
			 * Tour Items
			 */
			// drop the nova version of the table
			DBForge::drop_table('tour');
			
			// copy the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'tour SELECT * FROM `nova2_tour`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'tour_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 5),
				'tour_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'tour_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'tour_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
				'tour_images' => array(
					'name' => 'images',
					'type' => 'TEXT'),
				'tour_summary' => array(
					'name' => 'summary',
					'type' => 'TEXT'),
				'tour_spec_item' => array(
					'name' => 'spec_id',
					'type' => 'INT',
					'constraint' => 5),
			);
			
			// do the modification
			DBForge::modify_column('tour', $fields);
			
			// get all the news items
			$tour = Model_Tour::find('all');
			
			// loop through all the records and make sure the private column is correct
			foreach ($tour as $t)
			{
				$t->display = (int) ($t->display == 'y');
				$t->save();
			}
			
			// rename the fields to appropriate names
			$fields = array(
				'display' => array(
					'name' => 'display',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('tour', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'tour MODIFY COLUMN `id` INT(5) auto_increment primary key', true);
			
			/**
			 * Tour Decks
			 */
			// drop the nova version of the table
			DBForge::drop_table('tour_decks');
			
			// copy the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'tour_decks SELECT * FROM `nova2_tour_decks`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'deck_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 10),
				'deck_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'deck_order' => array(
					'name' => 'order',
					'type' => 'INT',
					'constraint' => 5),
				'deck_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'deck_item' => array(
					'name' => 'tour_id',
					'type' => 'INT',
					'constraint' => 5),
			);
			
			// do the modification
			DBForge::modify_column('tour_decks', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'tour_decks MODIFY COLUMN `id` INT(10) auto_increment primary key', true);
			
			/**
			 * Tour Form
			 */
			$this->_upgrade_tour_form();
			
			// get a count of the specs
			$count_new = Model_Tour::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Tour items were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All tour items were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('tour');
		DBForge::optimize('tour_decks');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate docking items and the docking form.
	 */
	public function action_upgrade_docking()
	{
		// get the number of news items in the sms table
		$c = $this->db->query(Database::SELECT, "SELECT docking_id FROM `nova2_docking`", true);
		$count_old = $c->count();
		
		if ($count_old > 0)
		{
			try {
				/**
				 * Docking Items
				 */
				// drop the nova version of the table
				DBForge::drop_table('docking');
				
				// copy the table along with all its data
				$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'docking SELECT * FROM `nova2_docking`', true);
				
				// rename the fields to appropriate names
				$fields = array(
					'docking_id' => array(
						'name' => 'id',
						'type' => 'INT',
						'constraint' => 5),
					'docking_sim_name' => array(
						'name' => 'sim_name',
						'type' => 'VARCHAR',
						'constraint' => 255),
					'docking_sim_url' => array(
						'name' => 'sim_url',
						'type' => 'TEXT'),
					'docking_gm_name' => array(
						'name' => 'gm_name',
						'type' => 'VARCHAR',
						'constraint' => 255,
						'default' => ''),
					'docking_gm_email' => array(
						'name' => 'gm_email',
						'type' => 'VARCHAR',
						'constraint' => 255,
						'default' => ''),
					'docking_status' => array(
						'name' => 'status',
						'type' => 'ENUM',
						'constraint' => "'active','inactive','pending'",
						'default' => 'pending'),
					'docking_date' => array(
						'name' => 'date',
						'type' => 'BIGINT',
						'constraint' => 20),
				);
				
				// do the modification
				DBForge::modify_column('docking', $fields);
				
				// make sure the auto increment and primary key are right
				$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'docking MODIFY COLUMN `id` INT(5) auto_increment primary key', true);
				
				/**
				 * Tour Form
				 */
				$this->_upgrade_docking_form();
				
				// get a count of the specs
				$count_new = Model_Docking::count();
				
				if ($count_new == 0)
				{
					$retval = array(
						'code' => 0,
						'message' => "Docking items were not migrated"
					);
				}
				elseif ($count_new > 0 and $count_new != $count_old)
				{
					$retval = array(
						'code' => 2,
						'message' => "All docking items were not properly migrated"
					);
				}
				else
				{
					$retval = array(
						'code' => 1,
						'message' => ''
					);
				}
			} catch (Exception $e) {
				$retval = array(
					'code' => 0,
					'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
				);
			}
			
			DBForge::optimize('docking');
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
	 * Migrate wiki pages, wiki drafts, wiki categories, wiki comments and wiki restrictions.
	 */
	public function action_upgrade_wiki()
	{
		$c = $this->db->query(Database::SELECT, "SELECT page_id FROM `nova2_wiki_pages`", true);
		$count_old = $c->count();
		
		try {
			/**
			 * Wiki Categories
			 */
			// drop the nova version of the table
			DBForge::drop_table('wiki_categories');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'wiki_categories SELECT * FROM `nova2_wiki_categories`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'wikicat_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 8),
				'wikicat_name' => array(
					'name' => 'name',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'wikicat_desc' => array(
					'name' => 'desc',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('wiki_categories', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'wiki_categories MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
			/**
			 * Wiki Comments
			 */
			$comments = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_wiki_comments` ORDER BY wcomment_date ASC", true);
			
			if (count($comments) > 0)
			{
				foreach ($comments as $c)
				{
					$data = array(
						'user_id'		=> $c->wcomment_author_user,
						'character_id'	=> $c->wcomment_author_character,
						'type'			=> 'wiki',
						'item_id'		=> $c->wcomment_page,
						'content'		=> $c->wcomment_content,
						'status'		=> $c->wcomment_status,
						'date'			=> $c->wcomment_date,
					);
					Model_Comment::create_item($data);
				}
			}
			
			/**
			 * Wiki Drafts
			 */
			// drop the nova version of the table
			DBForge::drop_table('wiki_drafts');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'wiki_drafts SELECT * FROM `nova2_wiki_drafts`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'draft_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 11),
				'draft_id_old' => array(
					'name' => 'id_old',
					'type' => 'INT',
					'constraint' => 11),
				'draft_title' => array(
					'name' => 'title',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'draft_author_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'draft_author_character' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'draft_summary' => array(
					'name' => 'summary',
					'type' => 'TEXT'),
				'draft_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'draft_page' => array(
					'name' => 'page_id',
					'type' => 'INT',
					'constraint' => 11),
				'draft_created_at' => array(
					'name' => 'created_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'draft_categories' => array(
					'name' => 'categories',
					'type' => 'TEXT'),
				'draft_changed_comments' => array(
					'name' => 'change_comments',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('wiki_drafts', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'wiki_drafts MODIFY COLUMN `id` INT(11) auto_increment primary key', true);
			
			/**
			 * Wiki Pages
			 */
			// drop the nova version of the table
			DBForge::drop_table('wiki_pages');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'wiki_pages SELECT * FROM `nova2_wiki_pages`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'page_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 11),
				'page_draft' => array(
					'name' => 'draft_id',
					'type' => 'INT',
					'constraint' => 11),
				'page_created_at' => array(
					'name' => 'created_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'page_created_by_user' => array(
					'name' => 'created_by_user',
					'type' => 'INT',
					'constraint' => 8),
				'page_created_by_character' => array(
					'name' => 'created_by_character',
					'type' => 'INT',
					'constraint' => 8),
				'page_updated_at' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'page_updated_by_user' => array(
					'name' => 'updated_by_user',
					'type' => 'INT',
					'constraint' => 8),
				'page_updated_by_character' => array(
					'name' => 'updated_by_character',
					'type' => 'INT',
					'constraint' => 8),
				'page_comments' => array(
					'name' => 'comments',
					'type' => 'TEXT'),
				'page_type' => array(
					'name' => 'type',
					'type' => 'ENUM',
					'constraint' => "'standard','system'",
					'default' => 'standard'),
				'page_key' => array(
					'name' => 'key',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
			);
			
			// do the modification
			DBForge::modify_column('wiki_pages', $fields);
			
			// get all the awards
			$pages = Model_WikiPage::find('all');
			
			if (count($pages) > 0)
			{
				foreach ($pages as $page)
				{
					$p = Model_WikiPage::find($page->id);
					$p->comments = (int) ($p->comments == 'open');
					$p->save();
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'comments' => array(
					'name' => 'comments',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('wiki_pages', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'wiki_pages MODIFY COLUMN `id` INT(11) auto_increment primary key', true);
			
			/**
			 * Wiki Restrictions
			 */
			// drop the nova version of the table
			DBForge::drop_table('wiki_restrictions');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'wiki_restrictions SELECT * FROM `nova2_wiki_restrictions`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'restr_id' => array(
					'name' => 'id',
					'type' => 'INT',
					'constraint' => 11),
				'restr_page' => array(
					'name' => 'page_id',
					'type' => 'INT',
					'constraint' => 11),
				'restr_created_at' => array(
					'name' => 'created_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'restr_created_by' => array(
					'name' => 'created_by',
					'type' => 'INT',
					'constraint' => 8),
				'restr_updated_at' => array(
					'name' => 'updated_at',
					'type' => 'BIGINT',
					'constraint' => 20),
				'restr_updated_by' => array(
					'name' => 'updated_by',
					'type' => 'INT',
					'constraint' => 8),
				'restrictions' => array(
					'name' => 'restrictions',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('wiki_restrictions', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'wiki_restrictions MODIFY COLUMN `id` INT(11) auto_increment primary key', true);
			
			// get a count of the specs
			$count_new = Model_WikiPage::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Wiki pages were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All wiki pages were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('wiki_categories');
		DBForge::optimize('wiki_drafts');
		DBForge::optimize('wiki_pages');
		DBForge::optimize('wiki_restrictions');
		DBForge::optimize('comments');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate image uploads.
	 */
	public function action_upgrade_uploads()
	{
		$c = $this->db->query(Database::SELECT, "SELECT upload_id FROM `nova2_uploads`", true);
		$count_old = $c->count();
		
		try {
			// drop the nova version of the table
			DBForge::drop_table('uploads');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'uploads SELECT * FROM `nova2_uploads`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'upload_id' => array(
					'name' => 'id',
					'type' => 'BIGINT',
					'constraint' => 20),
				'upload_filename' => array(
					'name' => 'filename',
					'type' => 'TEXT'),
				'upload_mime_type' => array(
					'name' => 'mime_type',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'upload_resource_type' => array(
					'name' => 'resource_type',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'upload_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'upload_ip' => array(
					'name' => 'ip_address',
					'type' => 'VARCHAR',
					'constraint' => 16,
					'default' => ''),
				'upload_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
			);
			
			// do the modification
			DBForge::modify_column('uploads', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'uploads MODIFY COLUMN `id` BIGINT(20) auto_increment primary key', true);
			
			// get a count of the specs
			$count_new = Model_Upload::count();
			
			if ($count_new == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Uploads were not migrated"
				);
			}
			elseif ($count_new > 0 and $count_new != $count_old)
			{
				$retval = array(
					'code' => 2,
					'message' => "All uploads were not properly migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('uploads');
		
		echo json_encode($retval);
	}
	
	/**
	 * Migrate private messages and private message recipients records.
	 */
	public function action_upgrade_private_messages()
	{
		$c = $this->db->query(Database::SELECT, "SELECT privmsgs_id FROM `nova2_privmsgs`", true);
		$count_old_msgs = $c->count();
		
		$c = $this->db->query(Database::SELECT, "SELECT pmto_id FROM `nova2_privmsgs_to`", true);
		$count_old_to = $c->count();
		
		try {
			/**
			 * Private Messages
			 */
			// drop the nova version of the table
			DBForge::drop_table('messages');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'messages SELECT * FROM `nova2_privmsgs`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'privmsgs_id' => array(
					'name' => 'id',
					'type' => 'BIGINT',
					'constraint' => 20),
				'privmsgs_author_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'privmsgs_author_character' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'privmsgs_date' => array(
					'name' => 'date',
					'type' => 'BIGINT',
					'constraint' => 20),
				'privmsgs_subject' => array(
					'name' => 'subject',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'privmsgs_content' => array(
					'name' => 'content',
					'type' => 'TEXT'),
				'privmsgs_author_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('messages', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'messages MODIFY COLUMN `id` BIGINT(20) auto_increment primary key', true);
			
			// get all the awards
			$messages = Model_Message::find('all');
			
			if (count($messages) > 0)
			{
				foreach ($messages as $message)
				{
					$m = Model_Message::find($message->id);
					$m->display = (int) ($m->display == 'y');
					$m->save();
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
			DBForge::modify_column('messages', $fields);
			
			/**
			 * Private Messages To
			 */
			// drop the nova version of the table
			DBForge::drop_table('message_recipients');
			
			// copy the sms version of the table along with all its data
			$this->db->query(null, 'CREATE TABLE '.$this->db->table_prefix().'message_recipients SELECT * FROM `nova2_privmsgs_to`', true);
			
			// rename the fields to appropriate names
			$fields = array(
				'pmto_id' => array(
					'name' => 'id',
					'type' => 'BIGINT',
					'constraint' => 20),
				'pmto_message' => array(
					'name' => 'message_id',
					'type' => 'BIGINT',
					'constraint' => 20),
				'pmto_recipient_user' => array(
					'name' => 'user_id',
					'type' => 'INT',
					'constraint' => 8),
				'pmto_recipient_character' => array(
					'name' => 'character_id',
					'type' => 'INT',
					'constraint' => 8),
				'pmto_unread' => array(
					'name' => 'unread',
					'type' => 'TEXT'),
				'pmto_display' => array(
					'name' => 'display',
					'type' => 'TEXT'),
			);
			
			// do the modification
			DBForge::modify_column('message_recipients', $fields);
			
			// make sure the auto increment and primary key are right
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'message_recipients MODIFY COLUMN `id` BIGINT(20) auto_increment primary key', true);
			
			// get all the awards
			$messages = Model_MessageRecipient::find('all');
			
			if (count($messages) > 0)
			{
				foreach ($messages as $message)
				{
					$m = Model_MessageRecipient::find($message->id);
					$m->unread = (int) ($m->unread == 'y');
					$m->display = (int) ($m->display == 'y');
					$m->save();
				}
			}
			
			// now that we've changed the display stuff, change the schema
			$fields = array(
				'unread' => array(
					'name' => 'unread',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
				'display' => array(
					'name' => 'display',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('message_recipients', $fields);
			
			// get a count
			$count_new_msgs = Model_Message::count();
			$count_new_to = Model_MessageRecipient::count();
			
			if ($count_new_msgs == 0 and $count_new_to == 0)
			{
				$retval = array(
					'code' => 0,
					'message' => "Private messages were not migrated"
				);
			}
			elseif (($count_new_msgs > 0 and $count_new_msgs != $count_old_msgs) and $count_new_to == 0)
			{
				$retval = array(
					'code' => 2,
					'message' => "All private messages were not migrated"
				);
			}
			elseif ($count_new_msgs == 0 and ($count_new_to > 0 and $count_new_to != $count_old_to))
			{
				$retval = array(
					'code' => 2,
					'message' => "All private messages were not migrated"
				);
			}
			elseif (($count_new_msgs > 0 and $count_new_msgs != $count_old_msgs) and ($count_new_to > 0 and $count_new_to != $count_old_to))
			{
				$retval = array(
					'code' => 2,
					'message' => "All private messages were not migrated"
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ''
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('messages');
		DBForge::optimize('message_recipients');
		
		echo json_encode($retval);
	}
	
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
					'role_id'			=> Model_AccessRole::STANDARD,
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
					'message' => "User defaults could not be migrated"
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('characters');
		DBForge::optimize('users');
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_author_structure()
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
				$post_item = $this->db->query(Database::SELECT, "SELECT post_authors FROM `".$this->db->table_prefix()."posts` WHERE id = ".$p->id)
					->current();

				// make the authors listing an array
				$authors = explode(',', $post_item['post_authors']);

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
			
			// drop the unnecessary columns
			DBForge::drop_column('posts', 'post_authors');
			DBForge::drop_column('posts', 'post_authors_users');
			
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
		
		DBForge::optimize('posts');
		DBForge::optimize('post_authors');
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_sysadmin()
	{
		// find the ID of the system administrator role
		$c = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_access_roles` WHERE role_name = 'System Administrator'", true)->current();
		$sysadmin = $c->role_id;
		
		// find all the users with those permissions
		$users = Model_User::find()->where('is_sysadmin', 1);
		
		if (count($users) > 0)
		{
			foreach ($users as $user)
			{
				$u = Model_User::find($user->id);
				$u->role_id = Model_AccessRole::SYSADMIN;
				$u->save();
			}
		}
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		echo json_encode($retval);
	}
	
	public function action_upgrade_reorg_schema()
	{
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards CHANGE COLUMN `name` `name` VARCHAR(255) NULL DEFAULT '' AFTER `id`, CHANGE COLUMN `image` `image` VARCHAR(100) NULL DEFAULT '' AFTER `name`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."awards_received CHANGE COLUMN `receive_character_id` `receive_character_id` INT(8) NULL DEFAULT NULL AFTER `id`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."coc CHANGE COLUMN `user_id` `user_id` INT(8) NULL DEFAULT NULL AFTER `id`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."missions CHANGE COLUMN `images` `images` TEXT NULL AFTER `title`, CHANGE COLUMN `order` `order` INT(5) NULL DEFAULT NULL AFTER `images`, CHANGE COLUMN `group_id` `group_id` INT(5) NULL DEFAULT NULL AFTER `order`, CHANGE COLUMN `status` `status` ENUM('upcoming','current','completed') NULL DEFAULT 'upcoming' AFTER `group_id`, CHANGE COLUMN `desc` `desc` TEXT NULL AFTER `end`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."news CHANGE COLUMN `title` `title` VARCHAR(255) NULL DEFAULT '' AFTER `id`, CHANGE COLUMN `user_id` `user_id` INT(8) NULL DEFAULT NULL AFTER `title`, CHANGE COLUMN `category_id` `category_id` INT(5) NULL DEFAULT NULL AFTER `character_id`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."personal_logs CHANGE COLUMN `user_id` `user_id` INT(8) NULL DEFAULT NULL AFTER `title`, CHANGE COLUMN `content` `content` TEXT NULL AFTER `character_id`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."posts CHANGE COLUMN `location` `location` VARCHAR(255) NULL DEFAULT '' AFTER `title`, CHANGE COLUMN `timeline` `timeline` VARCHAR(255) NULL DEFAULT '' AFTER `location`, CHANGE COLUMN `date` `date` BIGINT(20) NULL DEFAULT NULL AFTER `timeline`, CHANGE COLUMN `saved_user_id` `saved_user_id` INT(11) NULL DEFAULT NULL AFTER `mission_id`, CHANGE COLUMN `status` `status` ENUM('activated','saved','pending') NULL DEFAULT 'activated' AFTER `saved_user_id`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."site_contents CHANGE COLUMN `section` `section` VARCHAR(50) NULL DEFAULT '' AFTER `type`, CHANGE COLUMN `page` `page` VARCHAR(100) NULL DEFAULT '' AFTER `section`", true);
		
		$this->db->query(null, "ALTER TABLE ".$this->db->table_prefix()."users CHANGE COLUMN `email_format` `email_format` VARCHAR(4) NULL DEFAULT 'html' AFTER `daylight_savings`", true);
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		echo json_encode($retval);
	}
	
	/**
	 * @todo 	need to make sure this is updated with all the different sections we end up creating
	 */
	public function action_upgrade_cache_content()
	{
		// get an instance of the cache module
		$cache = Cache::instance();
		
		// clear the entire cache
		$cache->delete_all();
		
		// cache the headers
		Model_SiteContent::get_section_content('header', 'main');
		Model_SiteContent::get_section_content('header', 'sim');
		Model_SiteContent::get_section_content('header', 'personnel');
		Model_SiteContent::get_section_content('header', 'search');
		
		// cache the titles
		Model_SiteContent::get_section_content('title', 'main');
		Model_SiteContent::get_section_content('title', 'sim');
		Model_SiteContent::get_section_content('title', 'personnel');
		Model_SiteContent::get_section_content('title', 'search');
		
		// cache the messages
		Model_SiteContent::get_section_content('message', 'main');
		Model_SiteContent::get_section_content('message', 'sim');
		Model_SiteContent::get_section_content('message', 'personnel');
		Model_SiteContent::get_section_content('message', 'search');
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		echo json_encode($retval);
	}
	
	private function _upgrade_applications()
	{
		try {
			$result = $this->db->query(Database::SELECT, "SELECT * FROM `nova2_applications`", true);
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
	
	private function _upgrade_character_images()
	{
		try {
			// get all the characters
			$chars = Model_Character::find('all');
			
			if (count($chars) > 0)
			{
				foreach ($chars as $char)
				{
					$c = Model_Character::find($char->id);
					
					if ( ! empty($c->images))
					{
						// make the images an array
						$images = explode(',', $c->images);
						
						if (is_array($images))
						{
							foreach ($images as $i)
							{
								$data = array(
									'user_id' => ($c->user === 0 or $c->user === null) ? 0 : $c->user->id,
									'character_id' => $c->id,
									'image' => $i,
									'created_at' => Date::now()
								);
							}
						}
					}
				}
			}
			
			DBForge::drop_column('characters', 'images');
			
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
		
		DBForge::optimize('characters');
		DBForge::optimize('character_images');
		
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('character_promotions');
		
		return $retval;
	}
	
	private function _upgrade_characters()
	{
		$c = $this->db->query(Database::SELECT, "SELECT charid FROM `nova2_characters`", true);
		$count_old = $c->count();
		
		DBForge::drop_table('characters');
		
		try {
			$this->db->query(null, "CREATE TABLE ".$this->db->table_prefix()."characters SELECT * FROM `nova2_characters`", true);
			
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
					'constraint' => 255,
					'default' => ''),
				'middle_name' => array(
					'name' => 'middle_name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'last_name' => array(
					'name' => 'last_name',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => ''),
				'suffix' => array(
					'name' => 'suffix',
					'type' => 'VARCHAR',
					'constraint' => 50,
					'default' => ''),
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
					'constraint' => 10,
					'default' => 1),
				'position_1' => array(
					'name' => 'position1_id',
					'type' => 'INT',
					'constraint' => 10,
					'default' => 1),
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
			
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'characters MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
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
			
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'coc MODIFY COLUMN `id` INT(5) auto_increment primary key', true);
			
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('coc');
		
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
			
			// pull the sections
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
			
			// pull the fields
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
			// pull the values
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
			
			// pull the data
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
		
		DBForge::optimize('form_sections');
		DBForge::optimize('form_fields');
		DBForge::optimize('form_values');
		DBForge::optimize('form_data');
		
		return $retval;
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
			
			// pull the sections
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
			
			// pull the fields
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
						'display' 		=> (int) ($r->field_display == 'y'),
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
			// pull the values
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
			
			// pull the data
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
						'item_id' 		=> $r->data_item,
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
		
		DBForge::optimize('form_sections');
		DBForge::optimize('form_fields');
		DBForge::optimize('form_values');
		DBForge::optimize('form_data');
		
		return $retval;
	}
	
	private function _upgrade_tour_form()
	{
		try {
			/**
			 * Tour Fields
			 */
			// clear out the existing fields
			$this->db->query(Database::DELETE, "DELETE FROM `".$this->db->table_prefix()."form_fields` WHERE `form_key` = 'tour'", true);
			
			// pull the fields
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
			// pull the values
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
			
			// pull the data
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
		
		DBForge::optimize('form_sections');
		DBForge::optimize('form_fields');
		DBForge::optimize('form_values');
		DBForge::optimize('form_data');
		
		return $retval;
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('user_loas');
		
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
					'constraint' => 255,
					'default' => ''),
				'email' => array(
					'name' => 'email',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => ''),
				'password' => array(
					'name' => 'password',
					'type' => 'VARCHAR',
					'constraint' => 40,
					'default' => ''),
				'date_of_birth' => array(
					'name' => 'date_of_birth',
					'type' => 'VARCHAR',
					'constraint' => 50,
					'default' => ''),
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
					'constraint' => 5,
					'default' => 'UTC'),
				'daylight_savings' => array(
					'name' => 'daylight_savings',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0),
				'language' => array(
					'name' => 'language',
					'type' => 'VARCHAR',
					'constraint' => 50,
					'default' => 'en-us'),
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
					'constraint' => "'active','loa','eloa'",
					'default' => 'active'),
				'display_rank' => array(
					'name' => 'display_rank',
					'type' => 'VARCHAR',
					'constraint' => 100,
					'default' => 'default'),
				'skin_main' => array(
					'name' => 'skin_main',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => 'default'),
				'skin_admin' => array(
					'name' => 'skin_admin',
					'type' => 'VARCHAR',
					'constraint' => 255,
					'default' => 'default'),
				'security_question' => array(
					'name' => 'security_question',
					'type' => 'INT',
					'constraint' => 5),
				'security_answer' => array(
					'name' => 'security_answer',
					'type' => 'VARCHAR',
					'constraint' => 40,
					'default' => ''),
				'password_reset' => array(
					'name' => 'password_reset',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0),
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
					'constraint' => 4,
					'default' => 'html')
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
					'constraint' => 1,
					'default' => 0),
				'is_game_master' => array(
					'name' => 'is_game_master',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0),
				'is_webmaster' => array(
					'name' => 'is_webmaster',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 0),
				'is_firstlaunch' => array(
					'name' => 'is_firstlaunch',
					'type' => 'TINYINT',
					'constraint' => 1,
					'default' => 1),
			);
			DBForge::modify_column('users', $fields);
			
			$this->db->query(null, 'ALTER TABLE '.$this->db->table_prefix().'users MODIFY COLUMN `id` INT(8) auto_increment primary key', true);
			
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
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		DBForge::optimize('users');
		DBForge::optimize('moderation');
		
		return $retval;
	}
}
