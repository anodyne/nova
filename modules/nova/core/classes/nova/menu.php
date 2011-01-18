<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Menu Class
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */

abstract class Nova_Menu {
	
	/**
	 * Initializes the library and sets a debug message.
	 *
	 * *The base controller automatically initializes this class, so unless you're developing outside
	 * of the base controller, you do not need to initialize this class manually.*
	 *
	 * @return 	void
	 */
	public function __construct()
	{
		Kohana_Log::instance()->add('debug', 'Auth library initialized.');
	}
	
	/**
	 * The only entry point into the class. This method will call one of the private methods to do all
	 * the heavy lifting of generating the menus.
	 *
	 *     echo menu::build('sub', 'personnel');
	 *
	 * @param	string	the type of menu to build (main, sub, adminsub)
	 * @param	string	the category of menu to build
	 * @return 	mixed	an unordered list with all the menu items or false if an invalid type is supplied
	 */
	public static function build($type, $cat)
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
		
		return false;
	}
	
	private static function _build_main($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Jelly::query('menu')
			->where('type', '=', $type)
			->where('cat', '=', $cat)
			->where('display', '=', 'y')
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->select();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			return self::_render($type, $data);
		}
		
		return false;
	}
	
	private static function _build_sub($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Jelly::query('menu')
			->where('type', '=', $type)
			->where('cat', '=', $cat)
			->where('display', '=', 'y')
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->select();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			return self::_render($type, $data);
		}
		
		return false;
	}
	
	private static function _build_sub_admin($type = '', $cat = '')
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		# FIXME: need to convert this over from the core model (which no longer exists)
		
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
		
		return false;
	}
	
	private static function _render($type = '', $data = '')
	{
		$output = '<ul>';
		
		switch ($type)
		{
			case 'adminsub':
				foreach ($data as $key => $value)
				{
					if (isset($value['menu']) and count($value['menu']) > 0)
					{
						$output.= '<li class="menu-category">'. $value['name'] .'</li>';
						
						foreach ($value['menu'] as $item)
						{
							if ($item->group != 0 and $item->order == 0)
							{
								$output.= '<li class="spacer"></li>';
							}
							
							if ($item->linktype == 'offsite')
							{
								$target = ' target="_blank"';
								$link = $item->link;
							}
							else
							{
								$target = null;
								$link = url::site($item->link);
							}
							
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
							
							if (($item->useaccess == 'y' and $access === true and ($item->level > 0 and $level >= $item->level or $item->level == 0)) or $item->useaccess == 'n')
							{
								$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->name . '</span></a></li>';
							}
						}
						
						$output.= '<li class="spacer"></li>';
					}
				}
				
			break;
				
			case 'main':
				foreach ($data as $k => $item)
				{
					$display = false;
		
					if (($item->login == 'y' and Auth::is_logged_in()) or ($item->login == 'n' and ! Auth::is_logged_in()) or $item->login == 'none')
					{
						if ($item->login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
		
							if (($item->useaccess == 'y' and $access === true and ($item->level > 0 and $level >= $item->level or $item->level == 0)) or $item->useaccess == 'n')
							{
								$display = true;
							}
						}
						else
						{
							$display = true;
						}
					}
		
					if ($display === true)
					{
						$output.= '<li>';
						
						$class = array();
		
						if ($item->linktype == 'onsite')
						{
							$uri = explode('/', Request::current()->uri());
							$cur = explode('/', $item->link);
							
							if ($uri[0] == $cur[0])
							{
								$class[] = 'active';
							}
							
							$target = null;
							$url = url::site($item->link);
						}
						else
						{
							$target = ' target="_blank"';
							$url = $item->link;
						}
		
						// create a string from the array of classes
						$class_string = implode(' ', $class);
		
						$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $item->name .'</span></a></li>';
					}
				}
				
			break;
				
			case 'sub':
				foreach ($data as $item)
				{
					$display = false;
	
					if ($item->group != 0 and $item->order == 0)
					{
						$output.= '<li class="spacer"></li>';
					}
	
					if ($item->linktype == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->link;
					}
					else
					{
						$target = null;
						$link = url::site($item->link);
					}
	
					if (($item->login == 'y' and Auth::is_logged_in()) or ($item->login == 'n' and ! Auth::is_logged_in()) or $item->login == 'none')
					{
						if ($item->login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
	
							if (($item->useaccess == 'y' and $access === true and ($item->level > 0 and $level >= $item->level or $item->level == 0)) or $item->useaccess == 'n')
							{
								$display = true;
							}
						}
						else
						{
							$display = true;
						}
					}
	
					if ($display === true)
					{
						$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->name . '</span></a></li>';
					}
				}
			
			break;
		}
		
		$output.= '</ul>';
		
		return $output;
	}
}
