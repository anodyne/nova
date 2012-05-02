<?php

namespace Fuel\Migrations;

class Create_system_info
{
	public function up()
	{
		\DBUtil::create_table('system_info', array(
			'id' => array('type' => 'INT', 'constraint' => 1, 'auto_increment' => true),
			'uid' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => true),
			'install_date' => array('type' => 'BIGINT', 'constraint' => 20),
			'last_update' => array('type' => 'BIGINT', 'constraint' => 20, 'null' => true),
			'version_major' => array('type' => 'INT', 'constraint' => 1, 'default' => 3),
			'version_minor' => array('type' => 'INT', 'constraint' => 2),
			'version_update' => array('type' => 'INT', 'constraint' => 4),
			'version_ignore' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => true),
		), array('id'));

		$data = array(
			array(
				'uid' => \Str::random('alnum', 32),
				'install_date' => time(),
				'version_major' => 3,
				'version_minor' => 0,
				'version_update' => 0)
		);

		foreach ($data as $value)
		{
			\DB::insert('system_info')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('system_info');
	}
}