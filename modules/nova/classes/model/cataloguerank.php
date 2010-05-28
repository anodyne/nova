<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Catalogue Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Cataloguerank extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_ranks');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'rankcat_id'
			)),
			'name' => new Field_String(array(
				'column' => 'rankcat_name'
			)),
			'location' => new Field_String(array(
				'column' => 'rankcat_location',
			)),
			'preview' => new Field_String(array(
				'column' => 'rankcat_preview',
			)),
			'blank' => new Field_String(array(
				'column' => 'rankcat_blank',
			)),
			'extension' => new Field_String(array(
				'column' => 'rankcat_extension',
			)),
			'status' => new Field_Enum(array(
				'column' => 'rankcat_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'credits' => new Field_Text(array(
				'column' => 'rankcat_credits'
			)),
			'url' => new Field_Text(array(
				'column' => 'rankcat_url'
			)),
			'default' => new Field_Enum(array(
				'column' => 'rankcat_default',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'genre' => new Field_String(array(
				'column' => 'rankcat_genre'
			))
		));
	}
}

// End of file rank.php
// Location: modules/nova/classes/model/rank.php