<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Messages Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Message extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'message_id'
			)),
			'key' => new Field_String(array(
				'column' => 'message_key'
			)),
			'value' => new Field_Text(array(
				'column' => 'message_content'
			)),
			'label' => new Field_String(array(
				'column' => 'message_label'
			)),
			'message_type' => new Field_Enum(array(
				'choices' => array('title','message','other'),
				'default' => 'message'
			)),
			'message_protected' => new Field_Enum(array(
				'choices' => array('y','n'),
				'default' => 'n'
			)),
		));
	}
	
	public function get_message($key = '')
	{
		$query = Jelly::select('message')->where('key', '=', $key)->load();
		
		return $query->value;
	}
}

// End of file message.php
// Location: modules/nova/classes/model/message.php