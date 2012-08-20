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

	public function action_join($position = false)
	{
		if (\Input::method() == 'POST')
		{
			$this->_view = 'main/join';
			$this->_js_view = 'main/join_js';

			// set the js data
			$this->_js_data->skin = $this->skin;

			if (isset($_POST['submit']))
			{
				if (\Security::check_token())
				{
					if (\Input::post('user.id') == '0')
					{
						// create the user
						$user = \Model_User::create_item(\Input::post('user'), true);

						// make sure the user ID is associated with the character
						$_POST['character']['user_id'] = $user->id;
					}
					else
					{
						// make sure the user ID is associated with the character
						$_POST['character']['user_id'] = \Input::post('user.id');

						// get the user
						$user = \Model_User::find(\Input::post('user.id'));
					}

					// create the character
					$char = \Model_Character::create_item(\Input::post('character'), true);

					// insert the position info
					\Model_Character_Positions::create_item(array(
						'position_id' => (int) \Security::xss_clean(\Input::post('position')),
						'character_id' => $char->id,
						'primary' => (\Input::post('user.id') == '0') ? (int) false : (int) true
					));

					// update the user with the character info if it's a new user
					if (\Input::post('user.id') == '0')
					{
						\Model_User::update_item($user->id, array('character_id' => $char->id));
					}

					// create the application
					$createApp = \Model_Application::create_item(array(
						'email' 			=> $user->email,
						'ip_address' 		=> \Input::real_ip(),
						'user_id' 			=> $user->id,
						'user_name' 		=> $user->name,
						'character_id' 		=> $char->id,
						'character_name'	=> $char->name(false, false),
						'position_id' 		=> (int) \Security::xss_clean(\Input::post('position')),
						'sample_post' 		=> \Security::xss_clean(\Input::post('sample_post')),
					), true);

					// remove unnecessary items from the POST data
					unset($_POST['submit']);
					unset($_POST['user']);
					unset($_POST['character']);
					unset($_POST['sample_post']);
					unset($_POST['position']);
					unset($_POST[\Config::get('security.csrf_token_key')]);

					// dump the data into the table
					foreach (\Input::post() as $field => $value)
					{
						// get the form key
						$form_key = \Model_Form_Field::find($field)->form_key;

						// insert the data
						\Model_Form_Data::create_data(array(
							'field_id'		=> $field,
							'value'			=> $value,
							'user_id'		=> $user->id,
							'character_id'	=> $char->id,
							'item_id'		=> ($form_key == 'app') ? $createApp->id : 0,
							'form_key'		=> $form_key
						));
					}

					// set the flash message
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|application|action.submitted]]', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('error.csrf'),
					);
				}
			}

			// set the content manually
			$this->_data->message = \Model_SiteContent::get_content('main_join_message');

			// build the character form
			$this->_data->character = \NovaForm::build('character', $this->skin);

			// build the user form (populate with data if the user is logged in)
			$this->_data->user = \NovaForm::build('user', $this->skin, ((\Sentry::check()) ? \Sentry::user()->id : false));

			// build the app form (populate with data if the user is logged in)
			$this->_data->appForm = \NovaForm::build('app', $this->skin, ((\Sentry::check()) ? \Sentry::user()->id : false));

			// pass the position along
			$this->_data->position = $position;

			// set the character join help
			$this->_data->characterJoinHelp = \Markdown::parse(\Model_SiteContent::get_content('join_character_help'));

			// get the sample post content
			$this->_data->samplePostContent = \Model_SiteContent::get_content('join_sample_post');
		}
		else
		{
			$this->_view = 'main/join_coppa';

			// set the content manually
			$this->_data->message = \Model_SiteContent::get_content('main_join_coppa_message');
		}

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
		/*$groups = \Model_Rank_Group::find('all');

		foreach ($groups as $g)
		{
			echo '<div class="container">';
			echo '<h2>'.$g->name.'</h2>';

			echo '<table class="table table-striped">';

			foreach ($g->ranks as $r)
			{
				echo '<tr><td width="300">'.$r->info->name.'</td><td>'.\Location::rank($r->base, $r->pip).'</td></tr>';
			}

			echo '</table></div>';
		}*/
		/*
		//$originalData = array('position' => array(2), 'user' => array(22, 91, 31));
		$originalData = array('position' => array(2));

		$dataAsJson = \Format::forge($originalData)->to_json();

		$dataAsArray = \Format::forge($dataAsJson, 'json')->to_array();

		$dataAsObj = json_decode($dataAsJson);

		\Debug::dump(
			$originalData,
			$dataAsJson,
			$dataAsArray,
			$dataAsObj,
			$dataAsObj->position[0]
		);*/
		
		//\Debug::dump(\Model_User::find_users());
		
		$rev1 = \Model_User::find(1)->appReviews;
		$rev2 = \Model_User::query()->related('appReviews')
			->where('appReviews.status', \Status::IN_PROGRESS)
			->get();

			$user = \Model_User::find(1);
			$password = \Str::random();

		\Debug::dump(
			'WKbgCCYvFb6rhPDp',
			\Sentry_User::password_generate('WKbgCCYvFb6rhPDp'),
			\Sentry::user()->atleast_level('user.read', 1)
		);
		
		return;
	}
}
