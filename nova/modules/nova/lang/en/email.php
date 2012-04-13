<?php

return array(
	'subject' => array(
		'password_reset' => "Confirm Password Reset",
	),

	'content' => array(
		'password_reset' => "A password reset has been requested for the account associated with this email address. Since this is a two step process, you must now confirm your reset in order for your password to be changed.\r\n\r\n%s\r\n\r\nIf you did not request this reset, please contact your game master immediately and notify them of the issue. After doing so, you should log in to the site using your current password. Doing so will cancel the reset request.",
	),

	'flash' => array(
		'could_not_send' => "The email could not be sent for unknown reasons. Please contact the game master.",
		'validation_failed' => "The email could not be sent because of a validation problem. Please make sure your information is correct and try again.",
		'reset_failed' => "The password reset failed. Please try again.",
		'auth_exception' => "An unknown authentication occurred when attempting to reset your password. Please make sure your information is correct and try again.",
		'reset_success' => "Your password reset was accepted. You'll receive an email shortly with a confirmation link. Once you've confirmed your password reset, your new password will be active.",
		'confirmation_failed' => "Your password reset could not be confirmed. Please make sure you have used the right confirmation link and try again.",
	),
);
