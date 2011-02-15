<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth role
 *
 * @package    Kohana/Auth
 * @author     creatoro
 * @copyright  (c) 2011 creatoro
 * @license    http://creativecommons.org/licenses/by-sa/3.0/legalcode
 */
class Model_Auth_Role extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
    {
        // The table the model is attached to
        $meta->table('roles');

        // Fields defined by the model
        $meta->fields(array(
            'id' => Jelly::field('primary'),
            'name' => Jelly::field('string', array(
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4)),
					array('max_length', array(':value', 32)),
				),
				'unique' => TRUE,
			)),
			'description' => Jelly::field('string', array(
				'rules' => array(
					array('max_length', array(':value', 255)),
				),
			)),

            // Relationships to other models
           'users' => Jelly::field('manytomany'),
        ));
    }

} // End Auth Role Model