<?php
/**
 * Nova's main section controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;

abstract class Controller_Main extends Controller_Base_Main
{
	public function before()
	{
		parent::before();

		if ($this->_section_info->nav == 'classic')
		{
			$this->template->layout->navsub->classic = \Nav::display('classic', 'sub', 'main');
		}
	}
	
	public function action_index()
	{
		return;
	}

	public function action_credits()
	{
		$this->_view = 'main/credits';

		// load the credits
		$credits = \Model_SiteContent::get_content('credits_perm');
		$credits.= "\r\n\r\n".$this->_section_info->skins->credits;
		$credits.= "\r\n\r\nRank credits go here";

		// send the credits to the page
		$this->_data->perm_credits = \Markdown::parse($credits);

		return;
	}

	/**
	 * The 404 page indicates that a page could not be found.
	 *
	 * @return	void
	 */
	public function action_404()
	{
		$this->_status = 404;
		
		$headers = array(
			0 => 'Aw, crap!',
			1 => 'Bloody Hell!',
			2 => 'Uh Oh!',
			3 => 'Nope, not here.',
			4 => 'Huh?',
			5 => 'Doh!',
			6 => 'What have you done?!',
			7 => 'Congratulations, you broke the Internet',
			8 => '404\'d',
			9 => 'Error 404: Page Not Found',
			10 => '404 Error',
			11 => '202 + 202 = 404',
			12 => 'Bummer!',
			13 => 'Page Not Found',
		);
		
		$messages = array(
			0 => "Looks like what you're trying to find isn't here. It was probably moved, or sucked in to a black hole. Chin up.",
			1 => "The rabbits have been nibbling on the cables again.",
			2 => "You seem to have stumbled off the beaten path. Perhaps you should try again.",
			3 => "That file ain't there. Kind of pathetic, really.",
			4 => "Dear Happy Internet Traveler,\r\n\r\nDespite that song in your step and sense of purpose, you've hit a little bump in the road. These things happen, but go ahead and try again.",
			5 => "We lost that page. Try again.",
			6 => "I take my eye off you for one minute and this is where I find you?! Come on!",
			7 => "The page you're after doesn't exist. Try again.",
			8 => "Boy, you sure are stupid.\r\n\r\nWere you just making up names of files or what? I mean, I've seen some pretend file names in my day, but come on! It's like you're not even trying.",
			9 => "We actually know where the page is. Chuck Norris has it and he decided to keep it.",
			10 => "This is not the page you're looking for.\r\n\r\nMove along...\r\nMove along...",
			11 => "For those who aren't great at math, that means your page couldn't be found. Try again.",
			12 => "aka Error 404\r\n\r\nThe web address you entered is not a functioning page on the site.",
			13 => "We think it may have been murdered.\r\n\r\nProfessor Plum, in the Ball Room, with the Wrench.",
		);
		
		// get a random item
		$rand = array_rand($headers);
		
		// set the content now
		$this->_data->title = '404 - Not Found';
		$this->_data->header = $headers[$rand];
		$this->_data->message = $messages[$rand];

		// the header and message aren't editable here
		$this->_editable = false;
		
		return;
	}

	public function action_test()
	{
		//echo $this->template->layout->navmain_dropdown;

		//\Debug::dump(__('notifications'));
		return;
	}
}
