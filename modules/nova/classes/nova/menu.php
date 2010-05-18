<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Menu Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Menu
{    
	public function __construct()
	{
		Kohana_Log::Instance()->add('debug', 'Auth library initialized.');
	}
	
	public static function build($type = '', $cat = '')
	{
		switch ($type)
		{
			case 'main':
				return self::_build_main($type, $cat);
				break;
				
			case 'sub':
				return self::_build_sub($type, $cat);
				break;
				
			case 'adminsub':
				return self::_build_sub_admin($type, $cat);
				break;
		}
		
		return FALSE;
	}
	
	private static function _build_main($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// load the core model
		$mCore = new Model_Core;
		
		// build the arguments
		$args = array(
			'where' => array(
				array(
					'field' => 'menu_type',
					'value' => $type),
				array(
					'field' => 'menu_cat',
					'value' => $cat),
				array(
					'field' => 'menu_display',
					'value' => 'y'),
			),
			'order_by' => array(
				array('menu_group', 'asc'),
				array('menu_order', 'asc'),
			)
		);
		$items = $mCore->get_all('menu_items', $args);
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->menu_order] = $item;
			}
			
			return self::_render($type, $data);
		}
		
		return FALSE;
	}
	
	private static function _build_sub($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// load the core model
		$mCore = new Model_Core;
		
		// build the arguments
		$args = array(
			'where' => array(
				array(
					'field' => 'menu_type',
					'value' => $type),
				array(
					'field' => 'menu_cat',
					'value' => $cat),
				array(
					'field' => 'menu_display',
					'value' => 'y'),
			),
			'order_by' => array(
				array('menu_group', 'asc'),
				array('menu_order', 'asc'),
			)
		);
		$items = $mCore->get_all('menu_items', $args);
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->menu_order] = $item;
			}
			
			return self::_render($type, $data);
		}
		
		return FALSE;
	}
	
	private static function _build_sub_admin($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// load the core model
		$mCore = new Model_Core;
		
		// build the arguments
		$args = array(
			'where' => array(
				array(
					'field' => 'menucat_type',
					'value' => $type),
			),
			'order_by' => array(
				array('menucat_order', 'asc'),
			)
		);
		$categories = $mCore->get_all('menu_categories', $args);
		
		// clear the arguments array
		$args = array();
		
		// build the arguments
		$args = array(
			'join' => array(
				array('menu_categories', 'menu_categories.menucat_menu_cat', 'menu_items.menu_cat', ''),
			),
			'where' => array(
				array(
					'field' => 'menu_type',
					'value' => $type),
				array(
					'field' => 'menu_display',
					'value' => 'y'),
			),
			'order_by' => array(
				'menu_group' => 'asc',
				'menu_order' => 'asc'
			)
		);
		$items = $mCore->get_all('menu_items', $args);
		
		if ($categories)
		{
			foreach ($categories as $c)
			{
				$data[$c->menucat_menu_cat]['name'] = $c->menucat_name;
				
				if ($items)
				{
					foreach ($items as $item)
					{
						if ($c->menucat_menu_cat == $item->menu_cat)
						{
							$data[$c->menucat_menu_cat]['menu'][] = $item;
						}
					}
				}
			}
			
			return self::_render($type, $data);
		}
		
		return FALSE;
	}
	
	private static function _render($type = '', $data = '')
	{
		$output = '<ul>';
		
		switch ($type)
		{
			case 'adminsub':
				foreach ($data as $key => $value)
				{
					if (isset($value['menu']) && count($value['menu']) > 0)
					{
						$output.= '<li class="menu-category">'. $value['name'] .'</li>';
						
						foreach ($value['menu'] as $item)
						{
							if ($item->menu_group != 0 && $item->menu_order == 0)
							{
								$output.= '<li class="spacer"></li>';
							}
							
							if ($item->menu_link_type == 'offsite')
							{
								$target = ' target="_blank"';
								$link = $item->menu_link;
							}
							else
							{
								$target = NULL;
								$link = url::site($item->menu_link);
							}
							
							$access = Auth::check_access($item->menu_access, FALSE);
							$level = Auth::get_access_level($item->menu_access);
							
							if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
							{
								$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
							}
						}
						
						$output.= '<li class="spacer"></li>';
					}
				}
				
				break;
				
			case 'main':
				foreach ($data as $k => $item)
				{
					$display = FALSE;
		
					if (($item->menu_need_login == 'y' && Auth::is_logged_in()) || ($item->menu_need_login == 'n' && !Auth::is_logged_in()) || $item->menu_need_login == 'none')
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
						$output.= '<li>';
						
						$class = array();
		
						if ($item->menu_link_type == 'onsite')
						{
							$uri = explode('/', Request::Instance()->uri());
							$cur = explode('/', $item->menu_link);
							
							if ($uri[0] == $cur[0])
							{
								$class[] = 'active';
							}
							
							$target = NULL;
							$url = url::site($item->menu_link);
						}
						else
						{
							$target = ' target="_blank"';
							$url = $item->menu_link;
						}
		
						// create a string from the array of classes
						$class_string = implode(' ', $class);
		
						$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $item->menu_name .'</span></a></li>';
					}
				}
				
				break;
				
			case 'sub':
				foreach ($data as $item)
				{
					$display = FALSE;
	
					if ($item->menu_group != 0 && $item->menu_order == 0)
					{
						$output.= '<li class="spacer"></li>';
					}
	
					if ($item->menu_link_type == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->menu_link;
					}
					else
					{
						$target = NULL;
						$link = url::site($item->menu_link);
					}
	
					if (($item->menu_need_login == 'y' && Auth::is_logged_in()) || ($item->menu_need_login == 'n' && !Auth::is_logged_in()) || $item->menu_need_login == 'none')
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
						$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
					}
				}
			
				break;
		}
		
		$output.= '</ul>';
		
		return $output;
	}
}

// End of file menu.php
// Location: modules/nova/classes/nova/menu.php