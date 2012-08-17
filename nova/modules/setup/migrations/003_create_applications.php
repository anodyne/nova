<?php

namespace Fuel\Migrations;

class Create_applications
{
	public function up()
	{
		\DBUtil::create_table('applications', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'position_id' => array('type' => 'INT', 'constraint' => 11),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'sample_post' => array('type' => 'TEXT', 'null' => true),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		\DBUtil::create_table('application_responses', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'app_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'type' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'content' => array('type' => 'TEXT', 'null' => true),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		\DBUtil::create_table('application_reviewers', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'app_id' => array('type' => 'INT', 'constraint' => 11),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
		), array('id'));

		\DBUtil::create_table('application_rules', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'type' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'global'),
			'condition' => array('type' => 'TEXT', 'null' => true),
			'users' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

		$rules = array(
			array(
				'type' => 'global',
				'users' => '{"position":[2]}'),
		);

		foreach ($rules as $r)
		{
			\Model_Application_Rule::create_item($r);
		}
	}

	public function down()
	{
		\DBUtil::drop_table('applications');
		\DBUtil::drop_table('application_responses');
		\DBUtil::drop_table('application_reviewers');
		\DBUtil::drop_table('application_rules');
	}
}