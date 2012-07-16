<?php
/**
 * Site Content Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_SiteContent extends \Model {
	
	public static $_table_name = 'site_contents';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 255),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'title','header','message','other'",
			'default' => 'message'),
		'section' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'page' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
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
	 * @api
	 * @param	string	the type of message to pull
	 * @param	string	the section to pull for
	 * @return	array 	an array of values
	 */
	public static function get_section_content($type, $section)
	{
		try
		{
			$cache = \Cache::get('content_'.$type.'_'.$section);
			
			return $cache;
		}
		catch (\CacheNotFoundException $e)
		{
			$query = static::find()
				->where('type', $type)
				->where('section', $section)
				->get();
				
			if (count($query) > 0)
			{
				foreach ($query as $row)
				{
					// set the content as a variable so we can change it
					$content = $row->content;
					
					// find the pattern {{table: key}} in the content
					preg_match_all('/{{([a-zA-Z]+): ([a-zA-Z_-]+)}}/', $content, $arr, PREG_PATTERN_ORDER);
					
					// make sure there were matches
					if (count($arr[0]) > 0)
					{
						// loop through the matches and make the changes
						foreach ($arr[2] as $k => $v)
						{
							// get the item from the settings table
							$replace = \Model_Settings::get_settings($v);
							
							// set the new content
							$content = str_replace($arr[0][$k], $replace, $content);
						}
					}
					
					// set the items with the content
					$array[$row->page] = $content;
				}
				
				// cache the information
				\Cache::set('content_'.$type.'_'.$section, $array);
				
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
	public static function update_site_content(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::find()->where('key', $key)->get_one();
			
			// track what we need to clear and re-cache
			$clear[$record->section][] = $record->type;
			
			$record->content = $value;
			$record->save();
		}
		
		foreach ($clear as $section => $type)
		{
			foreach ($type as $t)
			{
				// delete the cache
				\Cache::delete('content_'.$t.'_'.$section);
				
				// now grab that content again (which will automatically re-cache everything)
				static::get_section_content($t, $section);
			}
		}
	}
	
	private static function _substitute($content)
	{
		preg_match_all('/{{([a-zA-Z]+): ([a-zA-Z_-]+)}}/', $content, $arr, PREG_PATTERN_ORDER);
	}
}
