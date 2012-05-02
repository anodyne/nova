<?php

namespace Fuel\Migrations;

class Create_catalog_skins
{
	public function up()
	{
		\DBUtil::create_table('catalog_skins', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'credits' => array('type' => 'TEXT', 'null' => true),
			'version' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => true),
		), array('id'));

		$data = array(
			array(
				'name' => 'Default',
				'location' => 'default',
				'credits' => '',
				'version' => ''),
		);

		foreach ($data as $value)
		{
			\DB::insert('catalog_skins')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_skins');
	}
}