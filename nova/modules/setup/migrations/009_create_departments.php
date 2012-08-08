<?php

namespace Fuel\Migrations;

class Create_departments
{
	public function up()
	{
		\Config::load('nova', 'nova');

		\DBUtil::create_table('departments_'.\Config::get('nova.genre'), array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'type' => array('type' => 'ENUM', 'constraint' => "'playing','nonplaying'", 'default' => 'playing'),
			'parent_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
			'manifest_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 1),
		), array('id'));

		include NOVAPATH.'setup/assets/install/genres/'.strtolower(\Config::get('nova.genre')).'.php';
		
		foreach ($depts as $value)
		{
			\DB::insert('departments_'.\Config::get('nova.genre'))->set($value)->execute();
		}
	}

	public function down()
	{
		\Config::load('nova', 'nova');
		
		\DBUtil::drop_table('departments_'.\Config::get('nova.genre'));
	}
}