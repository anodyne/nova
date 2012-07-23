<?php
/**
 * The form field observer acts on the form field model at given times to ensure
 * additional work on on other fields, data, values, sections, and tabs happens
 * as it should.
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
	 * When an application is created, we need to kick off the
	 * the review process.
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
		//\SystemEvent::add('user', '[[event.admin.form.field_create|{{'.$model->label.'}}|{{'.$model->form_key.'}}]]');

		// add the decision makers to the review

		/**
		 * This is one of the trickier situations in Nova 3 with the new access system
		 * and taking role inheritance into account. First, we have to find the specific
		 * task, then we have to find out what roles that task belongs to, then check to
		 * see if those roles are inherited anywhere. Finally, we have to find anyone who
		 * has the roles identified. Easy to write out, tough to build and do so efficiently
		 * and in a reusable way.
		 */

		// get all the active application rules
		$rules = \Model_Application_Rule::get_items();

		if (count($rules) > 0)
		{
			// start the array for emailing users
			$emailUsers = array();

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
