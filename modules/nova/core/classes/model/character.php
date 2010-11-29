<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Character extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'charid'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'user',
				'foreign' => 'user'
			)),
			'fname' => Jelly::field('string', array(
				'column' => 'first_name',
			)),
			'mname' => Jelly::field('string', array(
				'column' => 'middle_name',
			)),
			'lname' => Jelly::field('string', array(
				'column' => 'last_name',
			)),
			'suffix' => Jelly::field('string', array(
				'column' => 'suffix'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'status',
				'choices' => array('active','inactive','pending','archived'),
				'default' => 'pending'
			)),
			'activate' => Jelly::field('timestamp', array(
				'column' => 'date_activate',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'deactivate' => Jelly::field('timestamp', array(
				'column' => 'date_deactivate',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'rank' => Jelly::field('belongsto', array(
				'column' => 'rank',
				'foreign' => 'rank'
			)),
			'position1' => Jelly::field('belongsto', array(
				'column' => 'position_1',
				'foreign' => 'position'
			)),
			'position2' => Jelly::field('belongsto', array(
				'column' => 'position_2',
				'foreign' => 'position'
			)),
			'last_post' => Jelly::field('timestamp', array(
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'last_update' => Jelly::field('timestamp', array(
				'auto_now_create' => false,
				'auto_now_update' => true,
				'null' => true,
				'default' => date::now()
			))
		));
	}
	
	/**
	 * Prints out the name of the character name
	 *
	 * @param	boolean	whether to print the rank
	 * @param	boolean	whether to use the short rank name
	 * @param	boolean	whether to show the middle name
	 * @return 	string	the character name
	 */
	public function print_name($rank = true, $shortrank = false, $mname = false)
	{
		$array = array(
			($rank === true)
				? ($shortrank === true) ? $this->rank->shortname : $this->rank->name
				: false,
			$this->fname,
			($mname === true) ? $this->mname : false,
			$this->lname,
		);
		
		foreach ($array as $key => $value)
		{
			if (empty($value))
			{
				unset($array[$key]);
			}
		}
		
		return implode(' ', $array);
	}
}