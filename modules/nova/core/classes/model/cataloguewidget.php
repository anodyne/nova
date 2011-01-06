<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Widgets Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Cataloguewidget extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_widgets');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'widget_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'widget_name'
			)),
			'location' => Jelly::field('string', array(
				'column' => 'widget_location'
			)),
			'page' => Jelly::field('string', array(
				'column' => 'widget_page'
			)),
			'zone' => Jelly::field('integer', array(
				'column' => 'widget_zone'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'widget_status',
				'choices' => array('active', 'inactive', 'development'),
				'default' => 'active'
			)),
			'credits' => Jelly::field('text', array(
				'column' => 'widget_credits'
			)),
		));
	}
}
