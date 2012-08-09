<?php
/**
 * Nova's main section controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;

# TODO: need to take in to account COPPA when building links for applying for a position

abstract class Controller_Personnel extends Controller_Base_Main
{
	public function before()
	{
		parent::before();

		if ($this->_section_info->nav == 'classic')
		{
			$this->template->layout->navsub->classic = \Nav::display('classic', 'sub', 'personnel');
		}
	}
	
	public function action_index()
	{
		return;
	}

	public function action_character($id)
	{
		$this->_view = 'personnel/character';
		$this->_js_view = 'personnel/character_js';

		// get the character form
		$this->_data->characterForm = \NovaForm::build('character', $this->skin, $id, false);
	}
}
