<?php
/**
 * English Language File
 *
 * @package		Nova Core
 * @category	I18n
 * @author		Anodyne Productions
 */

return array(
	/**
	 * Login
	 */
	'login.index_text' => "Placeholder text for the main login page.",
	'login.logout' => "You have successfully logged out. You can :login or proceed to the :main. You will be redirected in <span id='countdown'></span>&nbsp;seconds.",
	'login.success' => "Log in successful. Redirecting to the :acp in <span id='countdown'></span>&nbsp;seconds...",
	'login.reset_message' => "Don't worry, forgetting your password happens to the best of us. Using the fields below, you can request a new password. Simply enter your email address and the security question you set up for your account then your answer to the question. Once I've got that information, I'll be able to reset your password and email you your new one. The first time you log in to the system, you'll be prompted to change your password to something you can remember.",
	
	/**
	 * Error Messages
	 */
	'error.not_found' => "No :item found.",
	'error.private_news' => "This :news is private and can only be viewed by registered :users.",
	'error.login_1' => "You must login to continue!",
	'error.login_2' => "Email address not found, please try again.",
	'error.login_3' => "Your password doesn't match our records, please try again.",
	'error.login_4' => "I've found more than one account with your email address. Please contact the game master to resolve this issue.",
	'error.login_5' => "Maintenance mode has been activated! Only system administrators are allowed to login. Please try again later.",
	'error.login_6' => "You've attempted to login more times than the system allows. You must wait :minutes minutes before attempting to login again! :extra",
	'error.login_7' => "Your account is currently under review. You will not be allowed to login until your application has been accepted. Please contact the game master if you have questions.",
	'error.login.wrong_security_question' => "The security question you selected doesn't match our records. Please try again.",
	'error.login.wrong_security_answer' => "The security answer you provided doesn't match our records. Please try again. Remember that you have to type your security answer exactly as you did when you set it.",
	'error.login.reset_success' => "Your password was successfully reset. Make sure you change your password to something you can remember when you log in.",
	'error.login.reset_failure' => "Your password wasn't reset. Please try again. If the problem persists, please contact your system administrator.",
	'error.sysadmin' => "You must be a system administrator to continue.",
	'error.email_disabled_failure' => "System email has been disabled by the system administrator and this form cannot be submitted.",
	
	/**
	 * Email Messages
	 */
	'email.subject.contact' => "Site Contact from :name",
	'email.subject.reset_password' => "Password Reset",
	'email.content.reset_password' => "Your password has been reset and is listed below. Next time you log in, you will be prompted to change your password to something else.\r\n\r\nNew password: :password\r\n\r\n<a href=':site'>Click here</a> to login to site now.",
	
	/**
	 * Phrases
	 */
	'phrase.enter_your_comment' => "Enter your comment on this :item.",
	'phrase.flash_success' => ":item was successfully :action.:extra",
	'phrase.flash_success_plural' => ":item were successfully :action.:extra",
	'phrase.flash_failure' => ":item was not successfully :action.:extra",
	'phrase.flash_failure_plural' => ":item were not successfully :action.:extra",
	'phrase.please_choose_one' => 'Please Choose One',
	
	'search.text' => "Searching through Nova has never been simpler than it is right now. Instead of giving users tons of options they have to wade through, we've reduced search down to it's most basic element: the search field. By default, Nova will search through :posts for your search terms. Instead of just searching through one area, Nova will search through all the areas listed above the field. If you don't want all the areas searched, just click on the ones you don't want searched and Nova will ignore them. If you'd prefer to search for something besides :posts, simply click on the icon in the field and select the new item you want to search for.",
);