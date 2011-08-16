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
			'constraint' => "'title','header','message','other'",
			'default' => 'message'),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'protected' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);
	
	/**
	 * Get a specific piece of content from the database.
	 *
	 *     Model_SiteContent::get_content('welcome_msg');
	 *     Model_SiteContent::get_content('welcome_msg', false);
	 *
	 * @access	public
	 * @param	string	the key of the content to get
	 * @param	boolean	whether to pull only the value or the full object
	 * @return	mixed	a string if $value_only is TRUE, else an object
	 */
	public static function get_content($key, $value_only = true)
	{
		$query = static::find()->where('key', $key)->get_one();
		
		if ($value_only === true)
		{
			return $query->content;
		}
		
		return $query;
	}
	
	/**
	 * Get all of the content for a section from the database.
	 *
	 * @access	public
	 * @param	string	the type of message to pull
	 * @param	string	the section to pull for
	 * @return	array 	an array of values
	 */
	public static function get_section_content($type, $section)
	{
		// get an instance of the cache module
		$cache = Cache::instance();
		
		if ($cache->get('content_'.$type.'_'.$section))
		{
			return $cache->get('content_'.$type.'_'.$section);
		}
		else
		{
			$query = static::find()
				->where('type', $type)
				->where('section', $section)
				->get();
				
			if (count($query) > 0)
			{
				foreach ($query as $row)
				{
					$array[$row->page] = $row->content;
				}
				
				// cache the information
				$cache->set('content_'.$type.'_'.$section, $array);
				
				return $array;
			}
			
			return array();
		}
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
			
			// track what we need to clear and re-cache
			$clear[$record->section][] = $record->type;
			
			$record->content = $value;
			$record->save();
		}
		
		// get an instance of the cache module
		$cache = Cache::instance();
		
		foreach ($clear as $section => $type)
		{
			foreach ($type as $t)
			{
				// delete the cache
				$cache->delete('content_'.$t.'_'.$section);
				
				// now grab that content again (which will automatically re-cache everything)
				static::get_section_content($t, $section);
			}
		}
	}
}
