<?php

namespace Fuel\Migrations;

class Create_positions
{
	public function up()
	{
		\Config::load('nova', 'nova');

		\DBUtil::create_table('positions_'.\Config::get('nova.genre'), array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'dept_id' => array('type' => 'INT', 'constraint' => 11),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'open' => array('type' => 'INT', 'constraint' => 5, 'default' => 1),
			'display' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
			'type' => array('type' => 'ENUM', 'constraint' => "'senior','officer','enlisted','other'", 'default' => 'officer'),
		), array('id'));

		include NOVAPATH.'setup/assets/install/genres/'.strtolower(\Config::get('nova.genre')).'.php';
		
		foreach ($positions as $value)
		{
			\DB::insert('positions_'.\Config::get('nova.genre'))->set($value)->execute();
		}
	}

	public function down()
	{
		\Config::load('nova', 'nova');
		
		\DBUtil::drop_table('positions_'.\Config::get('nova.genre'));
	}
}