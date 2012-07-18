<?php

return array(
	
	'add' => "add :0",
	
	'cancel_password_reset' => "Cancel password reset",

	'delete' => "delete :0",
	'delete_confirm' => "Are you sure you want to delete the :0 <strong>:1</strong>? This action is permanent and cannot be undone!",

	'edit' => "edit :0",

	'forgot_password' => "Forgot your password? Don't worry, it happens to the best of us!",

	'hear_about_us' => array(
		'question' => "where did you hear about us?",
		'detail' => "please specify",

		'friend' => 'friend',
		'member' => 'another member',
		'org' => 'organization',
		'ad' => 'advertisement',
		'search' => 'internet search',
		'other' => 'other',
	),

	'join' => array(
		'user_info' => ":0 information (including :1 and :2) is only viewable by members of the :3 when they are logged in to the site. None of your information can be seen by visitors to the site or anyone who is not logged in.",
		'user_found' => "Your :0 record was found. If you're trying to apply with a new :1, you can continue to the :1 section. If you're trying to re-activate an existing :1, please contact the :2.",
		'welcome_back' => "welcome back!",
	),

	'please_note' => "please note",

	'refresh' => "Please refresh the page to view your changes.",

	'forms' => array(
		'value_creation' => "Dropdown menu values can be added once you've created the field.",
		'order' => "The order can also be changed by dragging and dropping the items on the previous page.",
		'values_dropdown_only' => "You can only move values from one dropdown menu to another.",
		'values_content' => "The content is what will appear to the user in the dropdown menu.",
		'values_value' => "The value is what will be stored in the database and appear on the page.",
		'values_order' => "The order of the values can also be changed by dragging and dropping the values on the previous page.",
		'section_update_fields' => "Select the new section you would like any fields in the :0 section to be moved to.",
		'tab_update_sections' => "Select the new tab you would like any sections in the :0 tab to be moved to.",
		'tab_link_id' => "Link IDs are used to link a tab with its content. They must be unique, one word, and simple (e.g. one, html, general).",
		'field_restriction' => "Fields can be restricted so only someone with the above role (or anyone who has a role that inherits the above role) can edit the data."
	),

	'flash' => array(
		'failure' => ":0 :1 failed, please try again.",
		'success' => ":0 :1!",
	),

	'login' => array(
		'reset_success' => "Your password reset was accepted. You'll receive an email shortly with a confirmation link. Once you've confirmed your password reset, your new password will be active.",

		'logout' => "You have successfully logged out. You can return to the <a href=':0'>main page</a> or <a href=':1'>log in</a> again.",
	),

	'ranks' => array(
		'change_group' => "Select the new :0 group for any :1 currently in this :0 group.",
		'change_info' => "Select the new :0 info item for any :1 currently using this :0 info record.",
		'info_group_explain' => "Info groups are used solely for presentation purposes.",
	),
);
