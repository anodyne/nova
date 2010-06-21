<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Pages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Accesspage extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_pages');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'page_id'
			)),
			'name' => new Field_String(array(
				'column' => 'page_name'
			)),
			'link' => new Field_String(array(
				'column' => 'page_url'
			)),
			'level' => new Field_String(array(
				'column' => 'page_level'
			)),
			'group' => new Field_BelongsTo(array(
				'column' => 'page_group',
				'foreign' => 'accessgroup'
			)),
			'desc' => new Field_Text(array(
				'column' => 'page_desc'
			)),
		));
	}
}