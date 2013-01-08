<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User panel library
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_user_panel {
	
	protected $_ci;
	
	public function __construct()
	{
		$this->_ci =& get_instance();
		
		// load the nova core module
		$this->_ci->load->module('core', 'nova', MODPATH);
		
		log_message('debug', 'User Panel Library Initialized');
	}
	
	public function panel_1()
	{
		$this->_ci->load->model('privmsgs_model', 'pm');
		
		// run the methods
		$user = $this->_ci->user->get_user($this->_ci->session->userdata('userid'));
		$count = $this->_ci->pm->count_pms($this->_ci->session->userdata('userid'), 'unread');
		
		$data['count'] = ($count > 0) ? ' <strong>('. $count .')</strong>' : false;
		$data['name'] = ($user !== false) ? $user->name : '';
		
		$data['label'] = array(
			'edit_account' => ucwords(lang('actions_edit') .' '. lang('labels_account')),
			'edit_prefs' => ucwords(lang('actions_edit') .' '. lang('labels_site') .' '. lang('labels_preferences')),
			'private_messages' => ucwords(lang('global_privatemessages')),
			'request_loa' => ucwords(lang('actions_request') .' '. lang('abbr_loa')),
		);
		
		// load the view into a string
		$view = $this->_ci->nova->view('_base/ajax/userpanel_1', $data, true);
		
		return $view;
	}
	
	public function panel_2()
	{
		// run the methods
		$characters = $this->_ci->session->userdata('characters');
		
		// set the variables
		$data = array();
		
		if ($characters)
		{
			foreach ($characters as $char)
			{
				$data['panel_characters'][] = array(
					'id' => $char,
					'name' => $this->_ci->char->get_character_name($char, true, true)
				);
			}
		}
		
		$data['label'] = array(
			'characters' => ucfirst(lang('global_characters')),
		);
		
		// load the view into a string
		$view = $this->_ci->nova->view('_base/ajax/userpanel_2', $data, true);
		
		return $view;
	}
	
	public function panel_3()
	{
		$data['panel_my_links'] = $this->_ci->session->userdata('my_links');
		
		$data['label'] = array(
			'links' => ucwords(lang('labels_my') .' '. lang('labels_links')),
		);
		
		// load the view into a string
		$view = $this->_ci->nova->view('_base/ajax/userpanel_3', $data, true);
		
		return $view;
	}
	
	public function panel_workflow()
	{
		$this->_ci->load->model('privmsgs_model', 'pm');
		$this->_ci->load->model('posts_model', 'posts');
		$this->_ci->load->model('personallogs_model', 'logs');
		$this->_ci->load->model('news_model', 'news');
		
		$data['unreadpm'] = $this->_ci->pm->count_pms($this->_ci->session->userdata('userid'), 'unread');
		$data['unreadpm_icon'] = ($data['unreadpm'] > 0) ? 'green' : 'gray';
		
		if (is_array($this->_ci->session->userdata('characters')) and count($this->_ci->session->userdata('characters')) > 0)
		{
			$data['unreadjp'] = $this->_ci->posts->count_unattended_posts($this->_ci->session->userdata('characters'));
			$posts = $this->_ci->posts->count_character_posts($this->_ci->session->userdata('characters'), 'saved');
		}
		else
		{
			$data['unreadjp'] = 0;
			$posts = 0;
		}
		
		$logs = $this->_ci->logs->count_user_logs($this->_ci->session->userdata('userid'), 'saved');
		$news = $this->_ci->news->count_user_news($this->_ci->session->userdata('userid'), 'saved');
		
		$data['saveditems'] = $posts + $logs + $news;
		
		$data['unreadjp_icon'] = ($data['saveditems'] > 0) ? 'yellow' : 'gray';
		$data['unreadjp_icon'] = ($data['unreadjp'] > 0) ? 'green' : $data['unreadjp_icon'];
		
		$data['icons'] = array(
			'green' => array(
				'src' => Location::asset('images', 'icon-green.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
			'gray' => array(
				'src' => Location::asset('images', 'icon-gray.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
			'yellow' => array(
				'src' => Location::asset('images', 'icon-yellow.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
		);
		
		$data['label'] = array(
			'dashboard' => ucfirst(lang('labels_dashboard')),
			'inbox' => ucfirst(lang('labels_inbox')),
			'writing' => ucwords(lang('labels_writing') .' '. lang('labels_entries')),
		);
		
		// load the view into a string
		$view = $this->_ci->nova->view('_base/ajax/userpanel_workflow', $data, true);
		
		return $view;
	}
	
	public function workflow_dashboard($text = true, $content = '')
	{
		$output = '<a href="#" id="userpanel" title="'. ucfirst(lang('labels_dashboard')) .'"><span>';
		
		if ( ! empty($content))
		{
			$output.= $content;
		}
		elseif (empty($content) and $text)
		{
			$output.= ucfirst(lang('labels_dashboard'));
		}
		
		$output.= '</span></a>';

		return $output;
	}
	
	public function workflow_inbox($icon = true, $text = true, $count = true, $count_dec = '(x)', $content = '')
	{
		$this->_ci->load->model('privmsgs_model', 'pm');
		
		$unread = $this->_ci->pm->count_pms($this->_ci->session->userdata('userid'), 'unread');
		
		$icons = array(
			'green' => array(
				'src' => Location::asset('images', 'icon-green.png'),
				'alt' => '',
				'class' => 'image',
				'id' => 'workflow-inbox-notifier'),
			'gray' => array(
				'src' => Location::asset('images', 'icon-gray.png'),
				'alt' => '',
				'class' => 'image',
				'id' => 'workflow-inbox-notifier'),
		);
		
		$output = '<a href="'. site_url('messages/index') .'" title="'. ucfirst(lang('labels_inbox')) .'"><span>';
		
		if ($icon)
		{
			if ($unread > 0)
			{
				$output.= img($icons['green']);
			}
			else
			{
				$output.= img($icons['gray']);
			}
		}
		
		if ( ! empty($content))
		{
			$output.= ' '. $content;
		}
		elseif (empty($content) and $text)
		{
			$output.= ' '. ucfirst(lang('labels_inbox'));
		}
		
		if ($count and $unread > 0)
		{
			$string = str_replace('x', $unread, $count_dec);
			$output.= ' '. $string;
		}
		
		$output.= '</span></a>';
		
		return $output;
	}
	
	public function workflow_writing($icon = true, $text = true, $count = true, $count_dec = '(x)', $content = '')
	{
		$this->_ci->load->model('posts_model', 'posts');
		$this->_ci->load->model('personallogs_model', 'logs');
		$this->_ci->load->model('news_model', 'news');
		
		$icons = array(
			'green' => array(
				'src' => Location::asset('images', 'icon-green.png'),
				'alt' => '',
				'class' => 'image',
				'id' => 'workflow-writing-notifier'),
			'gray' => array(
				'src' => Location::asset('images', 'icon-gray.png'),
				'alt' => '',
				'class' => 'image',
				'id' => 'workflow-writing-notifier'),
			'yellow' => array(
				'src' => Location::asset('images', 'icon-yellow.png'),
				'alt' => '',
				'class' => 'image',
				'id' => 'workflow-writing-notifier'),
		);
		
		if (is_array($this->_ci->session->userdata('characters')) and count($this->_ci->session->userdata('characters')) > 0)
		{
			$unreadjp = $this->_ci->posts->count_unattended_posts($this->_ci->session->userdata('characters'));
			$posts = $this->_ci->posts->count_character_posts($this->_ci->session->userdata('characters'), 'saved');
		}
		else
		{
			$unreadjp = 0;
			$posts = 0;
		}
		
		$logs = $this->_ci->logs->count_user_logs($this->_ci->session->userdata('userid'), 'saved');
		$news = $this->_ci->news->count_user_news($this->_ci->session->userdata('userid'), 'saved');
		
		$saveditems = $posts + $logs + $news;
		
		$output = '<a href="'. site_url('write/index') .'" title="'. ucwords(lang('labels_writing') .' '. lang('labels_entries')) .'"><span>';
		
		if ($icon)
		{
			$icon_status = ($saveditems > 0) ? 'yellow' : 'gray';
			$icon_status = ($unreadjp > 0) ? 'green' : $icon_status;
			
			$output.= img($icons[$icon_status]);
		}
		
		if ( ! empty($content))
		{
			$output.= ' '. $content;
		}
		elseif (empty($content) and $text)
		{
			$output.= ' '. ucwords(lang('labels_writing') .' '. lang('labels_entries'));
		}
		
		if ($count and $saveditems > 0)
		{
			$string = str_replace('x', $unread, $count_dec);
			$output.= ' '. $string;
		}
		
		$output.= '</span></a>';
		
		return $output;
	}
}
