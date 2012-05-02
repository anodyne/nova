<?php

namespace Fuel\Migrations;

class Create_ranks
{
	public function up()
	{
		\Config::load('nova', 'nova');

		\DBUtil::create_table('ranks_'.\Config::get('nova.genre'), array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'short_name' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
			'image' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'class' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
		), array('id'));

		include NOVAPATH.'setup/assets/install/genres/'.strtolower(\Config::get('nova.genre')).'.php';
		
		foreach ($ranks as $value)
		{
			\DB::insert('ranks_'.\Config::get('nova.genre'))->set($value)->execute();
		}
	}

	public function down()
	{
		\Config::load('nova', 'nova');
		
		\DBUtil::drop_table('ranks_'.\Config::get('nova.genre'));
	}
}