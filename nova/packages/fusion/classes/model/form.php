<?php
/**
 * Form Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Form extends \Model {
	
	public static $_table_name = 'forms';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'orientation' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'vertical'),
	);

	public static function get_form($key)
	{
		return static::find()->where('key', $key)->get_one();
	}

	public static function get_forms()
	{
		$items = static::find('all');

		$records = array();

		if (count($items) > 0)
		{
			foreach ($items as $item)
			{
				$records[$item->key] = $item->name;
			}
		}

		return $records;
	}
}
