<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Messages Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Nova_Message extends Model
{
	public function get_message($key = '')
	{
		$query = db::select()->from('messages')->where('message_key', '=', $key)->as_object()->execute()->current();
		
		return $query->message_content;
	}
}

// End of file message.php
// Location: modules/nova/classes/model/nova/message.php