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

class Controller_Ajax_Update extends \Controller
{
	public function before()
	{
		parent::before();

		// manually add the nova module to the paths
		\Finder::instance()->add_path(\Fuel::add_module('nova'));
		
		// go out and load then merge the nova config files
		\Config::load('nova', true, false, true);

		// load the language files
		\Lang::load('app');
		\Lang::load('nova::base');
		\Lang::load('nova::event', 'event');
		\Lang::load('nova::email', 'email');
		\Lang::load('nova::action', 'action');
		\Lang::load('nova::short', 'short');
		\Lang::load('nova::status', 'status');
	}
	
	public function after($response)
	{
		parent::after($response);
		
		// return the response object
		return $this->response;
	}

	public function action_content_save()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('content.update'))
		{
			// get the POST information
			$key = trim(\Security::xss_clean(\Input::post('key')));
			$value = trim(\Security::xss_clean(\Input::post('value')));

			// break the key up into an array
			$pieces = explode('_', $key);

			// flip the array around
			$pieces = array_reverse($pieces);

			// make sure we don't have any tags in the headers
			$content = ($pieces[0] == 'header') ? strip_tags(\Markdown::parse($value)) : $value;

			// save the content
			\Model_SiteContent::update_site_content(array($key => $content));

			// if it's a header, show the content, otherwise we need to parse the Markdown
			if ($pieces[0] == 'header')
			{
				echo $content;
			}
			else
			{
				echo \Markdown::parse($content);
			}
		}
	}

	public function action_form($key = '')
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the form
			$form = \Model_Form::get_form($key);

			if ($form !== false)
			{
				$data = array(
					'name' => $form->name,
					'orientation' => $form->orientation,
					'id' => $form->id,

					'values' => array(
						'vertical' => ucfirst(__('vertical')),
						'horizontal' => ucfirst(__('horizontal'))
					),
				);

				echo \View::forge(\Location::file('update/form', 'default', 'ajax'), $data);
			}
		}
	}

	/**
	 * Protected methods for outputting information.
	 */
	
	protected function _flash_success($item)
	{
		return '<p class="alert alert-success">'.__('short.flash_success', array('thing' => ucfirst(__($item)))).'</p>';
	}

	protected function _modal_close()
	{
		return '<div class="form-actions"><button class="close-dialog">'.ucfirst(__('action.close')).'</button></div>';
	}
}
