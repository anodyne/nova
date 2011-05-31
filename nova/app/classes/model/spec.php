<?php
/**
 * Specs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Spec extends Model {
	
	public static $_table_name = 'specs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'images' => array(
			'type' => 'text'),
		'summary' => array(
			'type' => 'text'),
	);
	
	public static $_has_many = array(
		'tour' => array(
			'model_to' => 'Model_Tour',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'decks' => array(
			'model_to' => 'Model_TourDeck',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Create a spec item.
	 *
	 *     Model_Spec::create_item($data);
	 *
	 * @access	public
	 * @param	mixed	an array or object of data
	 * @return	object	the newly created item
	 */
	public static function create_item($data)
	{
		$item = static::create_item($data);
		
		/**
		 * Fill the rows for the dynamic form with blank data for editing later.
		 */
		$fields = Model_FormField::get_fields('specs');
		
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
					'updated_at' => Date::now(),
				);
				
				Model_FormData::create_data($field_data);
			}
		}
		
		return $item;
	}
}
