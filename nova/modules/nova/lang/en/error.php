<?php

return array(
	'email' => array(
		'could_not_send' => "The email could not be sent for unknown reasons. Please contact the game master.",
		'validation_failed' => "The email could not be sent because of a validation problem. Please make sure your information is correct and try again.",
	),

	'login' => array(
		'locked_out' => "You've attempted to log in more times than the system allows.",
		'maintenance' => "Maintenance mode has been activated and you cannot log in. Please try again later. If you continue to get this error, please contact the game master.",

		'error_1' => "You are not logged in and must do so to continue.",
		'error_2' => "The email address you entered is not in our system. Please try again with a valid email address. If you believe you've received this message in error, please <a href=':0'>contact the game master</a>.",
		'error_3' => "You did not enter an email address. Please enter an email address to continue.",
		'error_4' => "The password you entered does not match our records. Please try again. If you don't remember your password, you can <a href=':0'>reset it</a>.",
		'error_5' => "You did not enter a password. Please enter a password to continue.",
		'error_6' => "Your email address and password are empty. Please enter a valid email address and password to continue.",
		'error_7' => "Too many log in attempts! Your account has been suspended for :0 minutes. Once the ban has passed, you will be able to log in again.",
		'error_8' => "Your account as suspended because of too many log in attempts. You will be able to log in in :0 minutes.",
		'error_9' => "An unknown error has occurred. Please try again.",
		'error_10' => "Your password was successfully reset.",
		
		'reset_failed' => "The password reset failed. Please try again.",
		'auth_exception' => "An unknown authentication occurred when attempting to reset your password. Please make sure your information is correct and try again.",
		'confirmation_failed' => "Your password reset could not be confirmed. Please make sure you have used the right confirmation link and try again.",
	),
);
