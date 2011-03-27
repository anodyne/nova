<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The Nova API is a RESTful API that allows GET, PUT, POST and DELETE capabilities
 * from outside of Nova. This API should be considered experimental and used only
 * by developers who know what they're doing.
 *
 * By default, the API will return XML of the request, but that can be changed
 * with the URL resources.
 *
 * @package		Nova
 * @category	API
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		1.0
 */
 
require MODPATH.'api/libraries/REST_Controller'.EXT;

abstract class Nova_api extends REST_Controller {
	
	/**
	 * Get a specific character from the database. Due to the nature of Nova's
	 * dynamic character data, no data from outside of the characters table is
	 * provided as part of the API.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/character/id/1
	 *     index.php/api/character/id/1/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function character_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		if( ! $this->get('id'))
		{
			$this->response(null, 400);
		}
		
		$c = $this->char->get_character($this->get('id'));
		
		if ($c !== false)
		{
			$output[] = array(
				'id' 				=> $c->charid,
				'name' 				=> parse_name(array($c->first_name, $c->last_name)),
				'rank'				=> $this->ranks->get_rank($c->rank, 'rank_name'),
				'position' 			=> $this->pos->get_position($c->position_1, 'pos_name'),
				'secondposition'	=> ($c->position_2 !== null or $c->position_2 > 0) ? $this->pos->get_position($c->position_2, 'pos_name') : '',
				'type'				=> $c->crew_type,
				'activated'			=> mdate('%j %M %Y %G:%i', gmt_to_local($c->date_activate, 'UTC')),
				'deactivated'		=> ( ! empty($c->date_deactivate)) ? mdate('%j %M %Y %G:%i', gmt_to_local($c->date_deactivate, 'UTC')) : '',
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'Character could not be found'), 404);
		}
	}
	
	/**
	 * The API does not currently support creating, deleting or updating a character.
	 */
	 
	/**
	 * Get all characters from the database. Due to the nature of Nova's dynamic
	 * character data, no data from outside of the characters table is provided
	 * as part of the API.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/characters
	 *     index.php/api/characters/status/pending
	 *     index.php/api/characters/status/inactive
	 *     index.php/api/characters/status/npc
	 *     index.php/api/characters/status/user_npc
	 *     index.php/api/characters/status/has_user
	 *     index.php/api/characters/status/no_user
	 *     index.php/api/characters/status/all
	 *     index.php/api/characters/format/json
	 *     index.php/api/characters/status/pending/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function characters_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		// the available statuses
		$all_statuses = array('active', 'inactive', 'pending', 'npc', 'user_npc', 'has_user', 'no_user', 'all');
		
		// get the status resource and make sure it's legit
		$status = ( ! $this->get('status')) ? 'active' : $this->get('status');
		$statis = ( ! in_array($status, $all_statuses)) ? 'active' : $status;
		
		// get all the users
		$characters = $this->char->get_all_characters($status);
		
		if ($characters->num_rows() > 0)
		{
			foreach ($characters->result() as $c)
			{
				$output[] = array(
					'id' 				=> $c->charid,
					'name' 				=> parse_name(array($c->first_name, $c->last_name)),
					'rank'				=> $this->ranks->get_rank($c->rank, 'rank_name'),
					'position' 			=> $this->pos->get_position($c->position_1, 'pos_name'),
					'secondposition'	=> ($c->position_2 !== null or $c->position_2 > 0) ? $this->pos->get_position($c->position_2, 'pos_name') : '',
					'type'				=> $c->crew_type,
					'activated'			=> mdate('%j %M %Y %G:%i', gmt_to_local($c->date_activate, 'UTC')),
					'deactivated'		=> ( ! empty($c->date_deactivate)) ? mdate('%j %M %Y %G:%i', gmt_to_local($c->date_deactivate, 'UTC')) : '',
				);
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No characters found'), 404);
		}
	}
	
	/**
	 * Get a personal log from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function log_get()
	{
		// get news items
	}
	
	/**
	 * Create a new personal log with a POST request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function log_post()
	{
		// create a new news item
	}
	
	/**
	 * Update a personal log with a PUT request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function log_put()
	{
		// update a news item
	}
	
	/**
	 * Delete a personal log with a DELETE request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function log_delete()
	{
		// delete a news item
	}
	
	/**
	 * Get all the personal logs from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function logs_get()
	{
		// get news items
	}
	
	/**
	 * Get all current missions from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function mission_get()
	{
		$this->load->model('missions_model', 'mis');
		$this->load->model('posts_model', 'posts');
		
		$missions = $this->mis->get_all_missions('current');
		
		if ($missions->num_rows() > 0)
		{
			foreach ($missions->result() as $m)
			{
				$output[] = array(
					'id' 			=> $m->mission_id,
					'title' 		=> $m->mission_title,
					'description' 	=> $m->mission_desc,
					'totalposts' 	=> $this->posts->count_mission_posts($m->mission_id, 'multiple'),
				);
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No current missions available'), 404);
		}
	}
	
	/**
	 * The API does not currently allow creating, deleting or updating missions.
	 */
	 
