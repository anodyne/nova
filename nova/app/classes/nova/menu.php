<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Menu class handles building and rendering all of the menus found in the
 * system.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 */

abstract class Nova_Menu {
	
	public static function classic($type, $cat)
	{
		return self::_classic($type, $cat);
	}
	
	public static function dropdown($type)
	{
		switch ($type)
		{
			case 'main':
				$menu = self::_dropdown_main();
			break;
			
			case 'admin':
				$menu = self::_dropdown_admin();
			break;
		}
		
		return $menu;
	}
	
	/**
	 * The only entry point into the class. This method will call one of the
	 * private methods to do all the heavy lifting of generating the menus.
	 *
	 * @access	protected
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @param	string	the type of menu to build (main, sub, adminsub)
	 * @param	string	the category of menu to build
	 * @return 	mixed	an unordered list with all the menu items or false if an invalid type is supplied
	 */
	protected static function _classic($type, $cat)
	{
		// get an instance of the cache module
		$cache = Cache::instance();
		
		switch ($type)
		{
			case 'main':
				$menu = self::_build_main();
			break;
				
			case 'sub':
				$menu = ($cache->get('menu_sub_'.$cat)) ? $cache->get('menu_sub_'.$cat) : self::_build_sub($cat);
			break;
				
			case 'adminsub':
				$menu = ($cache->get('menu_adminsub')) ? $cache->get('menu_adminsub') : self::_build_sub_admin($cat);
			break;
			
			case 'adminsidebar':
				$menu = self::_build_sub_admin_sidebar();
			break;
			
			default:
				$menu = false;
			break;
		}
		
		return $menu;
	}
	
