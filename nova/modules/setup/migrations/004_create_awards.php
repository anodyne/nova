<?php

namespace Fuel\Migrations;

class Create_awards
{
	public function up()
	{
		\DBUtil::create_table('awards', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'category_id' => array('type' => 'INT', 'constraint' => 11, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'type' => array('type' => 'ENUM', 'constraint' => "'ic','ooc','both'", 'default' => 'ic'),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
		), array('id'));

		\DBUtil::create_table('award_categories', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
		), array('id'));

		\DBUtil::create_table('award_queue', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
			'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
			'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
			'award_id' => array('type' => 'INT', 'constraint' => 11),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::PENDING),
			'created_at' => array('type' => 'DATETIME'),
		), array('id'));

		\DBUtil::create_table('award_received', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'receive_character_id' => array('type' => 'INT', 'constraint' => 11),
			'receive_user_id' => array('type' => 'INT', 'constraint' => 11),
			'nominate_character_id' => array('type' => 'INT', 'constraint' => 11),
			'award_id' => array('type' => 'INT', 'constraint' => 11),
			'reason' => array('type' => 'TEXT', 'null' => true),
			'created_at' => array('type' => 'DATETIME'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('awards');
		\DBUtil::drop_table('award_categories');
		\DBUtil::drop_table('award_queue');
		\DBUtil::drop_table('award_received');
	}
}