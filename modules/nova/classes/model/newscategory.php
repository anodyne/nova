<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Categories Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Newscategory extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_categories');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'newscat_id'
			)),
			'name' => new Field_String(array(
				'column' => 'newscat_name'
			)),
			'display' => new Field_Enum(array(
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
		));
	}
}

// End of file newscategory.php
// Location: modules/nova/classes/model/newscategory.php