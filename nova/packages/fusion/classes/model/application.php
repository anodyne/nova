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
	
	const IN_PROGRESS	= 1;
	const APPROVED 		= 2;
	const REJECTED 		= 3;

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
			'default' => 1),
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
			$query->where('status', static::IN_PROGRESS);
		}

		return $query->get();
	}

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
	 * Get all vote records for this application.
	 *
	 * @api
	 * @param	string	which responses to get (yes/no/false for all)
	 * @return	object
	 */
	public function votes($response = false)
	{
		$items = \Model_Application_Response::find()
			->where('app_id', $this->id)
			->where('type', \Model_Application_Response::VOTE)
			->order_by('created_at', 'desc');

		if ($response)
		{
			$items->where('content', $response);
		}
			
		return $items->get();
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
				$sendEmail[$d] = \Model_User::find($d)->email;
			}
		}

		if ($email_to_new and count($sendEmail) > 0)
		{
			// send the email
		}
	}
}
