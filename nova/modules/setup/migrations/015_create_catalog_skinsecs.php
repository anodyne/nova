<?php

namespace Fuel\Migrations;

class Create_catalog_skinsecs
{
	public function up()
	{
		\DBUtil::create_table('catalog_skinsecs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'skin' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'status' => array('type' => 'ENUM', 'constraint' => "'active','inactive','development'", 'default' => 'active'),
			'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'nav' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'dropdown'),
		), array('id'));

		$data = array(
			array(
				'section' => 'main',
				'skin' => 'default',
				'preview' => 'preview-main.jpg',
				'default' => (int) true),
			array(
				'section' => 'login',
				'skin' => 'default',
				'preview' => 'preview-login.jpg',
				'default' => (int) true),
			array(
				'section' => 'admin',
				'skin' => 'default',
				'preview' => 'preview-admin.jpg',
				'default' => (int) true),
		);

		foreach ($data as $value)
		{
			\DB::insert('catalog_skinsecs')->set($value)->execute();
		}
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_skinsecs');
	}
}