<?php
/**
 * Nova's application admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Application extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	/**
	 * Show a list of the user's currently active application reviews.
	 */
	public function action_index()
	{
		$this->_view = 'admin/arc/index';

		// get the reviews
		$this->_data->reviews = \Sentry::user()->get()->find_app_reviews(\Status::IN_PROGRESS);

		// set up the images
		$this->_data->images = array(
			'rules' => \Location::image($this->images['rules'], $this->skin, 'admin'),
			'clock' => \Location::image($this->images['clock'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Show a list of the history of the user's application reviews. Anyone with
	 * character create level 2 permissions will see all applications ever submitted.
	 */
	public function action_history()
	{
		$this->_view = 'admin/arc/history';
		$this->_js_view = 'admin/arc/history_js';

		$this->_data->applications = (\Sentry::user()->has_level('character.create', 2))
			? \Model_Application::find('all')
			: \Sentry::user()->get()->appReviews;

		return;
	}

	/**
	 * Review an application including admin functions to update the users on the
	 * review, email the applicant, and make a final decision.
	 */
	public function action_review($id)
	{
		$this->_view = 'admin/arc/review';
		$this->_js_view = 'admin/arc/review_js';

		if (is_numeric($id))
		{
			// get the application
			$app = \Model_Application::find($id);

			if (\Input::method() == 'POST')
			{
				if (\Security::check_token())
				{
					// get the action
					$action = \Security::xss_clean(\Input::post('action'));

					/**
					 * Update the reviewers associated with the review.
					 */
					if (\Sentry::user()->has_level('character.create', 2) and $action == 'users')
					{
						// update the reviewers
						$app->update_reviewers(\Security::xss_clean(\Input::post('reviewUsers')));

						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|reviewers|action.updated]]', 1),
						);
					}

					/**
					 * Vote on the application.
					 */
					if ($action == 'vote')
					{
						// update the vote
						$app->update_vote(\Sentry::user(), \Security::xss_clean(\Input::post()));

						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|vote|action.saved]]', 1),
						);
					}

					/**
					 * Comment on the application.
					 */
					if ($action == 'comment')
					{
						// add the comment
						\Model_Application_Response::create_item(array(
							'app_id'	=> $app->id,
							'user_id'	=> \Sentry::user()->id,
							'type'		=> \Model_Application_Response::COMMENT,
							'content'	=> \Security::xss_clean(\Input::post('content'))
						));

						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|comment|action.added]]', 1),
						);
					}

					/**
					 * Email the applicant.
					 */
					if ($action == 'email')
					{
						// add the comment
						\Model_Application_Response::create_item(array(
							'app_id'	=> $app->id,
							'user_id'	=> \Sentry::user()->id,
							'type'		=> \Model_Application_Response::EMAIL,
							'content'	=> \Security::xss_clean(\Input::post('content'))
						));

						// loop through the decision makers
						foreach ($app->find_decision_makers() as $dm)
						{
							// get the user
							$user = \Model_User::find($dm);

							// build the array for sending data
							$bcc[$user->email] = $user->name;
						}

						// get the email preferences
						$email_prefs = \Model_Settings::get_settings(array(
							'email_subject',
							'email_name',
							'email_address',
						));

						// setup the mailer
						$mailer = \NovaMail::setup();

						// build the message
						$message = \Swift_Message::newInstance()
							->setSubject($email_prefs->email_subject.' '.lang('email.subject.arc.email_applicant'))
							->setFrom(array($email_prefs->email_address => $email_prefs->email_name))
							->setTo(array($app->user->email => $app->user->name))
							->setBcc($bcc)
							->setReplyTo(\Sentry::user()->email)
							->setBody(\View::forge(
								\Location::file('html/arc_email', false, 'email'), 
								array('message' => \Security::xss_clean(\Input::post('content')))), 'text/html');
						
						// send the email
						$mailer->send($message);

						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|action.email|action.sent]]', 1),
						);
					}

					/**
					 * Make the decision for the application.
					 */
					if (\Sentry::user()->has_level('character.create', 2) and $action == 'decision')
					{
						// get the decision
						$decision = \Security::xss_clean(\Input::post('decision'));
						
						// update the user record
						$app->user->status = ($decision == 'approve') ? \Status::ACTIVE : \Status::REMOVED;
						$app->user->role_id = ($decision == 'approve') 
							? \Security::xss_clean(\Input::post('role')) 
							: \Model_Access_Role::INACTIVE;
						$app->user->save();

						// update the character record
						$app->character->status = ($decision == 'approve') ? \Status::ACTIVE : \Status::REMOVED;
						$app->character->activated = ($decision == 'approve') ? time() : 0;
						$app->character->rank_id = ($decision == 'approve') 
							? \Security::xss_clean(\Input::post('rank')) 
							: 1;
						$app->character->save();

						// update the position if it was changed
						if ($decision == 'approve' and 
								$app->position->id != \Security::xss_clean(\Input::post('position')))
						{
							// update the position
							$app->character->update_position(
								\Security::xss_clean(\Input::post('position')), 
								$app->position->id
							);
						}

						// update the application status
						$app->status = ($decision == 'approve') ? \Status::APPROVED : \Status::REJECTED;
						$app->save();

						// add the response
						\Model_Application_Response::create_item(array(
							'app_id'	=> $app->id,
							'user_id'	=> \Sentry::user()->id,
							'type'		=> \Model_Application_Response::RESPONSE,
							'content'	=> $app->message_substitution(\Security::xss_clean(\Input::post('message')))
						));

						// get the email preferences
						$email_prefs = \Model_Settings::get_settings(array(
							'email_subject',
							'email_name',
							'email_address',
						));

						// loop through the reviewers and build the array for sending data
						foreach ($app->reviewers as $r)
						{
							$bcc[$r->email] = $r->name;
						}

						// setup the mailer
						$mailer = \NovaMail::setup();

						// build the message
						$message = \Swift_Message::newInstance()
							->setSubject($email_prefs->email_subject.' '.lang('email.subject.arc.response'))
							->setFrom(array($email_prefs->email_address => $email_prefs->email_name))
							->setTo(array($app->user->email => $app->user->name))
							->setBcc($bcc)
							->setReplyTo(\Sentry::user()->email)
							->setBody(\View::forge(
								\Location::file('html/arc_response', false, 'email'), 
								array('message' => \Security::xss_clean(\Input::post('message')))), 'text/html');
						
						// send the email
						$mailer->send($message);

						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|final decision|action.saved]]', 1),
						);
					}
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('error.csrf'),
					);
				}
			}

			// get the object again (need to do this because relations may have changed)
			$app = $this->_data->app = \Model_Application::find($id);

			// create holding variables
			$reviewerString = '';
			$reviewerArray = array();

			// loop through the reviewers
			foreach ($app->reviewers as $reviewer)
			{
				// add the reviewers to a string
				$reviewerString.= '<span class="label">'.$reviewer->name.'</span> ';

				// now add them to an array
				$reviewerArray[] = $reviewer->id;
			}

			// pass the content on
			$this->_data->reviewerString = $reviewerString;
			$this->_data->reviewerArray = $reviewerArray;

			// create an empty array for the responses
			$this->_data->responses = array();

			// loop through the responses and make sure we have a sortable key
			foreach ($app->responses as $r)
			{
				$this->_data->responses[$r->id] = $r;
			}

			// make sure we have the responses in the right order
			krsort($this->_data->responses);

			// get the character form
			$this->_data->characterForm = \NovaForm::build('character', $this->skin, $app->character->id, false);

			// get the user form
			$this->_data->userForm = \NovaForm::build('user', $this->skin, $app->user->id, false);

			// get the app form
			$this->_data->appForm = \NovaForm::build('app', $this->skin, $app->id, false);

			// get the sample post question
			$this->_data->samplePost = \Markdown::parse(\Model_SiteContent::get_content('join_sample_post'));

			// get the vote information
			$this->_data->votes = new \stdClass;
			$this->_data->votes->all = count($app->votes());
			$this->_data->votes->yes = count($app->votes('yes'));
			$this->_data->votes->no = count($app->votes('no'));
			$this->_data->votes->mine = $app->votes( (int) \Sentry::user()->id);

			// get the role information
			$this->_data->roles = array();

			// set the date the user applied on
			$this->_data->applied_date = \Date::forge($app->created_at, \Sentry::user()->get()->preferences('timezone'))
				->format($this->options->date_format);
		}

		return;
	}

	/**
	 * Manage the application rules.
	 */
	public function action_rules($id = false)
	{
		\Sentry::allowed('character.create', true);

		$this->_view = 'admin/arc/rules';
		$this->_js_view = 'admin/arc/rules_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$rule_id = \Security::xss_clean(\Input::post('id'));

				/**
				 * Need to clean up the users data if it exists.
				 */
				if (isset($_POST['users']))
				{
					// create an empty array
					$users = array();

					// loop through the users so we can make sure it's in the right format
					foreach ($_POST['users'] as $key => $value)
					{
						$users[$key] = (is_array($value)) ? $value : array($value);
					}

					// update the the format of the users item
					$_POST['users'] = json_encode($users);
				}

				/**
				 * Create a new application rule.
				 */
				if (\Sentry::user()->has_level('character.create', 2) and $action == 'create')
				{
					$item = \Model_Application_Rule::create_item(\Security::xss_clean(\Input::post()));

					if ($item)
					{
						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|application rule|action.created]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> lang('[[short.flash.failure|application rule|action.creation]]', 1),
						);
					}
				}

				/**
				 * Update the specified application rule with the information the user specified
				 * in the modal pop-up.
				 */
				if (\Sentry::user()->has_level('character.create', 2) and $action == 'update')
				{
					$item = \Model_Application_Rule::update_item($rule_id, \Security::xss_clean(\Input::post()));

					if ($item)
					{
						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|application rule|action.updated]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> lang('[[short.flash.failure|application rule|action.update]]', 1),
						);
					}
				}

				/**
				 * Delete the specified application rule.
				 */
				if (\Sentry::user()->has_level('character.create', 2) and $action == 'delete')
				{
					$item = \Model_Application_Rule::delete_item($rule_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status'	=> 'success',
							'message'	=> lang('[[short.flash.success|application rule|action.deleted]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> lang('[[short.flash.failure|application rule|action.deletion]]', 1),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
			}
		}

		if (is_numeric($id))
		{
			// change the view
			$this->_view = 'admin/arc/rules_action';

			// set the action
			$this->_data->action = ($id == 0) ? 'create' : 'update';

			// get the rule record
			$rule = $this->_data->rule = \Model_Application_Rule::find($id);

			// pass data to the JS view
			$this->_js_data->type = ($rule) ? $rule->type : false;
		}
		else
		{
			// pull all the rules
			$this->_data->rules = \Model_Application_Rule::find('all');

			// pass data to the JS view
			$this->_js_data->type = false;
		}

		return;
	}
}