	/**
	 * Get a news item from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function news_get()
	{
		// get news items
	}
	
	/**
	 * Create a new news item with a POST request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function news_post()
	{
		// create a new news item
	}
	
	/**
	 * Update a news item with a PUT request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function news_put()
	{
		// update a news item
	}
	
	/**
	 * Delete a news item with a DELETE request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function news_delete()
	{
		// delete a news item
	}
	
	/**
	 * Get all news items from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function allnews_get()
	{
		// get news items
	}
	
	/**
	 * Get a mission post from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function missionpost_get()
	{
		// get news items
	}
	
	/**
	 * Create a new mission post with a POST request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function missionpost_post()
	{
		// create a new news item
	}
	
	/**
	 * Update a mission post with a PUT request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function missionpost_put()
	{
		// update a news item
	}
	
	/**
	 * Delete a mission post with a DELETE request.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/news
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function missionpost_delete()
	{
		// delete a news item
	}
	
	/**
	 * Get all the mission posts for a mission from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/mission
	 *     index.php/api/mission/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function missionposts_get()
	{
		// get news items
	}
	 
	/**
	 * Get a specific user from the database.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/user/id/1
	 *     index.php/api/user/id/1/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function user_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		if( ! $this->get('id'))
		{
			$this->response(null, 400);
		}
		
		$user = $this->user->get_user($this->get('id'));
		
		if ($user !== false)
		{
			$character = $this->char->get_character($user->main_char);
			
			$all_user_chars = $this->char->get_user_characters($user->userid, null);
			
			$allcharacters = '';
			
			if ($all_user_chars->num_rows() > 0)
			{
				$allcharacters = array();
				
				foreach ($all_user_chars->result() as $a)
				{
					$allcharacters[] = array(
						'id' 				=> $a->charid,
						'name' 				=> parse_name(array($a->first_name, $a->last_name)),
						'rank'				=> $this->ranks->get_rank($a->rank, 'rank_name'),
						'position' 			=> $this->pos->get_position($a->position_1, 'pos_name'),
						'secondposition'	=> ($a->position_2 !== null or $a->position_2 > 0) ? $this->pos->get_position($a->position_2, 'pos_name') : '',
						'type'				=> $a->crew_type,
						'activated'			=> mdate('%j %M %Y %G:%i', gmt_to_local($a->date_activate, 'UTC')),
						'deactivated'		=> ( ! empty($a->date_deactivate)) ? mdate('%j %M %Y %G:%i', gmt_to_local($a->date_deactivate, 'UTC')) : '',
					);
				}
			}
			
			$output[] = array(
				'id' 			=> $user->userid,
				'name' 			=> $user->name,
				'email' 		=> $user->email,
				'maincharacter'	=> $this->char->get_character_name($user->main_char, true),
				'characters'	=> $allcharacters,
				'position' 		=> $this->pos->get_position($character->position_1, 'pos_name'),
				'lastlogin'		=> ( ! empty($user->last_login)) ? mdate('%j %M %Y %G:%i', gmt_to_local($user->last_login, 'UTC')) : 'No login recorded',
				'lastpost'		=> ( ! empty($user->last_post)) ? mdate('%j %M %Y %G:%i', gmt_to_local($user->last_post, 'UTC')) : 'No post recorded',
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'User could not be found'), 404);
		}
	}
	
	/**
	 * The API does not currently support creating, deleting or updating a user.
	 */
	 
	/**
	 * Get all users from the database.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 *     index.php/api/users
	 *     index.php/api/users/status/pending
	 *     index.php/api/users/status/inactive
	 *     index.php/api/users/format/json
	 *     index.php/api/users/status/pending/format/json
	 *
	 * @access	public
	 * @since	2.0
	 */
	public function users_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		// the available statuses
		$all_statuses = array('active', 'inactive', 'pending');
		
		// get the status resource and make sure it's legit
		$status = ( ! $this->get('status')) ? 'active' : $this->get('status');
		$statis = ( ! in_array($status, $all_statuses)) ? 'active' : $status;
		
		// get all the users
		$users = $this->user->get_users($status);
		
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $u)
			{
				$character = $this->char->get_character($u->main_char);
				
				$all_user_chars = $this->char->get_user_characters($u->userid, null);
				
				$allcharacters = '';
				
				if ($all_user_chars->num_rows() > 0)
				{
					$allcharacters = array();
					
					foreach ($all_user_chars->result() as $a)
					{
						$allcharacters[] = array(
							'id' 				=> $a->charid,
							'name' 				=> parse_name(array($a->first_name, $a->last_name)),
							'rank'				=> $this->ranks->get_rank($a->rank, 'rank_name'),
							'position' 			=> $this->pos->get_position($a->position_1, 'pos_name'),
							'secondposition'	=> ($a->position_2 !== null or $a->position_2 > 0) ? $this->pos->get_position($a->position_2, 'pos_name') : '',
							'type'				=> $a->crew_type,
							'activated'			=> mdate('%j %M %Y %G:%i', gmt_to_local($a->date_activate, 'UTC')),
							'deactivated'		=> ( ! empty($a->date_deactivate)) ? mdate('%j %M %Y %G:%i', gmt_to_local($a->date_deactivate, 'UTC')) : '',
						);
					}
				}
				
				$output[] = array(
					'id' 			=> $u->userid,
					'name' 			=> $u->name,
					'email' 		=> $u->email,
					'maincharacter'	=> $this->char->get_character_name($u->main_char, true),
					'characters'	=> $allcharacters,
					'position' 		=> $this->pos->get_position($character->position_1, 'pos_name'),
					'lastlogin'		=> ( ! empty($u->last_login)) ? mdate('%j %M %Y %G:%i', gmt_to_local($u->last_login, 'UTC')) : 'No login recorded',
					'lastpost'		=> ( ! empty($u->last_post)) ? mdate('%j %M %Y %G:%i', gmt_to_local($u->last_post, 'UTC')) : 'No posts recorded',
				);
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No users found'), 404);
		}
	}
}
