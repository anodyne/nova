<?php

return array(
	'subject' => array(
		'password_reset' => "Confirm Password Reset",

		'arc' => array(
			'add_reviewer' => "Application Review",
			'review_start' => 'New Application Review Started',
			'email_applicant' => 'Email Regarding Your Application',
			'response' => 'Application Response',
		),
	),

	'content' => array(
		'password_reset' => "A password reset has been requested for the account associated with this email address. Since this is a two step process, you must now confirm your reset in order for your password to be changed.\r\n\r\n:0\r\n\r\nIf you did not request this reset, please contact your game master immediately and notify them of the issue. After doing so, you should log in to the site using your current password. Doing so will cancel the reset request.",

		'arc' => array(
			'add_reviewer' => "You have been added to an application review. From the Application Review Center you can review the application, comment on it and vote on whether you think it should be approved or rejected.\r\n\r\n<a href='".\Uri::create('login/index')."'>Log in</a> to start participating in the review.",
			'review_start' => "A new application has been received and is available for review. From the Application Review Center you can review the application, comment on it and vote on whether you think it should be approved or rejected.\r\n\r\n<a href='".\Uri::create('login/index')."'>Log in</a> to start participating in the review.",
		),
	),

	'error' => array(
		'no_to_address' => "Could not find TO address data.",
		'no_subject' => "Could not find SUBJECT data.",
	),
);
