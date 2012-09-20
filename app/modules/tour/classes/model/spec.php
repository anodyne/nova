<?php
/**
 * Specs Model
 *
 * @package		Nova
 * @subpackage	Tour
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Tour;

class Model_Spec extends \Model {
	
	public static $_table_name = 'specs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'images' => array(
			'type' => 'text',
			'null' => true),
		'summary' => array(
			'type' => 'text',
			'null' => true),
	);
	
	public static $_has_many = array(
		'tour' => array(
			'model_to' => '\\Model_Tour',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'decks' => array(
			'model_to' => '\\Model_TourDeck',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function get_items()
	{
		return static::find('all');
	}
	
	/**
	 * Create a spec item.
	 *
	 * @api
	 * @param	mixed	an array or object of data
	 * @return	object
	 */
	public static function create_spec($data)
	{
		$item = static::createItem($data);
		
		/**
		 * Fill the rows for the dynamic form with blank data for editing later.
		 */
		$fields = \Model_Form_Field::getItems('specs');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				$field_data = array(
					'form_key' => 'specs',
					'field_id' => $f->id,
					'user_id' => 0,
					'character_id' => 0,
					'item_id' => $item->id,
					'value' => '',
					'updated_at' => \Carbon::now('UTC')->toDateTimeString(),
				);
				
				\Model_Form_Data::createData($field_data);
			}
		}
		
		return $item;
	}
}
