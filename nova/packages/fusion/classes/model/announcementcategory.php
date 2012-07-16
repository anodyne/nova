<?php
/**
 * Announcement Categories Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_AnnouncementCategory extends \Model {
	
	public static $_table_name = 'announcement_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	public static $_has_many = array(
		'newsitems' => array(
			'model_to' => '\\Model_Announcement',
			'key_to' => 'category_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
