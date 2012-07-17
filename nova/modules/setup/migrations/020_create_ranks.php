<?php

namespace Fuel\Migrations;

class Create_ranks
{
	public function up()
	{
		// load the nova config file
		\Config::load('nova', 'nova');

		// get the genre
		$genre = \Config::get('nova.genre');

		\DBUtil::create_table('ranks_'.$genre, array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'info_id' => array('type' => 'INT', 'constraint' => 11),
			'set_id' => array('type' => 'INT', 'constraint' => 11),
			'base' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'pip' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
		), array('id'));

		\DBUtil::create_table('rank_info_'.$genre, array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'short_name' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'group' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));

		\DBUtil::create_table('rank_sets_'.$genre, array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
		), array('id'));

		include NOVAPATH.'setup/assets/install/genres/'.strtolower($genre).'.php';
		
		foreach ($sets as $value)
		{
			\DB::insert('rank_sets_'.$genre)->set($value)->execute();
		}

		foreach ($info as $value)
		{
			\DB::insert('rank_info_'.$genre)->set($value)->execute();
		}

		foreach ($ranks as $value)
		{
			\DB::insert('ranks_'.$genre)->set($value)->execute();
		}
	}

	public function down()
	{
		// load the nova config file
		\Config::load('nova', 'nova');

		// get the genre
		$genre = \Config::get('nova.genre');
		
		\DBUtil::drop_table('ranks_'.$genre);
		\DBUtil::drop_table('rank_info_'.$genre);
		\DBUtil::drop_table('rank_sets_'.$genre);
	}
}