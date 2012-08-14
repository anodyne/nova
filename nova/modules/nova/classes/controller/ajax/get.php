<?php
/**
 * Nova's ajax controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Ajax_Get extends Controller_Base_Ajax
{
	public function action_content_load()
	{
		// get the content key
		$key = \Input::get('key');

		// load and return the content from the database
		echo \Model_SiteContent::get_content($key);
	}

	public function action_user()
	{
		// set the field and values
		$field = false;
		$value = false;

		// loop through the data and set the field and value
		foreach (\Input::post() as $k => $v)
		{
			$field = $k;
			$value = $v;
		}

		// find the user
		$user = \Model_User::find()->where($field, $value)->get_one();

		if ($user)
		{
			echo \Format::forge($user)->to_json();
		}
		else
		{
			echo \Format::forge(array())->to_json();
		}
	}

	public function action_user_form()
	{
		// get the POST data
		$data = \Input::post();

		echo \NovaForm::build(
			'user', 
			\Security::xss_clean(\Input::post('skin')),
			\Security::xss_clean(\Input::post('user'))
		);
	}
}
