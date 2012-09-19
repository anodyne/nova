<?php
/**
 * Nova's login controller.
 *
 * @package		Nova
 * @subpackage	Login
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Login;

class Controller_Login extends Controller_Base_Login
{
	/**
	 * Log In Error Codes
	 */
	const OK 				= 0;
	const NOT_LOGGED_IN 	= 1;
	const WRONG_EMAIL 		= 2;
	const NO_EMAIL 			= 3;
	const WRONG_PASS 		= 4;
	const NO_PASS 			= 5;
	const WRONG_EMAIL_PASS	= 6;
	const SUSPEND_START		= 7;
	const SUSPEND_DURING	= 8;
	const UNKNOWN			= 9;
	const PASS_RESET 		= 10;
	const NOT_ADMIN			= 11;

	/**
	 * Lets a user log in to the system. If their email address or password is wrong,
	 * they're notified of the error. Also handles notifying the user if they've
	 * been locked out of the system for too many log in attempts.
	 */
	public function action_index($error = 0)
	{
		// set the view
		$this->_view = 'login/index';

		// are we locked out? by default, no
		$this->_data->lockout = false;

		// check to see if the user is locked out
		$lockout = \Sentry::attempts(null, \Input::real_ip())->get();

		// display a message if the user is locked out
		if ( (int) $lockout > \Sentry::attempts()->getLimit())
		{
			$this->_flash[] = array(
				'status' => 'warning',
				'message' => lang('error.login.locked_out'),
			);

			// now we're locked out
			$this->_data->lockout = true;
		}
		else
		{
			if (\Input::method() == 'POST')
			{
				if (\Security::check_token())
				{
					// grab the data from the POST and filter it
					$email = \Security::xss_clean(\Input::post('email'));
					$password = \Security::xss_clean(\Input::post('password'));

					# TODO: should we always remember people or give them the option?

					// attempt to log in
					$error = \Sentry::login($email, $password, false);

					// successful log in
					if ($error === self::OK)
					{
						\Response::redirect('admin/index');
					}
					else
					{
						\Response::redirect("login/index/$error");
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

			if ($error > self::OK)
			{
				switch ($error)
				{
					case self::WRONG_EMAIL:
						$error_status = 'danger';
						$error_message = lang("[[error.login.error_$error|{{".\Uri::create('main/contact')."}}]]");
					break;

					case self::WRONG_PASS:
						$error_status = 'danger';
						$error_message = lang("[[error.login.error_$error|{{".\Uri::create('login/reset')."}}]]");
					break;

					case self::SUSPEND_DURING:
						$error_status = 'warning';
						$error_message = lang("[[error.login.error_$error|{{".\Model_Settings::getItems('login_lockout_time')."}}]]");
					break;

					case self::SUSPEND_START:
						$error_status = 'danger';
						$error_message = lang("[[error.login.error_$error|{{".\Model_Settings::getItems('login_lockout_time')."}}]]");
					break;

					case self::PASS_RESET:
						$error_status = 'info';
						$error_message = lang("error.login.error_$error");
					break;
					
					default:
						$error_status = 'danger';
						$error_message = lang("error.login.error_$error");
					break;
				}

				// set the flash data
				$this->_flash[] = array(
					'status' => $error_status,
					'message' => $error_message,
				);
			}
		}

		return;
	}

	/**
	 * Logs a user out of the system, destroys any cookies, and make sure they
	 * won't be remembered by the system.
	 */
	public function action_logout()
	{
		// do the log out
		\Sentry::logout();

		// manually set the logout message
		$this->_data->message = lang('[[short.login.logout|{{'.\Uri::create('main/index').'}}|{{'.\Uri::create('login/index').'}}]]');

		return;
	}

	/**
	 * Lets a user reset their password to one of their choosing. Once they've
	 * entered their email address and new password, they'll receive an email
	 * with a confirmation link. After clicking on the confirmation link and
	 * clicking the button the page, the password will be updated. In the event
	 * they remember their password, logging in to the system will cancel the
	 * reset request.
	 */
	public function action_reset()
	{
		$this->_view = 'login/reset';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// grab the data from the POST and filter it
				$email = \Security::xss_clean(\Input::post('email'));
				$password = \Security::xss_clean(\Input::post('password'));

				try
				{
					// do the reset
					$reset = \Sentry::resetPassword($email, $password);

					if ($reset)
					{
						// set the email address coming from the reset
						$address = $reset['email'];

						// create the confirmation link
						$link = \Uri::create('login/reset_confirm/'.$reset['link']);

						// parse the content for the message
						$email_content = lang("email.content.password_reset|[$link]");

						// set up the email
						$email = \Email::forge();
						$email->from($this->options->email_address, $this->options->email_name)
							->to($address)
							->subject($this->options->email_subject.' '.lang('email.subject.password_reset'))
							->body($email_content);

						try
						{
							// send the email
							$email->send();

							$this->_flash[] = array(
								'status' => 'success',
								'message' => lang('short.login.reset_success')
							);
						}
						catch(\EmailValidationFailedException $e)
						{
							$this->_flash[] = array(
								'status' => 'danger',
								'message' => lang('error.email.validation_failed')
							);
						}
						catch(\EmailSendingFailedException $e)
						{
							$this->_flash[] = array(
								'status' => 'danger',
								'message' => lang('error.email.could_not_send')
							);
						}
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.login.reset_failed')
						);
					}
				}
				catch (\SentryAuthException $e)
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('error.login.auth_exception')
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

		return;
	}

	# TODO: need some kind of procedure for how to handle if the email doesn't go out
	# TODO: need something in the admin side of things here a GM can manually confirm a password reset

	/**
	 * Confirms a user's request to reset their password.
	 */
	public function action_reset_confirm()
	{
		$this->_view = 'login/reset_confirm';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				try
				{
					// confirm password reset
					$confirm_reset = \Sentry::resetPasswordConfirm(\Uri::segment(3), \Uri::segment(4));

					if ($confirm_reset)
					{
						// redirect to the login page with a message about a successful reset
						\Response::redirect('login/index/'.self::PASS_RESET);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('email.flash.confirmation_failed')
						);
					}
				}
				catch (\SentryAuthException $e)
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('email.flash.auth_exception')
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

		return;
	}
}
