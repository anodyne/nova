<?php
/**
 * Site Content Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_SiteContent extends Model {
	
	public static $_table_name = 'site_contents';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'content' => array(
			'type' => 'text'),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'title','message','other'",
			'default' => 'message'),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);
	
	/**
	 * Get a specific message from the database.
	 *
	 *     Model_SiteContent::get_message('welcome_msg');
	 *     Model_SiteContent::get_message('welcome_msg', false);
	 *
	 * @access	public
	 * @param	string	the key of the message to get
	 * @param	boolean	whether to pull only the value or the full object
	 * @return	mixed	a string if $value_only is TRUE, else an object
	 */
	public static function get_message($key, $value_only = true)
	{
		$query = static::find()->where('key', $key)->get_one();
		
		if ($value_only === true)
		{
			return $query->content;
		}
		
		return $query;
	}
	
	/**
	 * Update site content.
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 * @access	public
	 * @param	array 	the data array for updating the site content
	 * @return	void
	 */
	public static function update_messages(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::find()->where('key', $key)->get_one();
			$record->content = $value;
			$record->save();
		}
	}
}
