<?php
/**
 * Application Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Application extends \Model {
	
	public static $_table_name = 'applications';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'position_id' => array(
			'type' => 'string',
			'constraint' => 255),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::IN_PROGRESS),
		'experience' => array(
			'type' => 'text',
			'null' => true),
		'hear_about' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'hear_about_detail' => array(
			'type' => 'text',
			'null' => true),
		'sample_post' => array(
			'type' => 'text',
			'null' => true),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	/**
	 * Relationships
	 */
	protected static $_belongs_to = array(
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'position' => array(
			'model_to' => '\\Model_Position',
			'key_to' => 'id',
			'key_from' => 'position_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'responses' => array(
			'model_to' => '\\Model_Application_Response',
			'key_to' => 'app_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_many_many = array(
		'reviewers' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'app_id',
			'key_through_to' => 'user_id',
			'table_through' => 'application_reviewers',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Application' => array(
			'events' => array('after_insert')
		),
		'\\Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert')
		),
		'\\Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save')
		),
	);

	/**
	 * Get all comment records for this application.
	 *
	 * @api
	 * @return	object
	 */
	public function comments()
	{
		return \Model_Application_Response::find()
			->where('app_id', $this->id)
			->where('type', \Model_Application_Response::COMMENT)
			->order_by('created_at', 'desc')
			->get();
	}

	/**
	 * Get vote records for this application.
	 *
	 * @api
	 * @param	mixed	which responses to get (yes/no/false for all)
	 * @return	object
	 */
	public function votes($response = false)
	{
		$items = \Model_Application_Response::find()
			->where('app_id', $this->id)
			->where('type', \Model_Application_Response::VOTE)
			->order_by('created_at', 'desc');

		if (is_numeric($response))
		{
			return $items->where('user_id', $response)->get_one();
		}

		if (is_string($response))
		{
			$items->where('content', $response);
		}
			
		return $items->get();
	}

	/**
	 * Substitute the keys for their actual values.
	 *
	 * @api
	 * @param	string	the message
	 * @return	string
	 */
	public function message_substitution($message)
	{
		// build the list of possible substitutions
		$args = array(
			'name'		=> $this->user->name,
			'character'	=> $this->character->name(false),
			'position'	=> $this->position->name,
			'rank'		=> $this->character->rank->info->name,
			'sim'		=> \Model_Settings::get_settings('sim_name'),
		);

		// loop through all the arguments and replace it if it's in the message
		foreach ($args as $key => $value)
		{
			if (strpos($message, '#'. $key .'#') !== false)
			{
				$message = str_replace('#'. $key .'#', $value, $message);
			}
		}

		return $message;
	}

	/**
	 * Gets the decision makers that are involved with this application.
	 *
	 * @api
	 * @return	array
	 */
	public function find_decision_makers()
	{
		// get all decision makers
		$decision_makers = array_keys(\Sentry::users_with_access('character.create.2'));

		// loop through the reviewers
		foreach ($this->reviewers as $r)
		{
			$review_users[] = $r->user_id;
		}

		// compare the two arrays
		return array_intersect($decision_makers, $review_users);
	}

	/**
	 * Get the application records.
	 *
	 * @api
	 * @param	bool	should we get only active records?
	 * @return	object
	 */
	public static function find_items($only_active = true)
	{
		$query = static::find();

		if ($only_active)
		{
			$query->where('status', \Status::IN_PROGRESS);
		}

		return $query->get();
	}

	/**
	 * Update the reviewers associated with this review. This involves
	 * removing all reviewers and re-adding them.
	 *
	 * @api
	 * @param	mixed	the data to use for updating reviewers
	 * @param	bool	should an email be sent to reviewers who are new?
	 * @return	mixed
	 * @todo	send the email to a new reviewer
	 */
	public function update_reviewers($data, $email_to_new = true)
	{
		// make sure we have an array
		$data = ( ! is_array($data)) ? array($data) : $data;

		// get the reviewers for this application
		$reviewers = \Model_Application_Reviewer::find()->where('app_id', $this->id)->get();

		// loop through the reviewers and remove them
		foreach ($reviewers as $r)
		{
			// keep a record of who was there before
			$oldReviewers[] = $r->user_id;

			// delete the reviewer
			$r->delete();
		}

		// track who needs to get an email
		$sendEmail = array();

		// now loop through the data we have
		foreach ($data as $d)
		{
			// add the reviewer
			\Model_Application_Reviewer::create_item(array(
				'app_id' => $this->id,
				'user_id' => $d
			));

			// if they weren't in the old list, add them to the list for sending an email
			if ( ! in_array($d, $oldReviewers))
			{
				// get the email information
				$sendEmail[] = $d;
			}
		}

		if ($email_to_new and count($sendEmail) > 0)
		{
			// send the email
			\NovaMail::send('arc_reviewer_add', array(
				'subject' => lang('email.subject.arc.add_reviewer'),
				'to' => array_values($sendEmail),
				'content' => array('message' => lang('email.content.arc.add_reviewer')),
			));
		}
	}

	/**
	 * Create a new vote record if the user doesn't have one, otherwise,
	 * update their existing record.
	 *
	 * @api
	 * @param	Sentry_User		the Sentry user object
	 * @param	array			the POST array
	 * @return	bool
	 */
	public function update_vote($user, $data)
	{
		// get the user's vote
		$myVote = $this->votes( (int) $user->id);

		if ($myVote)
		{
			// update the response
			$myVote->content = (\Arr::get($data, 'vote.yes') !== false) ? 'yes' : 'no';
			$myVote->created_at = time();
			$myVote->save();
		}
		else
		{
			// add the response
			\Model_Application_Response::create_item(array(
				'app_id' => $this->id,
				'user_id' => $user->id,
				'type' => \Model_Application_Response::VOTE,
				'content' => (\Arr::get($data, 'vote.yes') !== false) ? 'yes' : 'no'
			));
		}

		return true;
	}
}
