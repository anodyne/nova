<?php

namespace Fuel\Migrations;

class Create_settings
{
	public function up()
	{
		\DBUtil::create_table('settings', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'key' => array('type' => 'VARCHAR', 'constraint' => 100),
			'value' => array('type' => 'TEXT', 'null' => true),
			'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'help' => array('type' => 'TEXT', 'null' => true),
			'user_created' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));

		$data = array(
			array(
				'key' => 'sim_name',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_year',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'sim_type',
				'value' => 2,
				'user_created' => (int) false),
			array(
				'key' => 'maintenance',
				'value' => 'off',
				'help' => "Maintenance mode allows only admins to log in to the system while updates are being applied or other work is being done",
				'user_created' => (int) false),
			array(
				'key' => 'skin_main',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_admin',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'skin_login',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'display_rank',
				'value' => 'default',
				'user_created' => (int) false),
			array(
				'key' => 'system_email',
				'value' => 'on',
				'user_created' => (int) false),
			array(
				'key' => 'email_subject',
				'value' => '',
				'help' => "You can set the email subject prefix for every email that comes from the system. The default is your sim name inside brackets.",
				'user_created' => (int) false),
			array(
				'key' => 'email_name',
				'value' => '',
				'user_created' => (int) false),
			array(
				'key' => 'email_address',
				'value' => '',
				'help' => "To avoid some email services marking emails from Nova as spam, use this email address to set a specific address. This defaults to an address that should prevent this issue.",
				'user_created' => (int) false),
			array(
				'key' => 'timezone',
				'value' => 'UTC',
				'user_created' => (int) false),
			array(
				'key' => 'daylight_savings',
				'value' => 'false',
				'user_created' => (int) false),
			array(
				'key' => 'date_format',
				'value' => '%d %B %Y',
				'user_created' => (int) false),
			array(
				'key' => 'updates',
				'value' => '4',
				'user_created' => (int) false),
			array(
				'key' => 'post_count_format',
				'value' => 'multiple',
				'help' => "Posts can be counted in two ways: one post no matter how many authors (single) or a post for each author (multiple)",
				'user_created' => (int) false),
			array(
				'key' => 'use_mission_notes',
				'value' => 'y',
				'user_created' => (int) false),
			array(
				'key' => 'online_timespan',
				'value' => '5',
				'help' => "This is used for the Who's Online feature and should be set in minutes. The higher the number, the less accurate the data, but the lower impact it'll have on the server.",
				'user_created' => (int) false),
			array(
				'key' => 'posting_requirement',
				'value' => 14,
				'help' => "The timespan (in days) that a player must post within. Set this to 0 to remove the requirement.",
				'user_created' => (int) false),
			array(
				'key' => 'login_attempts',
				'value' => 5,
				'help' => "The number of times a user can attempt to log in before being locked out. This feature exists to help protect sites against brute-force attacks.",
				'user_created' => (int) false),
			array(
				'key' => 'login_lockout_time',
				'value' => 15,
				'help' => "When a user is locked out because of too many log in attempts, this is the number of minutes they need to wait before logging in again. This goes hand-in-hand with the lockout system to protect against brute-force atatcks.",
				'user_created' => (int) false),
			array(
				'key' => 'meta_description',
				'value' => "Anodyne Productions' premier online RPG management software",
				'user_created' => (int) false),
			array(
				'key' => 'meta_keywords',
				'value' => "nova, rpg management, anodyne, rpg, sms",
				'user_created' => (int) false),
			array(
				'key' => 'meta_author',
				'value' => "Anodyne Productions",
				'user_created' => (int) false),
		);

		foreach ($data as $value)
		{
			\DB::insert('settings')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('settings');
	}
}