	protected static function _dropdown_main()
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'main')
			->where('display', (int) true)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			return self::_render('main_dropdown', $items);
		}
		
		return false;
	}
	
	protected static function _dropdown_admin()
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'main')
			->where('display', (int) true)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			return self::_render('main_dropdown', $items);
		}
		
		return false;
	}
	
	/**
	 * Build Nova's main menu.
	 *
	 * @access	protected
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	protected static function _build_main()
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'main')
			->where('display', (int) true)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			// render the final output
			$final = self::_render('main', $data);
			
			return $final;
		}
		
		return false;
	}
	
	/**
	 * Build Nova's sub navigation menu.
	 *
	 * @access	protected
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @uses	Cache::set
	 * @param	string	the category of sub navigation to pull
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	protected static function _build_sub($cat, $render = true)
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'sub')
			->where('category', $cat)
			->where('display', (int) true)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			if ($render)
			{
				// render the final output
				$final = self::_render('sub', $data);
				
				// if the sub menu isn't cached, cache it
				if ( ! Cache::instance()->get('menu_sub_'.$cat))
				{
					Cache::instance()->set('menu_sub_'.$cat, $final);
				}
				
				return $final;
			}
			
			return $data;
		}
		
		return false;
	}
	
	/**
	 * Build Nova's admin sub navigation menu.
	 *
	 * @access	protected
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Jelly::query
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @uses	Cache::set
	 * @param	string	the category admin sub navigation to pull
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	protected static function _build_sub_admin($cat)
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
			
			return self::_render('adminsub', $data);
		}
		
		return false;
	}
	
	/**
	 * Build Nova's admin sidebar.
	 *
	 * @access	protected
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	protected static function _build_sub_admin_sidebar()
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_MenuCat::find()->where('type', 'adminsub')->get();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			// render the final output
			$final = self::_render('adminsidebar', $data);
			
			return $final;
		}
		
		return false;
	}
	
	/**
	 * Render the specified menu.
	 *
	 * @access	protected
	 * @uses	Auth::check_access
	 * @uses	Auth::get_access_level
	 * @uses	Auth::is_logged_in
	 * @uses	Request::current
	 * @uses	Request::uri
	 * @uses	Url::site
	 * @param	string	the type of menu to render
	 * @param	mixed	the data to use for the menu render
	 * @return	string	the menu output
	 */
	protected static function _render($type, $data)
	{
		switch ($type)
		{
			case 'adminsidebar':
				$output = '<ul>';
				
				foreach ($data as $k => $item)
				{
					// set the link to the landing page
					$link = Url::site($item->landing_page);
					
					// grab the current URI and throw it into an array
					$uri = explode('/', Request::current()->uri());
					
					// empty array of classes to add
					$class = array();
					
					// figure out which key of the array to use
					$key = (int) (count($uri) >= 3);
					
					if ($uri[$key] == $item->category)
					{
						$class[] = 'active';
					}
					
					// set the class string
					$class_string = implode(' ', $class);
					
					// set the output
					$output.= '<li><a href="'.$link.'" rel="'.$item->category.'" class="'.$class_string.'">';
					$output.= '<span class="navicn navicn-'.$item->category.'"></span>'.$item->name.'</a></li>';
				}
				
				$output.= '</ul>';
			break;
			
			case 'adminsub':
				$output = '<ul>';
				
				foreach ($data as $key => $value)
				{
					if (isset($value['menu']) and count($value['menu']) > 0)
					{
						$output.= '<li class="menu-category">'. $value['name'] .'</li>';
						
						foreach ($value['menu'] as $item)
						{
							if ($item->group != 0 and $item->menu_order == 0)
							{
								$output.= '<li class="spacer"></li>';
							}
							
							if ($item->url_target == 'offsite')
							{
								$target = ' target="_blank"';
								$link = $item->url;
							}
							else
							{
								$target = null;
								$link = url::site($item->url);
							}
							
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
							
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
							{
								$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->name . '</span></a></li>';
							}
						}
						
						$output.= '<li class="spacer"></li>';
					}
				}
				
				$output.= '</ul>';
			break;
				
			case 'main':
				$output = '<ul>';
				
				foreach ($data as $k => $item)
				{
					$display = false;
		
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
		
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
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
		
						if ($item->url_target == 'onsite')
						{
							$uri = (Request::current()->uri() == '/') ? array(0 => 'main') : explode('/', Request::current()->uri());
							$cur = explode('/', $item->url);
							
							if ($uri[0] == $cur[0])
							{
								$class[] = 'active';
							}
							
							$target = null;
							$url = Url::site($item->url);
						}
						else
						{
							$target = ' target="_blank"';
							$url = $item->url;
						}
		
						// create a string from the array of classes
						$class_string = implode(' ', $class);
		
						$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $item->name .'</span></a></li>';
					}
				}
				
				$output.= '</ul>';
			break;
				
			case 'sub':
				$output = '<ul>';
				
				foreach ($data as $item)
				{
					$display = false;
	
					if ($item->group != 0 and $item->order == 0)
					{
						$output.= '<li class="spacer"></li>';
					}
	
					if ($item->url_target == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->url;
					}
					else
					{
						$target = null;
						$link = Url::site($item->url);
					}
	
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
	
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
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
				
				$output.= '</ul>';
			break;
			
			case 'sub_dropdown':
				$output = '<ul class="dropdown-menu">';
				
				foreach ($data as $item)
				{
					$display = false;
	
					if ($item->group != 0 and $item->order == 0)
					{
						$output.= '<li class="divider"></li>';
					}
	
					if ($item->url_target == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->url;
					}
					else
					{
						$target = null;
						$link = Url::site($item->url);
					}
	
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
	
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
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
				
				$output.= '</ul>';
			break;
			
			case 'main_dropdown':
				$output = '<ul>';
				
				foreach ($data as $item)
				{
					$display = false;
		
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
		
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
							{
								$display = true;
							}
						}
						else
						{
							$display = true;
						}
					}
					
					// get the menu items
					$subs = self::_build_sub($item->category, false);
		
					if ($display === true)
					{
						$output.= ($subs) ? '<li class="dropdown" data-dropdown="dropdown">' : '<li>';
						
						$class = array();
		
						if ($item->url_target == 'onsite')
						{
							$uri = (Request::current()->uri() == '/') ? array(0 => 'main') : explode('/', Request::current()->uri());
							$cur = explode('/', $item->url);
							
							if ($uri[0] == $cur[0])
							{
								$class[] = 'active';
							}
							
							if ($subs)
							{
								$class[] = 'dropdown-toggle';
							}
							
							$target = null;
							$url = Url::site($item->url);
						}
						else
						{
							$target = ' target="_blank"';
							$url = $item->url;
						}
		
						// create a string from the array of classes
						$class_string = implode(' ', $class);
		
						$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $item->name .'</span></a>';
						
						if ($subs)
						{
							$output.= self::_render('sub_dropdown', $subs);
						}
						
						$output.= '</li>';
					}
				}
				
				$output.= '</ul>';
			break;
		}
		
		return $output;
	}
}
