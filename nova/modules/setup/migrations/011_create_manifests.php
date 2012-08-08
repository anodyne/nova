<?php

namespace Fuel\Migrations;

class Create_manifests
{
	public function up()
	{
		\DBUtil::create_table('manifests', array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'VARCHAR', 'constraint' => 255, 'default' => ''),
			'order' => array('type' => 'INT', 'constraint' => 5, 'null' => true),
			'desc' => array('type' => 'TEXT', 'null' => true),
			'header_content' => array('type' => 'TEXT', 'null' => true),
			'status' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => \Status::ACTIVE),
			'default' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 0),
		), array('id'));

		$data = array(
			array(
				'name' => 'Primary Manifest',
				'order' => 0,
				'desc' => "",
				'header_content' => "You can edit the header content of this manifest from Manifest Management...",
				'default' => 1),
		);
	}

	public function down()
	{
		\DBUtil::drop_table('manifests');
	}
}