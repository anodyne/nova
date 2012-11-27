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

	public function action_index()
	{
		# code...
	}

	public function action_add()
	{
		# code...
	}
	
	public function action_edit($id = false)
	{
		\Sentry::allowed('character.update', true);

		$this->_view = 'admin/character/edit';
		$this->_js_view = 'admin/character/edit_js';
		$this->_data->skin = $this->skin;

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

				// Manually set the header, footer, and message
				$title = ucwords(lang('action.choose').' '.lang('character').' '.lang('to').' '.lang('action.edit'));
				$this->_headers['edit'] = $this->_titles['edit'] = $title;
				$this->_messages['edit'] = false;
			}
			else
			{
				// set the ID
				$id = $user->character_id;

				// get the character
				$this->_data->character = \Model_Character::find($id);

				// Manually set the header, footer, and message
				$this->_headers['edit'] = $this->_data->character->getName(false).' - '.ucwords(lang('action.edit', lang('character')));
				$this->_titles['edit'] = ucwords(lang('action.edit', lang('character')));
				$this->_messages['edit'] = false;
			}
		}
		else
		{
			// get the character
			$this->_data->character = \Model_Character::find($id);

			# TODO: is the user allowed to edit this character?

			// Manually set the header, footer, and message
			$this->_headers['edit'] = $this->_data->character->getName(false).' - '.ucwords(lang('action.edit', lang('character')));
			$this->_titles['edit'] = lang('action.edit character', 2);
			$this->_messages['edit'] = false;
		}

		// get the form elements
		$tabs = \Model_Form_Tab::getFormItems('character', true);
		$sections = \Model_Form_Section::getFormItems('character', true);
		$fields = \Model_Form_Field::getFormItems('character', true);
		$content = \Model_Form_Data::getData('character', $id);
		$this->_data->form = \Model_Form::getForm('character');

		/**
		 * Tabs
		 */
		if (count($tabs) > 0)
		{
			foreach ($tabs as $tab)
			{
				$this->_data->tabs[] = $tab;
			}
		}

		/**
		 * Sections
		 */
		if (count($sections) > 0)
		{
			foreach ($sections as $section)
			{
				if (count($tabs) > 0)
				{
					$this->_data->sections[$section->tab_id][] = $section;
				}
				else
				{
					$this->_data->sections[] = $section;
				}
			}
		}

		/**
		 * Fields
		 */
		if (count($fields) > 0)
		{
			foreach ($fields as $field)
			{
				if (count($sections) > 0)
				{
					$this->_data->fields[$field->section_id][] = $field;
				}
				else
				{
					$this->_data->fields[] = $field;
				}

				$this->_data->data[$field->id] = '';
			}
		}

		/**
		 * Data
		 */
		if (count($content) > 0)
		{
			foreach ($content as $c)
			{
				if (array_key_exists($c->field_id, $data->data))
				{
					$this->_data->data[$c->field_id] = $c->value;
				}
			}
		}

		// set up the images
		$this->_data->images = array(
			'action' => \Location::image($this->images['settings'], $this->skin, 'admin'),
		);

		return;
	}
}