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

class Model_Form extends \Model
{
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

	/**
	 * Get a form by key.
	 *
	 * @api
	 * @param	string	the form key
	 * @return	object
	 */
	public static function getForm($key)
	{
		return static::find()->where('key', $key)->get_one();
	}

	/**
	 * Get all forms.
	 *
	 * @api
	 * @return	array
	 */
	public static function getForms()
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
