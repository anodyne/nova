<?php

namespace Fuel\Migrations;

class Create_catalogs
{
	public function up()
	{
		\DBUtil::create_table('catalog_modules', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'short_name' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'protected' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'credits' => array('type' => 'TEXT', 'null' => true),
		), array('id'));

		\DBUtil::create_table('catalog_ranks', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'preview.png'),
			'blank' => array('type' => 'VARCHAR', 'constraint' => 50, 'default' => 'blank.png'),
			'extension' => array('type' => 'VARCHAR', 'constraint' => 5, 'default' => '.png'),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'credits' => array('type' => 'TEXT'),
			'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
			'genre' => array('type' => 'VARCHAR', 'constraint' => 10, 'default' => '', 'null' => true),
		), array('id'));

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

		\DBUtil::create_table('catalog_skinsecs', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'section' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'skin' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'preview' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
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

		\DBUtil::create_table('catalog_widgets', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'location' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => true),
			'page' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => true),
			'zone' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'credits' => array('type' => 'TEXT', 'null' => true),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('catalog_modules');
		\DBUtil::drop_table('catalog_ranks');
		\DBUtil::drop_table('catalog_skins');
		\DBUtil::drop_table('catalog_skinsecs');
		\DBUtil::drop_table('catalog_widgets');
	}
}