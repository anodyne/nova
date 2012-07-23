<?php
/**
 * Upgrade Ajax Controller
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Upgradeajax extends \Controller
{
	public function before()
	{
		parent::before();

		// make sure nothing times out
		set_time_limit(0);
	}
	
	/**
	 * Migrate the characters and user data.
	 *
	 * @return	JSON
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate awards, award nominations and received awards.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_awards()
	{
		// start by getting a count of the number of items in the awards table
		$c = \DB::query("SELECT award_id FROM `nova2_awards`")->execute();
		$count_old = count($c);
		
		// drop the nova version of the tables
		\DBUtil::drop_table('awards');
		\DBUtil::drop_table('awards_queue');
		\DBUtil::drop_table('awards_received');
		
		// copy the table along with all its data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."awards SELECT * FROM `nova2_awards`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_image` `image` VARCHAR(100) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_desc` `desc` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_cat` `type` ENUM('ic', 'ooc', 'both') DEFAULT 'ic' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards CHANGE `award_display` `display` TEXT NULL")->execute();

		$add = array(
			'category_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'null' => true),
		);
		\DBUtil::add_fields('awards', $add);
		
		// get all the awards
		$awards = \Model_Award::find('all');
		
		if (count($awards) > 0)
		{
			foreach ($awards as $award)
			{
				$a = \Model_Award::find($award->id);
				$a->display = (int) ($a->display == 'y');
				$a->save();
			}
		}

		$change = array(
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('awards', $change);
		
		/**
		 * Award Nominations
		 */
		\DB::query("CREATE TABLE ".\DB::table_prefix()."awards_queue SELECT * FROM `nova2_awards_queue`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_receive_character` `receive_character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_receive_user` `receive_user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_nominate` `nominate_character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_award` `award_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_reason` `reason` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_status` `status` ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue CHANGE `queue_date` `date` BIGINT(20) NOT NULL")->execute();
		
		/**
		 * Received Awards
		 */
		\DB::query("CREATE TABLE ".\DB::table_prefix()."awards_received SELECT * FROM `nova2_awards_received`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_character` `receive_character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_user` `receive_user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_nominated_by` `nominate_character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_award` `award_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_reason` `reason` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received CHANGE `awardrec_date` `date` BIGINT(20) NOT NULL")->execute();
		
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_queue MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."awards_received MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		
		// get the number of records in the new table
		$count_new = \Model_Award::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate site settings, site messages (to site contents) and bans.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_settings()
	{
		/**
		 * System Settings
		 */
		$settings = \DB::query("SELECT * FROM `nova2_settings` ORDER BY setting_id ASC")->execute();
		
		if (count($settings) > 0)
		{
			foreach ($settings as $s)
			{
				switch ($s['setting_key'])
				{
					case 'sim_name':
					case 'sim_year':
					case 'sim_type':
					case 'updates':
					case 'post_count_format':
					case 'posting_requirement':
						$new = \Model_Settings::get_settings($s['setting_key'], false);
						$new->value = $s['setting_value'];
						$new->save();
					break;

					case 'default_email_address':
						$new = \Model_Settings::get_settings('email_address', false);
						$new->value = $s['setting_value'];
						$new->save();
					break;

					case 'default_email_name':
						$new = \Model_Settings::get_settings('email_name', false);
						$new->value = \Model_Settings::get_settings('sim_name');
						$new->save();
					break;
					
					case 'email_subject':
						$start = ($s['setting_key'] == 'email_subject') ? '[' : '';
						$end = ($s['setting_key'] == 'email_subject') ? ']' : '';
						
						$new = \Model_Settings::get_settings($s['setting_key'], false);
						$new->value = $start.\Model_Settings::get_settings('sim_name').$end;
						$new->save();
					break;
					
					case 'use_mission_notes':
						$new = \Model_Settings::get_settings($s['setting_key'], false);
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
					case 'bio_num_awards':
					case 'list_logs_num':
					case 'list_posts_num':
					case 'show_news':
					case 'use_sample_post':
						// do nothing with these items
					break;
					
					default:
						// build an array of user-created setting data
						$new_data = array(
							'key' => $s['setting_key'],
							'value' => $s['setting_value'],
							'label' => $s['setting_label'],
							'user_created' => (int) true
						);
						
						// add the user-created data to the settings table
						\Model_Settings::create_item($new_data);
					break;
				}
			}
		}
		
		/**
		 * Site Contents
		 */
		$messages = \DB::query("SELECT * FROM `nova2_messages` ORDER BY message_id ASC")->execute();
		
		if (count($messages) > 0)
		{
			foreach ($messages as $m)
			{
				switch ($m['message_key'])
				{
					case 'welcome_msg':
						$new = \Model_SiteContent::get_content('main_index_message', false);
						$new->content = $m['message_content'];
						$new->save();
					break;
					
					case 'welcome_head':
						$new = \Model_SiteContent::get_content('main_index_header', false);
						$new->content = $m['message_content'];
						$new->save();
					break;
					
					case 'join_instructions':
						if ( ! empty($m['message_content']))
						{
							$new_data = array(
								'key' => 'main_join_message',
								'content' => $m['message_content'],
								'label' => $m['message_label'],
								'type' => 'message',
								'section' => 'main',
								'page' => 'join',
							);
							\Model_SiteContent::create_item($new_data);
						}
					break;
					
					case 'contact':
						if ( ! empty($m['message_content']))
						{
							$new_data = array(
								'key' => 'main_contact_message',
								'content' => $m['message_content'],
								'label' => $m['message_label'],
								'type' => 'message',
								'section' => 'main',
								'page' => 'contact',
							);
							\Model_SiteContent::create_item($new_data);
						}
					break;
					
					case 'credits':
						$new = \Model_SiteContent::get_content('main_credits_message', false);
						$new->content = $m['message_content'];
						$new->save();
					break;
					
					case 'sim':
						$new = \Model_SiteContent::get_content('sim_index_message', false);
						$new->content = $m['message_content'];
						$new->save();
					break;
					
					case 'join_disclaimer':
					case 'join_post':
					case 'accept_message':
					case 'reject_message':
						$new = \Model_SiteContent::get_content($m['message_key'], false);
						$new->content = $m['message_content'];
						$new->save();
					break;
					
					case 'wiki_main':
					case 'credits_perm':
					case 'main_credits_title':
					case 'main_join_title':
					case 'docking_accept_message':
					case 'docking_reject_message':
						// don't do anything with these items
					break;
					
					default:
						$new_data = array(
							'key' => $m['message_key'],
							'content' => $m['message_content'],
							'label' => $m['message_label'],
							'type' => $m['message_type'],
						);
						\Model_SiteContent::create_item($new_data);
					break;
				}
			}
		}
		
		/**
		 * Bans
		 */
		// drop the tables
		\DBUtil::drop_table('bans');
		
		// copy the table along with all its data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."bans SELECT * FROM `nova2_bans`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_level` `level` TINYINT(1) DEFAULT 1 NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_ip` `ip_address` VARCHAR(16) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_email` `email` VARCHAR(100) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_reason` `reason` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans CHANGE `ban_date` `date` BIGINT(20) NOT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query("ALTER TABLE ".\DB::table_prefix()."bans MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		
		/**
		 * System UID - need to do this so that passwords don't break
		 */
		$uid = \DB::query("SELECT * FROM `nova2_system_info` WHERE sys_id = 1")
			->as_object()
			->execute()
			->current()
			->sys_uid;
			
		$sys = \Model_System::find('first');
		
		if (count($sys) > 0)
		{
			$sys->uid = $uid;
			$sys->save();
		}
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate personal logs and personal log comments.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_logs()
	{
		// get the number of logs in the sms table
		$c = \DB::query("SELECT log_id FROM `nova2_personallogs`")->execute();
		$count_old = count($c);
		
		// drop the version installed with the system
		\DBUtil::drop_table('personal_logs');
		
		// create a new table from the old data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."personal_logs SELECT * FROM `nova2_personallogs`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_author_character` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_author_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_date` `date` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_title` `title` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_status` `status` ENUM('activated', 'saved', 'pending') DEFAULT 'activated' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_tags` `tags` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs CHANGE `log_last_update` `updated_at` BIGINT(20) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query("ALTER TABLE ".\DB::table_prefix()."personal_logs MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		
		// get the new count of logs
		$count_new = \Model_PersonalLog::count();
		
		/**
		 * Personal Log Comments
		 */
		$comments = \DB::query("SELECT * FROM `nova2_personallogs_comments` ORDER BY lcomment_date ASC")->execute();
		
		if (count($comments) > 0)
		{
			foreach ($comments as $c)
			{
				$data = array(
					'user_id'		=> $c['lcomment_author_user'],
					'character_id'	=> $c['lcomment_author_character'],
					'type'			=> 'log',
					'item_id'		=> $c['lcomment_log'],
					'content'		=> $c['lcomment_content'],
					'status'		=> $c['lcomment_status'],
					'date'			=> $c['lcomment_date'],
				);
				\Model_Comment::create_item($data);
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate news items, news categories and news item comments.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_news()
	{
		// get the number of news items in the sms table
		$c = \DB::query("SELECT news_id FROM `nova2_news`")->execute();
		$count_old = count($c);
		
		// drop the tables installed with the system
		\DBUtil::drop_table('announcements');
		\DBUtil::drop_table('announcement_categories');
		
		/**
		 * News Categories
		 */
		
		// create a new table from the old data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."announcement_categories SELECT * FROM `nova2_news_categories`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcement_categories CHANGE `newscat_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcement_categories CHANGE `newscat_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcement_categories CHANGE `newscat_display` `display` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcement_categories MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		
		// get all the awards
		$contents = \Model_AnnouncementCategory::find('all');
		
		if (count($contents) > 0)
		{
			foreach ($contents as $c)
			{
				$c->display = (int) ($c->display == 'y');
				$c->save();
			}
		}
		
		// now that we've changed the display stuff, change the schema
		$fields = array(
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('announcement_categories', $fields);
		
		/**
		 * News
		 */
		
		// create a new table with the old data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."announcements SELECT * FROM `nova2_news`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_cat` `category_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_author_character` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_author_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_date` `date` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_title` `title` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_status` `status` ENUM('activated', 'saved', 'pending') DEFAULT 'activated' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_private` `private` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_tags` `tags` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements CHANGE `news_last_update` `updated_at` BIGINT(20) NULL")->execute();

		// make sure the primary key is set up properly
		\DB::query("ALTER TABLE ".\DB::table_prefix()."announcements MODIFY COLUMN `id` INT(11) auto_increment primary key")->execute();
		
		// get all the news items
		$private = \Model_Announcement::find('all');
		
		// loop through all the records and make sure the private column is correct
		foreach ($private as $p)
		{
			$p->private = (int) ($p->private == 'y');
			$p->save();
		}
		
		// rename the fields to appropriate names
		$fields = array(
			'private' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 0),
		);
		\DBUtil::modify_fields('announcements', $fields);
		
		/**
		 * News Comments
		 */
		
		// grab the comments from the old table
		$comments = \DB::query("SELECT * FROM `nova2_news_comments` ORDER BY ncomment_date ASC")->execute();
		
		if (count($comments) > 0)
		{
			foreach ($comments as $c)
			{
				$data = array(
					'user_id'		=> $c['ncomment_author_user'],
					'character_id'	=> $c['ncomment_author_character'],
					'type'			=> 'announcement',
					'item_id'		=> $c['ncomment_news'],
					'content'		=> $c['ncomment_content'],
					'status'		=> $c['ncomment_status'],
					'date'			=> $c['ncomment_date'],
				);
				\Model_Comment::create_item($data);
			}
		}
		
		// count the news items
		$count_new = \Model_Announcement::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate missions, mission groups, mission posts and mission post comments.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_missions()
	{
		// get the number of news items in the sms table
		$c = \DB::query("SELECT mission_id FROM `nova2_missions`")->execute();
		$count_missions_old = count($c);
		
		// get the number of news categories in the sms table
		$c = \DB::query("SELECT post_id FROM `nova2_posts`")->execute();
		$count_posts_old = count($c);
		
		/**
		 * Missions
		 */
		
		// drop the table installed with the system
		\DBUtil::drop_table('missions');
		
		// create a new table with the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'missions SELECT * FROM `nova2_missions`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_title` `title` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_images` `images` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_status` `status` ENUM('upcoming', 'current', 'completed') DEFAULT 'upcoming' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_start` `start_date` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_end` `end_date` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_desc` `desc` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_summary` `summary` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_notes` `notes` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_notes_updated` `notes_updated_at` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."missions CHANGE `mission_group` `group_id` INT(11) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'missions MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Mission Groups
		 */
		
		// drop the table installed with the system
		\DBUtil::drop_table('mission_groups');
		
		// create a new table with the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'mission_groups SELECT * FROM `nova2_mission_groups`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."mission_groups CHANGE `misgroup_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."mission_groups CHANGE `misgroup_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."mission_groups CHANGE `misgroup_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."mission_groups CHANGE `misgroup_desc` `desc` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."mission_groups CHANGE `misgroup_parent` `parent_id` INT(11) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'mission_groups MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Mission Posts
		 */
		
		// drop the table installed with the system
		\DBUtil::drop_table('posts');
		
		// create a new table with the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'posts SELECT * FROM `nova2_posts`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_date` `date` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_title` `title` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_status` `status` ENUM('activated', 'saved', 'pending') DEFAULT 'activated' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_location` `location` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_timeline` `timeline` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_mission` `mission_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_saved` `saved_user_id` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_tags` `tags` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_last_update` `updated_at` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_participants` `participants` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_lock_user` `lock_user_id` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."posts CHANGE `post_lock_date` `lock_date` BIGINT(20) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'posts MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Mission Post Comments
		 */
		
		// grab the comments from the old table
		$comments = \DB::query("SELECT * FROM `nova2_posts_comments` ORDER BY pcomment_date ASC")->execute();
		
		if (count($comments) > 0)
		{
			foreach ($comments as $c)
			{
				$data = array(
					'user_id'		=> $c['pcomment_author_user'],
					'character_id'	=> $c['pcomment_author_character'],
					'type'			=> 'post',
					'item_id'		=> $c['pcomment_post'],
					'content'		=> $c['pcomment_content'],
					'status'		=> $c['pcomment_status'],
					'date'			=> $c['pcomment_date'],
				);
				\Model_Comment::create_item($data);
			}
		}

		/**
		 * Setup the new author structure.
		 */

		$this->_upgrade_author_structure();
		
		// count the missions
		$count_missions_new = \Model_Mission::count();
		
		// count the posts
		$count_posts_new = \Model_Post::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate specifications and the specifications form.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_specs()
	{
		// get the number of news items in the sms table
		$c = \DB::query("SELECT specs_id FROM `nova2_specs`")->execute();
		$count_old = $c->count();
		
		/**
		 * Specifications
		 */
		
		// drop the table installed with the system
		\DBUtil::drop_table('specs');
		
		// create a new table from the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'specs SELECT * FROM `nova2_specs`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_display` `display` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_images` `images` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."specs CHANGE `specs_summary` `summary` TEXT NULL")->execute();

		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'specs MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		// get all the spec items
		$specs = \Model_Spec::find('all');
		
		// loop through all the records and make sure the display column is correct
		foreach ($specs as $s)
		{
			$s->display = (int) ($s->display == 'y');
			$s->save();
		}
		
		// rename the fields to appropriate names
		$fields = array(
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('specs', $fields);
		
		/**
		 * Specs Form
		 */
		$this->_upgrade_specs_form();
		
		// get a count of the specs
		$count_new = \Model_Spec::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate tour items, deck listings and the tour form.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_tour()
	{
		// get the number of news items in the sms table
		$c = \DB::query("SELECT tour_id FROM `nova2_tour`")->execute();
		$count_old = count($c);
		
		/**
		 * Tour Items
		 */
		
		// drop the version that the system installed
		\DBUtil::drop_table('tour');
		
		// create a new table from the old date
		\DB::query('CREATE TABLE '.\DB::table_prefix().'tour SELECT * FROM `nova2_tour`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_display` `display` TEXT")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_images` `images` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_summary` `summary` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour CHANGE `tour_spec_item` `spec_id` INT(11) NULL")->execute();

		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'tour MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		// get all the news items
		$tour = \Model_Tour::find('all');
		
		// loop through all the records and make sure the private column is correct
		foreach ($tour as $t)
		{
			$t->display = (int) ($t->display == 'y');
			$t->save();
		}
		
		// rename the fields to appropriate names
		$fields = array(
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('tour', $fields);
		
		/**
		 * Tour Decks
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('tour_decks');
		
		// create a new table from old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'tour_decks SELECT * FROM `nova2_tour_decks`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour_decks CHANGE `deck_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour_decks CHANGE `deck_name` `name` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour_decks CHANGE `deck_order` `order` INT(5) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour_decks CHANGE `deck_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."tour_decks CHANGE `deck_item` `tour_id` INT(11) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'tour_decks MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Tour Form
		 */
		
		$this->_upgrade_tour_form();
		
		// get a count of the specs
		$count_new = \Model_Tour::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate wiki pages, wiki drafts, wiki categories, wiki comments and wiki restrictions.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_wiki()
	{
		$c = \DB::query("SELECT page_id FROM `nova2_wiki_pages`")->execute();
		$count_old = count($c);
		
		/**
		 * Wiki Categories
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('wiki_categories');
		
		// create a new table from the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'wiki_categories SELECT * FROM `nova2_wiki_categories`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_categories CHANGE `wikicat_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_categories CHANGE `wikicat_name` `name` VARCHAR(100) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_categories CHANGE `wikicat_desc` `desc` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'wiki_categories MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Wiki Comments
		 */
		
		// grab the comments from the nova 2 table
		$comments = \DB::query("SELECT * FROM `nova2_wiki_comments` ORDER BY wcomment_date ASC")->execute();
		
		if (count($comments) > 0)
		{
			foreach ($comments as $c)
			{
				$data = array(
					'user_id'		=> $c['wcomment_author_user'],
					'character_id'	=> $c['wcomment_author_character'],
					'type'			=> 'wiki',
					'item_id'		=> $c['wcomment_page'],
					'content'		=> $c['wcomment_content'],
					'status'		=> $c['wcomment_status'],
					'date'			=> $c['wcomment_date'],
				);
				\Model_Comment::create_item($data);
			}
		}
		
		/**
		 * Wiki Drafts
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('wiki_drafts');
		
		// create a new table with the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'wiki_drafts SELECT * FROM `nova2_wiki_drafts`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_id_old` `id_old` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_title` `title` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_author_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_author_character` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_summary` `summary` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_page` `page_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_created_at` `created_at` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_categories` `categories` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_drafts CHANGE `draft_changed_comments` `change_comments` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'wiki_drafts MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		/**
		 * Wiki Pages
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('wiki_pages');
		
		// create a new table from the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'wiki_pages SELECT * FROM `nova2_wiki_pages`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_draft` `draft_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_created_at` `created_at` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_created_by_user` `created_by_user` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_created_by_character` `created_by_character` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_updated_at` `updated_at` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_updated_by_user` `updated_by_user` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_updated_by_character` `updated_by_character` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_comments` `comments` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_type` `type` ENUM('standard', 'system') DEFAULT 'standard' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_pages CHANGE `page_key` `key` VARCHAR(100) NULL")->execute();

		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'wiki_pages MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		// get all the pages
		$pages = \Model_Wiki_Page::find('all');
		
		if (count($pages) > 0)
		{
			foreach ($pages as $p)
			{
				$p->comments = (int) ($p->comments == 'open');
				$p->save();
			}
		}
		
		// now that we've changed the data, change the column
		$fields = array(
			'comments' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('wiki_pages', $fields);
		
		/**
		 * Wiki Restrictions
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('wiki_restrictions');
		
		// create a new table with the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'wiki_restrictions SELECT * FROM `nova2_wiki_restrictions`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_id` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_page` `page_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_created_at` `created_at` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_created_by` `created_by` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_updated_at` `updated_at` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restr_updated_by` `updated_by` INT(11) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."wiki_restrictions CHANGE `restrictions` `restrictions` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'wiki_restrictions MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		// get a count of the specs
		$count_new = \Model_Wiki_Page::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate image uploads.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_uploads()
	{
		$c = \DB::query("SELECT upload_id FROM `nova2_uploads`")->execute();
		$count_old = count($c);
		
		// drop the table installed by the system
		\DBUtil::drop_table('media');
		
		// create a new table from the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'media SELECT * FROM `nova2_uploads`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_id` `id` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_filename` `filename` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_mime_type` `mime_type` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_resource_type` `resource_type` VARCHAR(100) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_ip` `ip_address` VARCHAR(16) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."media CHANGE `upload_date` `created_at` BIGINT(20) NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'media MODIFY COLUMN `id` BIGINT(20) auto_increment primary key')->execute();

		// add the updated_at field
		$add = array(
			'updated_at' => array(
				'type' => 'INT',
				'constraint' => 20,
				'null' => true),
		);
		\DBUtil::add_fields('media', $add);
		
		// get a count of the specs
		$count_new = \Model_Media::count();
		
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
		
		return json_encode($retval);
	}
	
	/**
	 * Migrate private messages and private message recipients records.
	 *
	 * @return	JSON
	 */
	public function action_upgrade_private_messages()
	{
		$c = \DB::query("SELECT privmsgs_id FROM `nova2_privmsgs`")->execute();
		$count_old_msgs = count($c);
		
		$c = \DB::query("SELECT pmto_id FROM `nova2_privmsgs_to`")->execute();
		$count_old_to = count($c);
		
		/**
		 * Private Messages
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('messages');
		
		// create a new table from the old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'messages SELECT * FROM `nova2_privmsgs`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_id` `id` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_author_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_author_character` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_date` `date` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_subject` `subject` VARCHAR(255) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_content` `content` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."messages CHANGE `privmsgs_author_display` `display` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'messages MODIFY COLUMN `id` BIGINT(20) auto_increment primary key')->execute();
		
		// get all the awards
		$messages = \Model_Message::find('all');
		
		if (count($messages) > 0)
		{
			foreach ($messages as $m)
			{
				$m->display = (int) ($m->display == 'y');
				$m->save();
			}
		}
		
		// now that we've changed the display stuff, change the schema
		$fields = array(
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('messages', $fields);
		
		/**
		 * Private Messages To
		 */
		
		// drop the table installed by the system
		\DBUtil::drop_table('message_recipients');
		
		// create a new table with old data
		\DB::query('CREATE TABLE '.\DB::table_prefix().'message_recipients SELECT * FROM `nova2_privmsgs_to`')->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_id` `id` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_message` `message_id` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_recipient_user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_recipient_character` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_unread` `unread` TEXT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."message_recipients CHANGE `pmto_display` `display` TEXT NULL")->execute();
		
		// make sure the primary key is set up properly
		\DB::query('ALTER TABLE '.\DB::table_prefix().'message_recipients MODIFY COLUMN `id` BIGINT(20) auto_increment primary key')->execute();
		
		// get all the awards
		$messages = \Model_MessageRecipient::find('all');
		
		if (count($messages) > 0)
		{
			foreach ($messages as $m)
			{
				$m->unread = (int) ($m->unread == 'y');
				$m->display = (int) ($m->display == 'y');
				$m->save();
			}
		}
		
		// now that we've changed the display stuff, change the schema
		$fields = array(
			'unread' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
			'display' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				'default' => 1),
		);
		\DBUtil::modify_fields('message_recipients', $fields);
		
		// get a count
		$count_new_msgs = \Model_Message::count();
		$count_new_to = \Model_MessageRecipient::count();
		
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
		
		return json_encode($retval);
	}

	/**
	 * Update the password for every user.
	 *
	 * @return	JSON
	 */
	public function action_setup_password()
	{
		// get the new password
		$password = trim(\Security::xss_clean($_POST['password']));

		// hash the new password
		$new_password = \Sentry_User::password_hash($password, \Model_System::get_uid());

		// update all the users with the new password
		\DB::query('UPDATE '.\DB::table_prefix().'users SET password = "'.$new_password.'"')->execute();

		return json_encode(array('code' => 1));
	}

	/**
	 * Update the system administrators.
	 *
	 * @return	JSON
	 */
	public function action_setup_admins()
	{
		$admins = (isset($_POST['admins'])) ? $_POST['admins'] : array();

		if (count($admins) > 0)
		{
			foreach ($admins as $a)
			{
				// clean the content
				$a = trim(\Security::xss_clean($a));

				// find the user and update the record
				$user = \Model_User::find($a);
				$user->role_id = \Model_Access_Role::SYSADMIN;
				$user->save();
			}
		}

		return json_encode(array('code' => 1));
	}
	
	/**
	 * Migrate the application records from Nova 2 to Nova 3.
	 *
	 * @return	array
	 */
	private function _upgrade_applications()
	{
		$result = \DB::query("SELECT * FROM `nova2_applications`")->execute();
		$count_old= count($result);
		
		if ($count_old > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'email'				=> $r['app_email'],
					'ip_address'		=> $r['app_ip'],
					'user_id'			=> $r['app_user'],
					'user_name'			=> $r['app_user_name'],
					'character_id'		=> $r['app_character'],
					'character_name'	=> $r['app_character_name'],
					'position'			=> $r['app_position'],
					'date'				=> $r['app_date'],
					'action'			=> $r['app_action'],
					'message'			=> $r['app_message'],
				);
				
				\Model_Application::create_item($data);
			}
		}
		
		$count_new = \Model_Application::count();
		
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
		
		return $retval;
	}

	/**
	 * Migrate the posts table to use the new through table.
	 *
	 * @return	bool
	 */
	private function _upgrade_author_structure()
	{
		// get all the posts
		$posts = \Model_Post::find('all');

		// set a temp array to collect saves
		$saved = array();

		foreach ($posts as $p)
		{
			/**
			 * Grab the authors from the table (we need to do it this way because 
			 * there's no reason to be adding a field we're just going to be using 
			 * here to the ORM)
			 */
			$post_item = \DB::query("SELECT post_authors FROM `".\DB::table_prefix()."posts` WHERE id = ".$p->id)->execute()->current();

			// make the authors listing an array
			$authors = explode(',', $post_item['post_authors']);

			foreach ($authors as $a)
			{
				// get the character
				$char = \Model_Character::find($a);

				if ($char !== null)
				{
					// build the information that's going into the post_authors table
					$through = array(
						'post_id' => $p->id,
						'character_id' => $a,
						'user_id' => ($a === 0 or $a === null or $char->user === null) ? 0 : $char->user->id,
					);

					// add the record to the table
					\Model_PostAuthor::create_item($through);
				}
			}
		}
		
		// finally, drop the author columns from the posts table
		\DBUtil::drop_fields('posts', array('post_authors', 'post_authors_users'));
		
		return true;
	}
	
	/**
	 * Migrate the character form data to the new Nova 3 generic form.
	 *
	 * @return	array
	 */
	private function _upgrade_character_form()
	{
		$c = \DB::query("SELECT tab_id FROM `nova2_characters_tabs`")->execute();
		$count_tabs_old = count($c);
		
		$c = \DB::query("SELECT section_id FROM `nova2_characters_sections`")->execute();
		$count_sections_old = count($c);
		
		$c = \DB::query("SELECT field_id FROM `nova2_characters_fields`")->execute();
		$count_fields_old = count($c);
		
		$c = \DB::query("SELECT value_id FROM `nova2_characters_values`")->execute();
		$count_values_old = count($c);
		
		$c = \DB::query("SELECT data_id FROM `nova2_characters_data`")->execute();
		$count_data_old = count($c);
		
		/**
		 * Bio Tabs
		 */
		 
		// clear out the existing the tabs
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_tabs` WHERE `form_key` = 'character'")->execute();
		
		// pull the tabs from n1
		$result = \DB::query("SELECT * FROM `nova2_characters_tabs`")->execute();
		
		if (count($result) > 0)
		{
			$tabs = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 	=> 'character',
					'name' 		=> $r['tab_name'],
					'link_id' 	=> $r['tab_link_id'],
					'order' 	=> $r['tab_order'],
					'display' 	=> (int) true
				);
				
				// create the tab record
				$item = \Model_Form_Tab::create_item($data);
				
				// track the old and new IDs
				$tabs[$r['tab_id']] = $item->id;
			}
		}
		
		/**
		 * Bio Sections
		 */
		 
		// clear out the existing sections
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_sections` WHERE `form_key` = 'character'")->execute();
		
		// pull the sections from n1
		$result = \DB::query("SELECT * FROM `nova2_characters_sections`")->execute();
		
		if (count($result) > 0)
		{
			$sections = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 	=> 'character',
					'tab_id' 	=> $tabs[$r['section_tab']],
					'name' 		=> $r['section_name'],
					'order' 	=> $r['section_order']
				);
				
				// create the section record
				$item = \Model_Form_Section::create_item($data);
				
				// track the old and new IDs
				$sections[$r['section_id']] = $item->id;
			}
		}
		
		/**
		 * Bio Fields
		 */
		
		// clear out the existing fields
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_fields` WHERE `form_key` = 'character'")->execute();
		
		// pull the fields from n1
		$result = \DB::query("SELECT * FROM `nova2_characters_fields`")->execute();
		
		if (count($result) > 0)
		{
			$fields = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'character',
					'section_id' 	=> $sections[$r['field_section']],
					'type' 			=> $r['field_type'],
					'html_name' 	=> $r['field_name'],
					'html_id' 		=> $r['field_fid'],
					'html_class' 	=> $r['field_class'],
					'html_rows' 	=> $r['field_rows'],
					'selected' 		=> '',
					'value' 		=> $r['field_value'],
					'label' 		=> $r['field_label_page'],
					'placeholder' 	=> '',
					'order' 		=> $r['field_order'],
					'display' 		=> ($r['field_display'] == 'y') ? (int) true : (int) false,
					'updated_at' 	=> time(),
				);
				
				// create the field record
				$item = \Model_Form_Field::create_item($data);
				
				// track the old and new IDs
				$fields[$r['field_id']] = $item->id;
			}
		}
		
		/**
		 * Bio Field Values
		 */
		
		// clear out the existing values
		\DB::query("TRUNCATE TABLE `".\DB::table_prefix()."form_values`")->execute();
		
		// pull the values from n1
		$result = \DB::query("SELECT * FROM `nova2_characters_values`")->execute();
		
		if (count($result) > 0)
		{
			$values = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'field_id' 		=> $fields[$r['value_field']],
					'content' 		=> $r['value_content'],
					'order' 		=> $r['value_order'],
				);
				
				// create the value record
				$item = \Model_Form_Value::create_item($data);
				
				// track the old and new IDs
				$values[$r['value_id']] = $item->id;
			}
		}
		
		/**
		 * Bio Field Data
		 */
		
		// clear out the existing data
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_data` WHERE `form_key` = 'character'")->execute();
		
		// pull the data from n1
		$result = \DB::query("SELECT * FROM `nova2_characters_data`")->execute();
		
		if (count($result) > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'character',
					'field_id' 		=> $fields[$r['data_field']],
					'user_id' 		=> ($r['data_user'] === null or (int) $r['data_user'] === 0) ? 0 : $r['data_user'],
					'character_id' 	=> $r['data_char'],
					'item_id' 		=> 0,
					'value' 		=> $r['data_value'],
					'updated_at' 	=> time(),
				);
				
				// create the data record
				\Model_Form_Data::create_item($data);
			}
		}
		
		/**
		 * User Information
		 */
		 
		$result = \DB::query("SELECT * FROM `nova2_users`")->execute();
		
		if (count($result) > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'location' => array(
						'form_key' 		=> 'user',
						'field_id' 		=> 50,
						'user_id' 		=> $r['userid'],
						'character_id' 	=> 0,
						'item_id' 		=> 0,
						'value' 		=> $r['location'],
						'updated_at' 	=> time()),
					'interests' => array(
						'form_key' 		=> 'user',
						'field_id' 		=> 51,
						'user_id' 		=> $r['userid'],
						'character_id'	=> 0,
						'item_id'		=> 0,
						'value'			=> $r['interests'],
						'updated_at'	=> time()),
					'bio' => array(
						'form_key'		=> 'user',
						'field_id'		=> 52,
						'user_id'		=> $r['userid'],
						'character_id'	=> 0,
						'item_id'		=> 0,
						'value'			=> $r['bio'],
						'updated_at'	=> time()),
				);
				
				// insert the records
				\Model_Form_Data::create_item($data['location']);
				\Model_Form_Data::create_item($data['interests']);
				\Model_Form_Data::create_item($data['bio']);
			}
		}
		
		// check the new counts
		$count_tabs_new = \Model_Form_Tab::count(array('where' => array('form_key' => 'character')));
		$count_sections_new = \Model_Form_Section::count(array('where' => array('form_key' => 'character')));
		$count_fields_new = \Model_Form_Field::count(array('where' => array('form_key' => 'character')));
		$count_values_new = \Model_Form_Value::count();
		$count_data_new = \Model_Form_Data::count(array('where' => array('form_key' => 'character')));
		
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
		
		return $retval;
	}
	
	/**
	 * Migrate the character images from the characters table to the
	 * characters_images table.
	 *
	 * @return	array
	 */
	private function _upgrade_character_images()
	{
		// get all of the character records
		$characters = \DB::query("SELECT * FROM `".\DB::table_prefix()."characters` WHERE `images` != ''")->execute();

		if (count($characters) > 0)
		{
			foreach ($characters as $c)
			{
				// make the images an array
				$images = explode(',', $c['images']);
				
				if (is_array($images))
				{
					// set the loop counter
					$loop = 0;

					foreach ($images as $i)
					{
						$data = array(
							'user_id' => ((int) $c['user_id'] === 0 or $c['user_id'] === null) ? 0 : $c['user_id'],
							'character_id' => $c['id'],
							'image' => $i,
							'created_at' => time(),
							'created_by' => 0,
							'primary_image' => ($loop === 0) ? (int) true : (int) false,
						);

						// create the image record
						\Model_Character_Image::create_item($data);

						// increment the loop count
						++$loop;
					}
				}
			}
		}

		// drop the images field from the characters table
		\DBUtil::drop_fields('characters', 'images');
			
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		return $retval;
	}
	
	/**
	 * Migrate the character promotions information to the new format.
	 * In the process, make sure that the table isn't being filled up
	 * with useless crap.
	 *
	 * @return	array
	 */
	private function _upgrade_character_promotions()
	{
		$result = \DB::query("SELECT * FROM nova2_characters_promotions")->execute();
		$count_old= count($result);
		
		if ($count_old > 0)
		{
			foreach ($result as $r)
			{
				if ($r['prom_old_order'] != $r['prom_new_order'])
				{
					$data = array(
						'user_id'		=> ($r['prom_user'] === null) ? 0 : $r['prom_user'],
						'character_id'	=> ($r['prom_char'] === null) ? 0 : $r['prom_char'],
						'old_order'		=> $r['prom_old_order'],
						'old_rank'		=> $r['prom_old_rank'],
						'new_order'		=> $r['prom_new_order'],
						'new_rank'		=> $r['prom_new_rank'],
						'date'			=> ($r['prom_date'] === null) ? 0 : $r['prom_date'],
					);
					
					\Model_Character_Promotion::create_item($data);
				}
			}
		}
		
		$count_new = \Model_Character_Promotion::count();
		
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
		
		return $retval;
	}
	
	/**
	 * Migrate character data from Nova 2 to Nova 3.
	 *
	 * @return	array
	 */
	private function _upgrade_characters()
	{
		$c = \DB::query("SELECT charid FROM `nova2_characters`")->execute();
		$count_old = count($c);
		
		\DBUtil::drop_table('characters');

		// create the new table with data from the old table
		\DB::query("CREATE TABLE ".\DB::table_prefix()."characters SELECT * FROM `nova2_characters`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `charid` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `user` `user_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `crew_type` `status` ENUM('active', 'inactive', 'pending', 'archived') DEFAULT 'pending' NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `date_activate` `activated` BIGINT(20) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `date_deactivate` `deactivated` BIGINT(20) NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters CHANGE `rank` `rank_id` INT(11) DEFAULT 1 NOT NULL")->execute();

		// make sure the primary key is right
		\DB::query("ALTER TABLE ".\DB::table_prefix()."characters MODIFY COLUMN `id` INT(11) AUTO_INCREMENT PRIMARY KEY")->execute();

		// adjust for NPCs
		\DB::query("UPDATE ".\DB::table_prefix()."characters SET `status` = 'active' WHERE `status` = ''")->execute();
		
		// add the new fields
		$add = array(
			'updated_at' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'null' => true)
		);
		\DBUtil::add_fields('characters', $add);

		// get all the character records
		$characters = \DB::query('SELECT * FROM `'.\DB::table_prefix().'characters`')->execute();

		if (count($characters) > 0)
		{
			foreach ($characters as $c)
			{
				\Model_Character_Positions::create_item(array(
					'character_id' => $c['id'],
					'position_id' => $c['position_1'],
					'primary' => (int) true
				));

				if ( ! empty($c['position_2']) and $c['position_2'] !== null and (int) $c['position_2'] !== 0)
				{
					\Model_Character_Positions::create_item(array(
						'character_id' => $c['id'],
						'position_id' => $c['position_2'],
						'primary' => (int) false
					));
				}
			}
		}

		// drop the fields we don't need any more
		\DBUtil::drop_fields('characters', array('position_1', 'position_2'));
		
		// count the characters in the updated table
		$count_new = \Model_Character::count();

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
		
		return $retval;
	}
	
	/**
	 * Migrate the COC data from Nova 2 to Nova 3.
	 *
	 * @return	array
	 */
	private function _upgrade_coc()
	{
		$c = \DB::query("SELECT coc_id FROM nova2_coc")->execute();
		$count_old = count($c);
		
		// drop the old table
		\DBUtil::drop_table('coc');

		// create a new table with the old data
		\DB::query("CREATE TABLE ".\DB::table_prefix()."coc SELECT * FROM `nova2_coc`")->execute();

		// modify the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."coc CHANGE `coc_id` `id` INT(5) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."coc CHANGE `coc_crew` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."coc CHANGE `coc_order` `order` INT(5) NULL")->execute();

		// make sure the primary key is set up right
		\DB::query('ALTER TABLE '.\DB::table_prefix().'coc MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
		
		$add = array(
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11)
		);
		\DBUtil::add_fields('coc', $add);
		
		$all = \Model_Coc::find('all');
		
		if (count($all) > 0)
		{
			foreach ($all as $a)
			{
				$char = \Model_Character::find($a->character_id);
				
				if ($char !== null)
				{
					$a->user_id = ($char->user_id === 0 or $char->user_id === null) ? 0 : $char->user_id;
					$a->save();
				}
			}
		}
		
		$count_new = \Model_Coc::count();
		
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
		
		return $retval;
	}
	
	/**
	 * Migrate the specs form to the new generic form.
	 *
	 * @return	array
	 */
	private function _upgrade_specs_form()
	{
		/**
		 * Specs Sections
		 */
		
		// clear out the existing sections
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_sections` WHERE `form_key` = 'specs'")->execute();
		
		// pull the sections
		$result = \DB::query("SELECT * FROM `nova2_specs_sections`")->execute();
		
		if (count($result) > 0)
		{
			$sections = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 	=> 'specs',
					'name' 		=> $r['section_name'],
					'order' 	=> $r['section_order']
				);
				
				// create the section record
				$item = \Model_Form_Section::create_item($data);
				
				// track the old and new IDs
				$sections[$r['section_id']] = $item->id;
			}
		}
		
		/**
		 * Specs Fields
		 */
		
		// clear out the existing fields
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_fields` WHERE `form_key` = 'specs'")->execute();
		
		// pull the fields
		$result = \DB::query("SELECT * FROM `nova2_specs_fields`")->execute();
		
		if (count($result) > 0)
		{
			$fields = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'specs',
					'section_id' 	=> $sections[$r['field_section']],
					'type' 			=> $r['field_type'],
					'html_name' 	=> $r['field_name'],
					'html_id' 		=> $r['field_fid'],
					'html_class' 	=> $r['field_class'],
					'html_rows' 	=> $r['field_rows'],
					'selected' 		=> '',
					'value' 		=> $r['field_value'],
					'label' 		=> $r['field_label_page'],
					'placeholder' 	=> '',
					'order' 		=> $r['field_order'],
					'display' 		=> (int) ($r['field_display'] == 'y'),
					'updated_at' 	=> time(),
				);
				
				// create the field record
				$item = \Model_Form_Field::create_item($data);
				
				// track the old and new IDs
				$fields[$r['field_id']] = $item->id;
			}
		}
		
		/**
		 * Specs Field Values
		 */
		
		// pull the values
		$result = \DB::query("SELECT * FROM `nova2_specs_values`")->execute();
		
		if (count($result) > 0)
		{
			$values = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'field_id' 		=> $fields[$r['value_field']],
					'content' 		=> $r['value_content'],
					'order' 		=> $r['value_order'],
				);
				
				// create the value record
				$item = \Model_Form_Value::create_item($data);
				
				// track the old and new IDs
				$values[$r['value_id']] = $item->id;
			}
		}
		
		/**
		 * Specs Field Data
		 */
		
		// clear out the existing data
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_data` WHERE `form_key` = 'specs'")->execute();
		
		// pull the data
		$result = \DB::query("SELECT * FROM `nova2_specs_data`")->execute();
		
		if (count($result) > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'specs',
					'field_id' 		=> $fields[$r['data_field']],
					'user_id' 		=> 0,
					'character_id' 	=> 0,
					'item_id' 		=> $r['data_item'],
					'value' 		=> $r['data_value'],
					'updated_at' 	=> time(),
				);
				
				// create the data record
				\Model_Form_Data::create_item($data);
			}
		}
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		return $retval;
	}
	
	/**
	 * Migrate the tour form to the new generic form.
	 *
	 * @return	array
	 */
	private function _upgrade_tour_form()
	{
		/**
		 * Tour Fields
		 */
		
		// clear out the existing fields
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_fields` WHERE `form_key` = 'tour'")->execute();
		
		// pull the fields
		$result = \DB::query("SELECT * FROM `nova2_tour_fields`")->execute();
		
		if (count($result) > 0)
		{
			$fields = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'tour',
					'section_id' 	=> null,
					'type' 			=> $r['field_type'],
					'html_name' 	=> $r['field_name'],
					'html_id' 		=> $r['field_fid'],
					'html_class' 	=> $r['field_class'],
					'html_rows' 	=> $r['field_rows'],
					'selected' 		=> '',
					'value' 		=> $r['field_value'],
					'label' 		=> $r['field_label_page'],
					'placeholder' 	=> '',
					'order' 		=> $r['field_order'],
					'display' 		=> ($r['field_display'] == 'y') ? (int) true : (int) false,
					'updated_at' 	=> time(),
				);
				
				// create the field record
				$item = \Model_Form_Field::create_item($data);
				
				// track the old and new IDs
				$fields[$r['field_id']] = $item->id;
			}
		}
		
		/**
		 * Tour Field Values
		 */
		
		// pull the values
		$result = \DB::query("SELECT * FROM `nova2_tour_values`")->execute();
		
		if (count($result) > 0)
		{
			$values = array();
			
			foreach ($result as $r)
			{
				$data = array(
					'field_id' 		=> $fields[$r['value_field']],
					'content' 		=> $r['value_content'],
					'order' 		=> $r['value_order'],
				);
				
				// create the value record
				$item = \Model_Form_Value::create_item($data);
				
				// track the old and new IDs
				$values[$r['value_id']] = $item->id;
			}
		}
		
		/**
		 * Tour Field Data
		 */
		
		// clear out the existing data
		\DB::query("DELETE FROM `".\DB::table_prefix()."form_data` WHERE `form_key` = 'tour'")->execute();
		
		// pull the data
		$result = \DB::query("SELECT * FROM `nova2_tour_data`")->execute();
		
		if (count($result) > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'form_key' 		=> 'tour',
					'field_id' 		=> $fields[$r['data_field']],
					'user_id' 		=> 0,
					'character_id' 	=> 0,
					'item_id' 		=> $r['data_tour_item'],
					'value' 		=> $r['data_value'],
					'updated_at' 	=> time(),
				);
				
				// create the data record
				\Model_Form_Data::create_item($data);
			}
		}
		
		$retval = array(
			'code' => 1,
			'message' => ''
		);
		
		return $retval;
	}
	
	private function _upgrade_user_loa()
	{
		$result = \DB::query("SELECT * FROM `nova2_user_loa`")->execute();
		$count_old = count($result);
		
		if ($count_old > 0)
		{
			foreach ($result as $r)
			{
				$data = array(
					'user_id'	=> $r['loa_user'],
					'start'		=> ($r['loa_start_date'] === null) ? 0 : $r['loa_start_date'],
					'end'		=> $r['loa_end_date'],
					'duration'	=> $r['loa_duration'],
					'reason'	=> $r['loa_reason'],
					'type'		=> $r['loa_type'],
				);
				
				\Model_User_Loa::create_item($data);
			}
		}
		
		$count_new = \Model_User_Loa::count();
		
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
		
		return $retval;
	}
	
	/**
	 * Migrate the user data from Nova 2 to Nova 3.
	 *
	 * @return	array
	 */
	private function _upgrade_users()
	{
		$c = \DB::query("SELECT userid FROM `nova2_users`")->execute();
		$count_old = count($c);
		
		// drop the table so we can start from scratch
		\DBUtil::drop_table('users');
		
		// create the new table from the Nova 2 data
		\DB::query("CREATE TABLE `".\DB::table_prefix()."users` SELECT * FROM `nova2_users`")->execute();

		// change the columns
		\DB::query("ALTER TABLE ".\DB::table_prefix()."users CHANGE `userid` `id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."users CHANGE `main_char` `character_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."users CHANGE `access_role` `role_id` INT(11) NOT NULL")->execute();
		\DB::query("ALTER TABLE ".\DB::table_prefix()."users CHANGE `last_update` `updated_at` BIGINT(20) NULL")->execute();

		// make sure the primary key is set up right
		\DB::query('ALTER TABLE '.\DB::table_prefix().'users MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();

		/**
		 * Add the new fields.
		 */
		$add = array(
			'password_reset_hash' => array(
				'type' => 'VARCHAR',
				'constraint' => 24,
				'null' => true),
			'temp_password' => array(
				'type' => 'VARCHAR',
				'constraint' => 81,
				'null' => true),
			'remember_me' => array(
				'type' => 'VARCHAR',
				'constraint' => 24,
				'null' => true),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => 16,
				'null' => true),
		);
		\DBUtil::add_fields('users', $add);
		
		/**
		 * Update the schema with all the changes.
		 */
		$fields = array(
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
				'default' => 'pending'),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 96),
		);
		\DBUtil::modify_fields('users', $fields);

		/**
		 * Remove the fields that shouldn't be there.
		 */
		\DBUtil::drop_fields('users', 'security_question');
		\DBUtil::drop_fields('users', 'security_answer');

		// get all the users from the nova 2 table
		$users = \DB::query("SELECT * FROM `nova2_users`")->execute();

		if (count($users) > 0)
		{
			foreach ($users as $u)
			{
				/**
				 * Update the user.
				 */
				\Model_User::update_user($u['userid'], array(
					'status' => $u['status'],
					'role_id' => ($u['status'] == 'pending' or $u['status'] == 'inactive') 
						? \Model_Access_Role::USER 
						: \Model_Access_Role::ACTIVE,
				));

				/**
				 * User Preferences
				 */
				// create the initial preferences
				\Model_User_Preferences::create_user_preferences($u['userid']);

				// now change the data
				$data = array(
					'is_sysadmin' => ($u['is_sysadmin'] == 'y') ? (int) true : (int) false,
					'is_game_master' => ($u['is_game_master'] == 'y') ? (int) true : (int) false,
					'loa' => $u['loa'],
				);
				\Model_User_Preferences::update_user_preferences($u['userid'], $data);

				/**
				 * User Moderation
				 */
				if ($u['moderate_posts'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'posts',
						'date' => time()
					));
				}
				
				if ($u['moderate_logs'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'logs',
						'date' => time()
					));
				}
				
				if ($u['moderate_news'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'news',
						'date' => time()
					));
				}
				
				if ($u['moderate_post_comments'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'post_comments',
						'date' => time()
					));
				}
				
				if ($u['moderate_log_comments'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'log_comments',
						'date' => time()
					));
				}
				
				if ($u['moderate_news_comments'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'news_comments',
						'date' => time()
					));
				}
				
				if ($u['moderate_wiki_comments'] == 'y')
				{
					\Model_Moderation::create_item(array(
						'user_id' => $u['userid'],
						'character_id' => 0,
						'type' => 'wiki_comments',
						'date' => time()
					));
				}
			}
		}

		\DBUtil::drop_fields('users', array(
			'date_of_birth',
			'is_sysadmin',
			'is_game_master',
			'is_webmaster',
			'is_firstlaunch',
			'timezone',
			'daylight_savings',
			'language',
			'loa',
			'display_rank',
			'skin_main',
			'skin_admin',
			'skin_wiki',
			'password_reset',
			'my_links',
			'location',
			'interests',
			'bio',
			'moderate_posts',
			'moderate_logs',
			'moderate_news',
			'moderate_post_comments',
			'moderate_log_comments',
			'moderate_news_comments',
			'moderate_wiki_comments',
			'instant_message',
		));
		
		// get the user count
		$count_new = \Model_User::count();
		
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
		
		return $retval;
	}
}
