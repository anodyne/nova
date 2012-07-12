<?php

namespace Fuel\Migrations;

class Create_site_contents
{
	public function up()
	{
		\DBUtil::create_table('site_contents', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'key' => array('type' => 'VARCHAR', 'constraint' => 255),
			'label' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'content' => array('type' => 'TEXT', 'null' => true),
			'type' => array('type' => 'ENUM', 'constraint' => "'title','header','message','other'", 'default' => 'message'),
			'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		), array('id'));

		$data = array(
			/**
			 * Headers
			 */
			array(
				'key' => 'login_index_header',
				'label' => 'Login Header',
				'content' => "Log In",
				'type' => 'header',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_header',
				'label' => 'Reset Password Header',
				'content' => "Reset Password",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_header',
				'label' => 'Confirm Reset Password Header',
				'content' => "Confirm Password Reset",
				'type' => 'header',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_header',
				'label' => 'Logout Header',
				'content' => "Logout",
				'type' => 'header',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_header',
				'label' => 'Main Page Header',
				'content' => "Welcome to Nova!",
				'type' => 'header',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_header',
				'label' => 'Site Credits Header',
				'content' => 'Site Credits',
				'type' => 'header',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_header',
				'label' => 'Join Header',
				'content' => 'Join',
				'type' => 'header',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_header',
				'label' => 'Sim Header',
				'content' => "The Sim",
				'type' => 'header',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_header',
				'label' => 'ACP Header',
				'content' => "Control Panel",
				'type' => 'header',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_header',
				'label' => 'Form Management Header',
				'content' => "Forms",
				'type' => 'header',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_header',
				'label' => 'Form Field Management Header',
				'content' => "Manage Form Fields",
				'type' => 'header',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_header',
				'label' => 'Form Section Management Header',
				'content' => "Manage Form Sections",
				'type' => 'header',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_header',
				'label' => 'Form Tab Management Header',
				'content' => "Manage Form Tabs",
				'type' => 'header',
				'section' => 'form',
				'page' => 'tabs'),

			/**
			 * Page Titles
			 */
			array(
				'key' => 'login_index_title',
				'label' => 'Login Page Title',
				'content' => "Log In",
				'type' => 'title',
				'section' => 'login',
				'page' => 'index'),
			array(
				'key' => 'login_reset_title',
				'label' => 'Reset Password Page Title',
				'content' => "Reset Password",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset'),
			array(
				'key' => 'login_reset_confirm_title',
				'label' => 'Confirm Reset Password Page Title',
				'content' => "Confirm Password Reset",
				'type' => 'title',
				'section' => 'login',
				'page' => 'reset_confirm'),
			array(
				'key' => 'login_logout_title',
				'label' => 'Logout Page Title',
				'content' => "Logout",
				'type' => 'title',
				'section' => 'login',
				'page' => 'logout'),
			array(
				'key' => 'main_index_title',
				'label' => 'Main Page Title',
				'content' => "Welcome to Nova!",
				'type' => 'title',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_title',
				'label' => 'Site Credits Page Title',
				'content' => 'Site Credits',
				'type' => 'title',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_title',
				'label' => 'Join Page Title',
				'content' => 'Join',
				'type' => 'title',
				'section' => 'main',
				'page' => 'join'),
			array(
				'key' => 'sim_index_title',
				'label' => 'Sim Page Title',
				'content' => "The Sim",
				'type' => 'title',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_title',
				'label' => 'ACP Page Title',
				'content' => "Control Panel",
				'type' => 'title',
				'section' => 'admin',
				'page' => 'index'),
			array(
				'key' => 'admin_form_index_title',
				'label' => 'Form Management Page Title',
				'content' => "Forms",
				'type' => 'title',
				'section' => 'form',
				'page' => 'index'),
			array(
				'key' => 'admin_form_fields_title',
				'label' => 'Form Field Management Page Title',
				'content' => "Manage Form Fields",
				'type' => 'title',
				'section' => 'form',
				'page' => 'fields'),
			array(
				'key' => 'admin_form_sections_title',
				'label' => 'Form Section Management Page Title',
				'content' => "Manage Form Sections",
				'type' => 'title',
				'section' => 'form',
				'page' => 'sections'),
			array(
				'key' => 'admin_form_tabs_title',
				'label' => 'Form Tab Management Page Title',
				'content' => "Manage Form Tabs",
				'type' => 'title',
				'section' => 'form',
				'page' => 'tabs'),

			/**
			 * Messages
			 */
			array(
				'key' => 'login_reset_message',
				'label' => 'Reset Password Message',
				'content' => "To reset your password, simply enter your email address and a new password. You'll receive an email shortly with a link to confirm your password reset. If you log in to the site before confirming your password reset, the reset will be cancelled.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset',
				'protected' => (int) true),
			array(
				'key' => 'login_reset_confirm_message',
				'label' => 'Confirm Reset Password Message',
				'content' => "The second step of the password reset process is confirmation. In order to complete your password reset, click the button below. Your password will be changed to the one you chose. If you did not request a password reset, you can simply log in to the site to cancel the reset request.",
				'type' => 'message',
				'section' => 'login',
				'page' => 'reset_confirm',
				'protected' => (int) true),
			array(
				'key' => 'main_index_message',
				'label' => 'Main Page Message',
				'content' => "Define your welcome message and welcome page header through the Site Content page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'index'),
			array(
				'key' => 'main_credits_message',
				'label' => 'Credits',
				'content' => "Define your site credits through the Site Messages page.",
				'type' => 'message',
				'section' => 'main',
				'page' => 'credits'),
			array(
				'key' => 'main_join_message',
				'label' => 'Join Message',
				'content' => "Define your join message through the Site Messages page.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'main_join_coppa_message',
				'label' => 'COPPA Message',
				'content' => "Members are expected to follow the rules and regulations of both the game and game's organization at all times, both in character and out of character. By continuing, you affirm you will play in a proper and adequate manner. In compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), players under the age of 13 will not be accepted and any player found to be under the age of 13 will be removed immediately and without question.",
				'type' => 'message',
				'section' => '',
				'page' => ''),
			array(
				'key' => 'sim_index_message',
				'label' => 'Sim Message',
				'content' => "Define your sim message through the Site Content page.",
				'type' => 'message',
				'section' => 'sim',
				'page' => 'index'),
			array(
				'key' => 'admin_index_message',
				'label' => 'ACP Message',
				'content' => "Define your admin control panel through the Site Content page.",
				'type' => 'message',
				'section' => 'admin',
				'page' => 'index'),

			/**
			 * Other Messages
			 */
			array(
				'key' => 'credits_perm',
				'label' => 'Permanent Credits',
				'content' => "The Nova 3 experience can be summed up as \"smarter and better\". From the top down, Nova is faster, simpler, more flexible, and smarter than before. This is accomplished in no small part by the simple, flexible, and elegant PHP 5.3 foundation of <a href='http://fuelphp.com/' target='_blank'>FuelPHP</a>. The icons found throughout Nova are the tireless work of <a href='http://p.yusukekamiyamane.com/' target='_blank'>Yusuke Kamiyamane</a> (Fugue), <a href='http://pictos.cc' target='_blank'>Drew Wilson</a> (Pictos), and <a href='http://glyphicons.com/' target='_blank'>Jan Kovařík</a> (Glyphicons).",
				'protected' => (int) true,
				'type' => 'other'),
			array(
				'key' => 'footer',
				'label' => 'Additional Footer Information',
				'content' => "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
				'type' => 'other'),
			array(
				'key' => 'join_disclaimer',
				'label' => 'Join Disclaimer',
				'content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
				'type' => 'other'),
			array(
				'key' => 'join_post',
				'label' => 'Join Sample Post',
				'content' => "Define your join sample post through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'accept_message',
				'label' => 'User Acceptance Email',
				'content' => "Define your user acceptance message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'reject_message',
				'label' => 'User Rejection Message',
				'content' => "Define your user rejection message through the Site Content page.",
				'type' => 'other'),
			array(
				'key' => 'join_character_help',
				'label' => 'Join Character Help',
				'content' => "__Tips for a good character application:__

* Be specific. You can give too little information, but you can never give too much.
* Be unique. No one likes interacting with a character that can do everything perfectly. Look for ways to make your character unique and to give them shortcomings and weaknesses.",
				'type' => 'other'),
		);

		foreach ($data as $value)
		{
			\DB::insert('site_contents')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('site_contents');
	}
}