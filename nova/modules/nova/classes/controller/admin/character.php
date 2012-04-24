<?php
/**
 * Nova's characters admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Character extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	public function action_edit($id = false)
	{
		\Sentry::allowed('character.edit', true);

		$this->_view = 'admin/character/edit';
		$this->_js_view = 'admin/character/edit_js';

		// get the user object
		$user = \Sentry::user();

		if ( ! $id)
		{
			if (count($user->characters) > 1)
			{
				foreach ($user->characters as $c)
				{
					$this->_data->characters[] = $c;
				}

				// manually set the header, footer, and message
				$this->_headers['edit'] = lang('action.choose character to action.edit', 2);
				$this->_titles['edit'] = lang('action.choose character to action.edit', 2);
				$this->_messages['edit'] = false;
			}
			else
			{
				// set the ID
				$id = $user->character_id;

				# TODO: is the user allowed to edit this character?

				// get the character
				$this->_data->character = \Model_Character::find($id);

				// manually set the header, footer, and message
				$this->_headers['edit'] = lang('action.edit character', 2).' '.lang('{{ - '.$this->_data->character->name(false).'}}');
				$this->_titles['edit'] = lang('action.edit character', 2);
				$this->_messages['edit'] = false;
			}
		}

		// render the dynamic form
		$this->_data->form = \NovaForm::build('bio', $this->skin, $id);

		// set up the images
		$this->_data->images = array(
			'action' => \Location::image($this->images['settings'], $this->skin, 'admin'),
		);

		return;
	}
}
