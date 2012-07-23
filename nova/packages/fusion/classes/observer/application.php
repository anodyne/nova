<?php
/**
 * The application observer is a crucial component in the Application Review
 * Center (ARC) feature. When an application is created, the review process is
 * automatically kicked off from here.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Observer_Application extends \Orm\Observer
{
	/**
	 * When an application is created, we need to kick off the the review
	 * process by adding the decision makers and then going through all of the
	 * active rules to dynamically add reviewers to the application.
	 *
	 * @internal
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_insert(\Model $model)
	{
		/**
		 * System Event
		 */
		\SystemEvent::add('user', '[[event.main.join.application|{{'.$model->user_name.'}}|position|{{'.$model->position->name.'}}|character|{{'.$model->character_name.'}}]]');

		// start the array for who will get emailed
		$emailUsers = array();

		/**
		 * Add the decision makers to the review.
		 *
		 * A decision maker is anyone who has a role with the character
		 * component level 2 create action task (character.create.2).
		 */
		// get the decision makers
		$decisionMakers = \Sentry::users_with_access('character.create.2');

		// add the decision makers to the review
		foreach ($decisionMakers as $dm)
		{
			// add the reviewer record
			\Model_Application_Reviewer::create_item(array(
				'app_id' => $model->id,
				'user_id' => $dm->id
			));

			// add the user to the email array
			$emailUsers[$dm->id] = $dm->email;
		}

		/**
		 * Add reviewers to an application based on the rules.
		 */
		// get all the active application rules
		$rules = \Model_Application_Rule::get_items();

		if (count($rules) > 0)
		{
			// loop through the rules
			foreach ($rules as $r)
			{
				switch ($r->type)
				{
					case 'all':
						// get the JSON object
						$data = json_decode($r->users);

						if (property_exists($data, 'user'))
						{
							foreach ($data->user as $user)
							{
								// add the reviewer record
								\Model_Application_Reviewer::create_item(array(
									'app_id' => $model->id,
									'user_id' => $user
								));

								// add the user to the email array
								$emailUsers[$user] = \Model_User::find($user)->email;
							}
						}

						if (property_exists($data, 'position'))
						{
							foreach ($data->position as $position)
							{
								// get the active character in the given position
								$p = \Model_Position::find($position);

								// loop through the characters for that position
								foreach ($p->characters as $char)
								{
									if ($char->status == 'active' and $char->user !== null)
									{
										// add the reviewer record
										\Model_Application_Reviewer::create_item(array(
											'app_id' => $model->id,
											'user_id' => $char->user->id
										));

										// add the user to the email array
										$emailUsers[$char->user->id] = $char->user->email;
									}
								}
							}
						}
					break;

					case 'dept':
						// if the application is for the department
						if ($model->position->dept->id == (int) $r->condition)
						{
							// get the JSON object
							$data = json_decode($r->users);

							if (property_exists('user', $data))
							{
								foreach ($data->user as $user)
								{
									// add the reviewer record
									\Model_Application_Reviewer::create_item(array(
										'app_id' => $model->id,
										'user_id' => $user
									));

									// add the user to the email array
									$emailUsers[$user] = \Model_User::find($user)->email;
								}
							}

							if (property_exists('position', $data))
							{
								foreach ($data->position as $position)
								{
									// get the active character in the given position
									$p = \Model_Position::find($position);

									// loop through the characters for that position
									foreach ($p->characters as $char)
									{
										if ($char->status == 'active' and $char->user !== null)
										{
											// add the reviewer record
											\Model_Application_Reviewer::create_item(array(
												'app_id' => $model->id,
												'user_id' => $char->user->id
											));

											// add the user to the email array
											$emailUsers[$char->user->id] = $char->user->email;
										}
									}
								}
							}
						}
					break;
				}
			}

			// send the email to the reviewers
		}
		else
		{
			// what do we do if there aren't any active rules?
		}
	}
}
