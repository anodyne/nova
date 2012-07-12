<?php

namespace Fuel\Migrations;

class Create_characters
{
	public function up()
	{
		\DBUtil::create_table('characters', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'first_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'middle_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'last_name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'suffix' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','pending','archived'", 'default' => 'pending'),
			'activated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'deactivated' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'rank_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
			'last_post' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'updated_at' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
		), array('id'));

		\DBUtil::create_table('character_images', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'image' => array('type' => 'TEXT', 'null' => true),
			'primary_image' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'created_by' => array('type' => 'INT', 'constraint' => 11),
			'created_at' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));

		\DBUtil::create_table('character_positions', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'position_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'primary' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		), array('id'));

		\DBUtil::create_table('character_promotions', array(
			'id' => array('type' => 'BIGINT', 'constraint' => 20, 'auto_increment' => true),
			'user_id' => array('type' => 'INT', 'constraint' => 11),
			'character_id' => array('type' => 'INT', 'constraint' => 11),
			'old_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'old_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'new_order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'new_rank' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'date' => array('type' => 'BIGINT', 'constraint' => 20),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('characters');
		\DBUtil::drop_table('character_images');
		\DBUtil::drop_table('character_positions');
		\DBUtil::drop_table('character_promotions');
	}
}