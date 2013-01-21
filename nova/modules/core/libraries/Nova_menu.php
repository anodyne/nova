<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Menu library
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_menu {
    
	/**
	 * The type of menu to build. Options are main, sub, adminsub
	 */
	public static $type;
	
	/**
	 * The category of menu to build. Options are main, personnel, sim,
	 * wiki, acp, site, manage, reports, user, write, messages
	 */
	public static $cat;
	
	/**
	 * The final output of the menu
	 */
	public static $output;
    
	public function __construct()
	{
		log_message('debug', 'Menu Library Initialized');
	}
	
	public static function build($type, $cat)
	{
		// get an instance of CI
		$ci =& get_instance();
		
		self::$type = $type;
		self::$cat = $cat;
		
		switch (self::$type)
		{
			case 'main':
				self::_build_main();
			break;
				
			case 'sub':
				self::_build_sub();
			break;
				
			case 'adminsub':
				self::_build_sub_admin();
			break;
		}
		
		return self::$output;
	}
	
	protected static function _build_main()
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		/* load the session library and assign the user id */
		$ci->load->library('session');
		$userid = $ci->session->userdata('userid');
		
		/* load the menu model */
		$ci->load->model('menu_model');
		
		/* get the headers then get the data below the headers */
		$items = $ci->menu_model->get_menu_items(self::$type, self::$cat);
		
		$segment = array();
		
		if ($items->num_rows() > 0)
		{
			foreach ($items->result() as $item)
			{
				$array[$item->menu_order]['name'] = $item->menu_name;
				$array[$item->menu_order]['login'] = $item->menu_need_login;
				$array[$item->menu_order]['link'] = $item->menu_link;
				$array[$item->menu_order]['link_type'] = $item->menu_link_type;
				$array[$item->menu_order]['access'] = $item->menu_access;
				$array[$item->menu_order]['use_access'] = $item->menu_use_access;
				$array[$item->menu_order]['level'] = $item->menu_access_level;
				
				/* get an array of the URI segments */
				$seg = explode('/', $item->menu_link);
				
				/* set the active element */
				$array[$item->menu_order]['active'] = $seg[0];
			}
		}
		
		/* start the output */
		self::$output = '<ul>';
		
		foreach ($array as $k => $v)
		{
			$display = FALSE;
			
			if (($v['login'] == 'y' && Auth::is_logged_in()) || ($v['login'] == 'n' && Auth::is_logged_in() === FALSE) || $v['login'] == 'none')
			{
				if ($v['login'] == 'y')
				{
					$access = Auth::check_access($v['access'], FALSE);
					$level = Auth::get_access_level($v['access']);
					
					if (($v['use_access'] == 'y' && $access === TRUE && ($v['level'] > 0 && $level >= $v['level'] || $v['level'] == 0)) || $v['use_access'] == 'n')
					{
						$display = TRUE;
					}
				}
				else
				{
					$display = TRUE;
				}
			}
			
			if ($display === TRUE)
			{
				self::$output.= '<li>';
			
				$class = array();
			
				if ($v['active'] == $ci->uri->rsegment(1))
				{
					$class[] = 'active';
				}
			
				if ($v['link_type'] == 'onsite')
				{
					$target = NULL;
					$url = site_url($v['link']);
				}
				else
				{
					$target = ' target="_blank"';
					$url = $v['link'];
				}
			
				/* create a string from the array of classes */
				$class_string = implode(' ', $class);
			
				self::$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $v['name'] .'</span></a></li>';
			}
		}
			
		self::$output.= '</ul>'; /* close the menu item UL */
	}
	
	protected static function _build_sub()
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		/* load the session library and assign the user id */
		$ci->load->library('session');
		$userid = $ci->session->userdata('userid');
		
		/* load the menu model */
		$ci->load->model('menu_model');
		
		/* get the headers then get the data below the headers */
		$menu_items = $ci->menu_model->get_menu_items(self::$type, self::$cat);
		
		if ($menu_items->num_rows() > 0)
		{
			self::$output = '<ul>'; /* start the output of the menu */
			
			foreach ($menu_items->result() as $item)
			{
				$display = FALSE;
				
				if ($item->menu_group != 0 && $item->menu_order == 0)
				{
					self::$output.= '<li class="spacer"></li>';
				}
				
				if ($item->menu_link_type == 'offsite')
				{
					$target = ' target="_blank"';
					$link = $item->menu_link;
				}
				else
				{
					$target = NULL;
					$link = site_url($item->menu_link);
				}
				
				if (($item->menu_need_login == 'y' && Auth::is_logged_in()) || ($item->menu_need_login == 'n' && Auth::is_logged_in() === FALSE) || $item->menu_need_login == 'none')
				{
					if ($item->menu_need_login == 'y')
					{
						$access = Auth::check_access($item->menu_access, FALSE);
						$level = Auth::get_access_level($item->menu_access);
						
						if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
						{
							$display = TRUE;
						}
					}
					else
					{
						$display = TRUE;
					}
				}
				
				if ($display === TRUE)
				{
					self::$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
				}
			} /* close the item foreach */
			
			self::$output.= '</ul>'; /* close the menu output */
		} /* close the num_rows check */
	}
	
	protected static function _build_sub_admin()
	{
		/* get an instance of CI */
		$ci =& get_instance();
		
		/* load the menu model */
		$ci->load->model('menu_model');
		
		/* get the categories */
		$categories = $ci->menu_model->get_menu_categories('adminsub');
		
		/* grab the menu items */
		$menu = $ci->menu_model->get_admin_menu(self::$type);
		
		$retval = array();
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $cat)
			{
				$retval[$cat->menucat_menu_cat]['name'] = $cat->menucat_name;
				
				if ($menu->num_rows() > 0)
				{
					foreach ($menu->result() as $item)
					{
						if ($item->menu_cat == $cat->menucat_menu_cat)
						{
							$access = Auth::check_access($item->menu_access, FALSE);
							$level = Auth::get_access_level($item->menu_access);
							
							if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
							{
								$retval[$cat->menucat_menu_cat]['menu'][] = $item;
							}
						}
					}
				}
			}
		}
		
		self::_render($retval);
	}
	
	protected static function _render($data)
	{
		self::$output = '<ul>';
		
		foreach ($data as $key => $value)
		{
			if (isset($value['menu']) && count($value['menu']) > 0)
			{
				self::$output.= '<li class="menu_category">'. $value['name'] .'</li>';
				
				foreach ($value['menu'] as $item)
				{
					if ($item->menu_group != 0 && $item->menu_order == 0)
					{
						self::$output.= '<li class="spacer"></li>';
					}
					
					if ($item->menu_link_type == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->menu_link;
					}
					else
					{
						$target = NULL;
						$link = site_url($item->menu_link);
					}
					
					$access = Auth::check_access($item->menu_access, FALSE);
					$level = Auth::get_access_level($item->menu_access);
					
					if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
					{
						self::$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
					}
				}
				
				self::$output.= '<li class="spacer"></li>';
			}
		}
		
		self::$output.= '</ul>';
	}
}
