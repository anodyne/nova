<?php
/**
 * This data is intended to be used for development purposes only.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

/**
 * Info about how to insert the data and where to find the data.
 */
$data = array(
	array(
		'data' => 'applications',
		'model' => '\\Model_Application',
		'method' => 'create_item'),
	/*array(
		'data' => 'application_responses',
		'model' => '\\Model_Application_Response',
		'method' => 'create_item'),*/
	array(
		'data' => 'application_reviewers',
		'model' => '\\Model_Application_Reviewer',
		'method' => 'create_item'),
	array(
		'data' => 'characters',
		'model' => '\\Model_Character',
		'method' => 'create_item'),
	array(
		'data' => 'character_positions',
		'model' => '\\Model_Character_Positions',
		'method' => 'create_item'),
	array(
		'data' => 'users',
		'model' => '\\Model_User',
		'method' => 'create_item'),
);

/**
 * Development data.
 */
$applications = array(
	array(
		'user_id'		=> 2,
		'character_id'	=> 2,
		'position_id'	=> 2,
		'status' 		=> \Status::APPROVED),
	array(
		'user_id'		=> 3,
		'character_id'	=> 3,
		'position_id'	=> 23,
		'status' 		=> \Status::APPROVED),
	array(
		'user_id'		=> 4,
		'character_id'	=> 4,
		'position_id'	=> 29,
		'status' 		=> \Status::APPROVED),
	array(
		'user_id'		=> 5,
		'character_id'	=> 5,
		'position_id'	=> 9,
		'status' 		=> \Status::APPROVED),
	array(
		'user_id'		=> 6,
		'character_id'	=> 6,
		'position_id'	=> 16,
		'status' 		=> \Status::APPROVED),
	array(
		'user_id'		=> 7,
		'character_id'	=> 7,
		'position_id'	=> 13,
		'status' 		=> \Status::IN_PROGRESS),
	array(
		'user_id'		=> 8,
		'character_id'	=> 8,
		'position_id'	=> 47,
		'status' 		=> \Status::REJECTED),
);

$application_reviewers = array(
	array('app_id' => 1, 'user_id' => 1),
	array('app_id' => 2, 'user_id' => 1),
	array('app_id' => 2, 'user_id' => 2),
	array('app_id' => 3, 'user_id' => 1),
	array('app_id' => 3, 'user_id' => 2),
	array('app_id' => 3, 'user_id' => 3),
	array('app_id' => 4, 'user_id' => 1),
	array('app_id' => 4, 'user_id' => 2),
	array('app_id' => 4, 'user_id' => 3),
	array('app_id' => 4, 'user_id' => 4),
	array('app_id' => 5, 'user_id' => 1),
	array('app_id' => 5, 'user_id' => 2),
	array('app_id' => 5, 'user_id' => 3),
	array('app_id' => 5, 'user_id' => 4),
	array('app_id' => 6, 'user_id' => 1),
	array('app_id' => 6, 'user_id' => 2),
	array('app_id' => 6, 'user_id' => 3),
	array('app_id' => 6, 'user_id' => 4),
	array('app_id' => 7, 'user_id' => 1),
	array('app_id' => 7, 'user_id' => 2),
	array('app_id' => 7, 'user_id' => 3),
	array('app_id' => 7, 'user_id' => 4),
);

$characters = array(
	array(
		'user_id' 		=> 2,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'William',
		'last_name'		=> 'Riker',
		'activated' 	=> time(),
		'rank_id' 		=> 12),
	array(
		'user_id' 		=> 3,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Data',
		'activated' 	=> time(),
		'rank_id' 		=> 33),
	array(
		'user_id' 		=> 4,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Geordi',
		'last_name'		=> 'La Forge',
		'activated' 	=> time(),
		'rank_id' 		=> 33),
	array(
		'user_id' 		=> 5,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Wesley',
		'last_name'		=> 'Crusher',
		'activated' 	=> time(),
		'rank_id' 		=> 16),
	array(
		'user_id' 		=> 6,
		'status' 		=> \Status::INACTIVE,
		'first_name'	=> 'Tasha',
		'last_name'		=> 'Yar',
		'activated' 	=> time(),
		'rank_id' 		=> 34),
	array(
		'user_id' 		=> 7,
		'status' 		=> \Status::PENDING,
		'first_name'	=> 'Worf',
		'activated' 	=> time(),
		'rank_id' 		=> 13),
	array(
		'user_id' 		=> 8,
		'status' 		=> \Status::REMOVED,
		'first_name'	=> 'Deanna',
		'last_name'		=> 'Troi',
		'activated' 	=> time(),
		'rank_id' 		=> 53),
);

$character_positions = array(
	array('character_id' => 2, 'position_id' => 2, 'primary' => 1),
	array('character_id' => 3, 'position_id' => 23, 'primary' => 1),
	array('character_id' => 3, 'position_id' => 3, 'primary' => 0),
	array('character_id' => 4, 'position_id' => 29, 'primary' => 1),
	array('character_id' => 5, 'position_id' => 9, 'primary' => 1),
	array('character_id' => 6, 'position_id' => 16, 'primary' => 1),
	array('character_id' => 7, 'position_id' => 13, 'primary' => 1),
	array('character_id' => 8, 'position_id' => 47, 'primary' => 1),
);

$users = array(
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Admin',
		'email'			=> 'admin@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 2,
		'role_id'		=> \Model_Access_Role::ADMIN),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Power User',
		'email'			=> 'poweruser@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 3,
		'role_id'		=> \Model_Access_Role::POWERUSER),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Active',
		'email'			=> 'active@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 4,
		'role_id'		=> \Model_Access_Role::ACTIVE),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'User',
		'email'			=> 'user@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 5,
		'role_id'		=> \Model_Access_Role::USER),
	array(
		'status'		=> \Status::INACTIVE,
		'name'			=> 'Inactive',
		'email'			=> 'inactive@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 6,
		'role_id'		=> \Model_Access_Role::INACTIVE),
	array(
		'status'		=> \Status::PENDING,
		'name'			=> 'In Progress',
		'email'			=> 'inprogress@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 7,
		'role_id'		=> \Model_Access_Role::USER),
	array(
		'status'		=> \Status::REMOVED,
		'name'			=> 'Rejected',
		'email'			=> 'rejected@example.com',
		'password'		=> \Sentry_User::password_generate('password'),
		'character_id'	=> 8,
		'role_id'		=> \Model_Access_Role::INACTIVE),
);
