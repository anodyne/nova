<?php

namespace Fuel\Migrations;

class Create_applications
{
	public function up()
	{
		\DBUtil::create_table('applications', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'email' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'ip_address' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'user_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'character_name' => array('type' => 'TEXT', 'null' => true),
			'position' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'action' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'message' => array('type' => 'TEXT', 'null' => true),
			'experience' => array('type' => 'TEXT', 'null' => true),
			'hear_about' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'hear_about_details' => array('type' => 'TEXT', 'null' => true),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		\DBUtil::create_table('application_responses', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'app_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'content' => array('type' => 'TEXT', 'null' => true),
			'decision' => array('type' => 'TINYINT', 'constraint' => 2),
		), array('id'));

		\DBUtil::create_table('application_reviewers', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'app_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
		), array('id'));

		\DBUtil::create_table('application_rules', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'all'),
			'condition' => array('type' => 'TEXT', 'null' => true),
			'users' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('applications');
		\DBUtil::drop_table('application_responses');
		\DBUtil::drop_table('application_reviewers');
		\DBUtil::drop_table('application_rules');
	}
}