<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The Nova API is a RESTful API that allows GET capabilities from outside of
 * Nova. This API should be considered experimental and used only by developers
 * who know what they're doing. In the future, we will add POST, PUT and
 * DELETE abilities to the API.
 *
 * By default, the API will return XML of the request, but that can be changed
 * with the URL resources. Available options are: xml, json, html, csv.
 *
 * @package		Nova
 * @category	API
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		1.0
 */
 
require MODPATH.'core/libraries/REST_Controller'.EXT;

abstract class Nova_api extends REST_Controller {
	
	/**
	 * The version of the API.
	 */
	public $_api_version = '1.0.0';
	
	/**
	 * The date format.
	 */
	public $_date_format = '%j %M %Y %G:%i';
	
	/**
	 * Get information about the API.
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function info_get()
	{
		$this->load->model('settings_model', 'settings');
		
		$output[] = array(
			'api' 	=> array(
				'version'	=> $this->_api_version,
				'url'		=> site_url('api/'),
			),
			'sim'	=> array(
				'version'	=> APP_VERSION,
				'name' 		=> $this->settings->get_setting('sim_name'),
				'url'		=> base_url(),
			),
		);
		
		$this->response($output, 200);
	}
	
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
	 * @since	1.0
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
				'activated'			=> mdate($this->_date_format, gmt_to_local($c->date_activate, 'UTC')),
				'deactivated'		=> ( ! empty($c->date_deactivate)) ? mdate($this->_date_format, gmt_to_local($c->date_deactivate, 'UTC')) : '',
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'Character could not be found'), 404);
		}
	}
	 
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
	 * @since	1.0
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
					'activated'			=> mdate($this->_date_format, gmt_to_local($c->date_activate, 'UTC')),
					'deactivated'		=> ( ! empty($c->date_deactivate)) ? mdate($this->_date_format, gmt_to_local($c->date_deactivate, 'UTC')) : '',
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
	 *     index.php/api/log/1
	 *     index.php/api/log/1/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function log_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('personallogs_model', 'log');
		$this->load->helper('utility');
		
		if( ! $this->get('id'))
		{
			$this->response(null, 400);
		}
		
		$l = $this->log->get_log($this->get('id'));
		
		if ($l !== false)
		{
			$character = $this->char->get_character($l->log_author_character);
			
			$name = array(
				$this->ranks->get_rank($character->rank, 'rank_name'),
				$character->first_name,
				$character->last_name,
			);
			
			$output[] = array(
				'id' 		=> $l->log_id,
				'title' 	=> $l->log_title,
				'content'	=> $l->log_content,
				'tags' 		=> $l->log_tags,
				'status'	=> $l->log_status,
				'date'		=> mdate($this->_date_format, gmt_to_local($l->log_date, 'UTC')),
				'updated'	=> mdate($this->_date_format, gmt_to_local($l->log_last_update, 'UTC')),
				'character'	=> parse_name($name),
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'Personal log could not be found'), 404);
		}
	}
	
	/**
	 * Get all the personal logs from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/logs
	 *     index.php/api/logs/limit/25
	 *     index.php/api/logs/limit/25/offset/50
	 *     index.php/api/logs/status/saved
	 *     index.php/api/logs/status/all
	 *     index.php/api/logs/user/1
	 *     index.php/api/logs/character/1
	 *     index.php/api/logs/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function logs_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('personallogs_model', 'log');
		$this->load->helper('utility');
		
		$limit = ( ! $this->get('limit')) ? null : $this->get('limit');
		$limit = ( ! is_numeric($limit)) ? null : $limit;
		
		$offset = ( ! $this->get('offset')) ? 0 : $this->get('offset');
		$offset = ( ! is_numeric($offset)) ? 0 : $offset;
		
		$status = ( ! $this->get('status')) ? 'activated' : $this->get('status');
		$status = ($status == 'all') ? '' : $status;
		
		$user = ( ! $this->get('user')) ? null : $this->get('user');
		$user = ( ! is_numeric($user)) ? null : $user;
		
		$character = ( ! $this->get('character')) ? null : $this->get('character');
		$character = ( ! is_numeric($character)) ? null : $character;
		
		if ($character !== null)
		{
			$logs = $this->log->get_character_logs($character, $limit, $status);
		}
		elseif ($user !== null)
		{
			$logs = $this->log->get_user_logs($user, $limit, $status);
		}
		else
		{
			$logs = $this->log->get_log_list($limit, $offset, $status);
		}
		
		if ($logs->num_rows() > 0)
		{
			foreach ($logs->result() as $l)
			{
				$character = $this->char->get_character($l->log_author_character);
				
				$name = array(
					$this->ranks->get_rank($character->rank, 'rank_name'),
					$character->first_name,
					$character->last_name,
				);
				
				$output[] = array(
					'id' 		=> $l->log_id,
					'title' 	=> $l->log_title,
					'content'	=> $l->log_content,
					'tags' 		=> $l->log_tags,
					'status'	=> $l->log_status,
					'date'		=> mdate($this->_date_format, gmt_to_local($l->log_date, 'UTC')),
					'updated'	=> mdate($this->_date_format, gmt_to_local($l->log_last_update, 'UTC')),
					'character'	=> parse_name($name),
				);
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No personal logs could be found'), 404);
		}
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
	 * @since	1.0
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
	 * Get a news item from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/news/id/1
	 *     index.php/api/news/id/1/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function news_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('news_model', 'news');
		$this->load->helper('utility');
		
		if( ! $this->get('id'))
		{
			$this->response(null, 400);
		}
		
		$n = $this->news->get_news_item($this->get('id'));
		
		if ($n !== false)
		{
			if ($n->news_private != 'y')
			{
				$character = $this->char->get_character($n->news_author_character);
				
				$name = array(
					$this->ranks->get_rank($character->rank, 'rank_name'),
					$character->first_name,
					$character->last_name,
				);
				
				$output[] = array(
					'id' 		=> $n->news_id,
					'title' 	=> $n->news_title,
					'content'	=> $n->news_content,
					'tags' 		=> $n->news_tags,
					'category'	=> $this->news->get_news_category($n->news_cat, 'newscat_name'),
					'status'	=> $n->news_status,
					'date'		=> mdate($this->_date_format, gmt_to_local($n->news_date, 'UTC')),
					'updated'	=> mdate($this->_date_format, gmt_to_local($n->news_last_update, 'UTC')),
					'character'	=> parse_name($name),
				);
				
				$this->response($output, 200);
			}
			else
			{
				$this->response(array('error' => 'This version of the API does not allow accessing private news items.'), 403);
			}
		}
		else
		{
			$this->response(array('error' => 'News item could not be found'), 404);
		}
	}
	
	/**
	 * Get all news items from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/allnews
	 *     index.php/api/allnews/limit/25
	 *     index.php/api/allnews/limit/25/offset/50
	 *     index.php/api/allnews/status/saved
	 *     index.php/api/allnews/status/all
	 *     index.php/api/allnews/user/1
	 *     index.php/api/allnews/character/1
	 *     index.php/api/allnews/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function allnews_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('news_model', 'news');
		$this->load->helper('utility');
		
		$limit = ( ! $this->get('limit')) ? null : $this->get('limit');
		$limit = ( ! is_numeric($limit)) ? null : $limit;
		
		$offset = ( ! $this->get('offset')) ? 0 : $this->get('offset');
		$offset = ( ! is_numeric($offset)) ? 0 : $offset;
		
		$status = ( ! $this->get('status')) ? 'activated' : $this->get('status');
		$status = ($status == 'all') ? '' : $status;
		
		$user = ( ! $this->get('user')) ? null : $this->get('user');
		$user = ( ! is_numeric($user)) ? null : $user;
		
		$character = ( ! $this->get('character')) ? null : $this->get('character');
		$character = ( ! is_numeric($character)) ? null : $character;
		
		if ($character !== null)
		{
			$news = $this->news->get_character_news($character, $limit, $status);
		}
		elseif ($user !== null)
		{
			$news = $this->news->get_user_news($user, $limit, $status);
		}
		else
		{
			$news = $this->news->get_news_list($limit, $offset, $status);
		}
		
		if ($news->num_rows() > 0)
		{
			foreach ($news->result() as $n)
			{
				if ($n->news_private != 'y')
				{
					$character = $this->char->get_character($n->news_author_character);
					
					$name = array(
						$this->ranks->get_rank($character->rank, 'rank_name'),
						$character->first_name,
						$character->last_name,
					);
					
					$output[] = array(
						'id' 		=> $n->news_id,
						'title' 	=> $n->news_title,
						'content'	=> $n->news_content,
						'tags' 		=> $n->news_tags,
						'category'	=> $this->news->get_news_category($n->news_cat, 'newscat_name'),
						'status'	=> $n->news_status,
						'date'		=> mdate($this->_date_format, gmt_to_local($n->news_date, 'UTC')),
						'updated'	=> mdate($this->_date_format, gmt_to_local($n->news_last_update, 'UTC')),
						'character'	=> parse_name($name),
					);
				}
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No news items could be found'), 404);
		}
	}
	
	/**
	 * Get a mission post from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/missionpost/1
	 *     index.php/api/missionpost/1/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function missionpost_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('posts_model', 'post');
		$this->load->model('missions_model', 'mis');
		
		if( ! $this->get('id'))
		{
			$this->response(null, 400);
		}
		
		$p = $this->post->get_post($this->get('id'));
		
		if ($p !== false)
		{
			$authors = $this->char->get_authors($p->post_authors);
			
			$output[] = array(
				'id' 		=> $p->post_id,
				'title' 	=> $p->post_title,
				'timeline'	=> $p->post_timeline,
				'location'	=> $p->post_location,
				'content'	=> $p->post_content,
				'tags' 		=> $p->post_tags,
				'status'	=> $p->post_status,
				'date'		=> mdate($this->_date_format, gmt_to_local($p->post_date, 'UTC')),
				'updated'	=> mdate($this->_date_format, gmt_to_local($p->post_last_update, 'UTC')),
				'authors'	=> $authors,
				'mission'	=> array(
					'id'	=> $p->post_mission,
					'name'	=> $this->mis->get_mission($p->post_mission, 'mission_title'),
				),
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'Mission post could not be found'), 404);
		}
	}
	
	/**
	 * Get all the mission posts for a mission from the database.
	 *
	 * This method is accessible by anyone.
	 *
	 *     index.php/api/missionposts
	 *     index.php/api/missionposts/limit/25
	 *     index.php/api/missionposts/limit/25/offset/50
	 *     index.php/api/missionposts/status/saved
	 *     index.php/api/missionposts/order/asc
	 *     index.php/api/missionposts/mission/2
	 *     index.php/api/missionposts/user/1
	 *     index.php/api/missionposts/character/1
	 *     index.php/api/missionposts/format/json
	 *
	 * @access	public
	 * @since	1.0
	 */
	public function missionposts_get()
	{
		$this->load->model('characters_model', 'char');
		$this->load->model('posts_model', 'post');
		
		$limit = ( ! $this->get('limit')) ? null : $this->get('limit');
		$limit = ( ! is_numeric($limit)) ? null : $limit;
		
		$offset = ( ! $this->get('offset')) ? 0 : $this->get('offset');
		$offset = ( ! is_numeric($offset)) ? 0 : $offset;
		
		$status = ( ! $this->get('status')) ? 'activated' : $this->get('status');
		$status = ($status == 'all') ? '' : $status;
		
		$mission = ( ! $this->get('mission')) ? null : $this->get('mission');
		$mission = ( ! is_numeric($mission)) ? null : $mission;
		
		$order = ( ! $this->get('order')) ? 'desc' : $this->get('order');
		
		$user = ( ! $this->get('user')) ? null : $this->get('user');
		$user = ( ! is_numeric($user)) ? null : $user;
		
		$character = ( ! $this->get('character')) ? null : $this->get('character');
		$character = ( ! is_numeric($character)) ? null : $character;
		
		if ($character !== null)
		{
			$posts = $this->post->get_character_posts($character, $limit, $status);
		}
		elseif ($user !== null)
		{
			$posts = $this->post->get_user_posts($user, $limit, $status);
		}
		else
		{
			$posts = $this->post->get_post_list($mission, $order, $limit, $offset, $status);
		}
		
		if ($posts->num_rows() > 0)
		{
			foreach ($posts->result() as $p)
			{
				$authors = $this->char->get_authors($p->post_authors);
				
				$output[] = array(
					'id' 		=> $p->post_id,
					'title' 	=> $p->post_title,
					'timeline'	=> $p->post_timeline,
					'location'	=> $p->post_location,
					'content'	=> $p->post_content,
					'tags' 		=> $p->post_tags,
					'status'	=> $p->post_status,
					'date'		=> mdate($this->_date_format, gmt_to_local($p->post_date, 'UTC')),
					'updated'	=> mdate($this->_date_format, gmt_to_local($p->post_last_update, 'UTC')),
					'authors'	=> $authors,
					'mission'	=> array(
						'id'	=> $p->post_mission,
						'name'	=> $this->mis->get_mission($p->post_mission, 'mission_title'),
					),
				);
			}
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'No mission posts could be found'), 404);
		}
	}
	 
	/**
	 * Get a specific user from the database.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 * This method is not currently available in the API.
	 *
	 *     index.php/api/user/id/1
	 *     index.php/api/user/id/1/format/json
	 *
	 * @access	private
	 * @since	1.0
	 */
	private function user_get()
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
						'activated'			=> mdate($this->_date_format, gmt_to_local($a->date_activate, 'UTC')),
						'deactivated'		=> ( ! empty($a->date_deactivate)) ? mdate($this->_date_format, gmt_to_local($a->date_deactivate, 'UTC')) : '',
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
				'lastlogin'		=> ( ! empty($user->last_login)) ? mdate($this->_date_format, gmt_to_local($user->last_login, 'UTC')) : 'No login recorded',
				'lastpost'		=> ( ! empty($user->last_post)) ? mdate($this->_date_format, gmt_to_local($user->last_post, 'UTC')) : 'No post recorded',
			);
			
			$this->response($output, 200);
		}
		else
		{
			$this->response(array('error' => 'User could not be found'), 404);
		}
	}
	 
	/**
	 * Get all users from the database.
	 *
	 * This method requires authentication in order to return any data.
	 *
	 * This method is not currently available in the API.
	 *
	 *     index.php/api/users
	 *     index.php/api/users/status/pending
	 *     index.php/api/users/status/inactive
	 *     index.php/api/users/format/json
	 *     index.php/api/users/status/pending/format/json
	 *
	 * @access	private
	 * @since	1.0
	 */
	private function users_get()
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
		$status = ( ! in_array($status, $all_statuses)) ? 'active' : $status;
		
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
							'activated'			=> mdate($this->_date_format, gmt_to_local($a->date_activate, 'UTC')),
							'deactivated'		=> ( ! empty($a->date_deactivate)) ? mdate($this->_date_format, gmt_to_local($a->date_deactivate, 'UTC')) : '',
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
					'lastlogin'		=> ( ! empty($u->last_login)) ? mdate($this->_date_format, gmt_to_local($u->last_login, 'UTC')) : 'No login recorded',
					'lastpost'		=> ( ! empty($u->last_post)) ? mdate($this->_date_format, gmt_to_local($u->last_post, 'UTC')) : 'No posts recorded',
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
