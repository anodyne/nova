<?php
/**
 * The Nav class provides an interface for generating navigation
 * menus out of the database, including managing the caching of
 * the navigation for faster load speeds.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Nav
{
	/**
	 * @var	array	an array of data for the main nav
	 */
	protected static $_data_main;

	/**
	 * @var	array	an array of data for the admin nav
	 */
	protected static $_data_admin;

	/**
	 * @var	array	an array of data for the sub nav
	 */
	protected static $_data_sub;

	/**
	 * @var	string	the final output of the nav
	 */
	protected static $_output;

	/**
	 * Display the navigation item requested.
	 *
	 * @api
	 * @param	string	the style of nav to display (classic, dropdown, user)
	 * @param	string	the type of nav to display (main, sub)
	 * @param	string	the category of nav to display (main, personnel, sim, etc.)
	 * @return	string
	 */
	public static function display($style, $type, $category)
	{
		if ($style == 'classic' or $style == 'dropdown')
		{
			switch ($type)
			{
				case 'admin':
					// generate the data
					static::_gather_admin_nav_data();

					// generate the nav
					static::_generate_dropdown_nav(static::$_data_admin, 'adminsub');
				break;

				case 'main':
					// generate the data
					static::_gather_main_nav_data();

					if ($style == 'classic')
					{
						// generate the classic menu
						static::_generate_classic_main_nav();
					}
					elseif ($style == 'dropdown')
					{
						// generate the classic menu
						static::_generate_dropdown_nav(static::$_data_main);
					}
				break;

				case 'sub':
					// generate the data
					static::_gather_sub_nav_data($category);

					if ($style == 'classic')
					{
						// generate the classic menu
						static::_generate_classic_sub_nav();
					}
				break;
			}
		}
		elseif ($style == 'user')
		{
			// generate the user nav
			static::_generate_user_nav();
		}

		return static::$_output;
	}

	/**
	 * Gather the data for the admin nav and store it in the class.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _gather_admin_nav_data()
	{
		// get the items
		static::$_data_admin = \Model_Nav::get_nav_items('admin', false);

		// loop through the items
		foreach (static::$_data_admin as $key => $item)
		{
			if (($item->needs_login == 'y' and \Sentry::check() === false) or ($item->needs_login == 'n' and \Sentry::check() === true))
			{
				unset(static::$_data_admin[$key]);
			}

			if ( ! empty($item->access))
			{
				// get the access info for the nav item
				$navaccess = explode('|', $item->access);

				// find if the user has access
				$access = \Sentry::user()->has_access("$navaccess[0].$navaccess[1]");

				// find if the user has the proper level
				$level = \Sentry::user()->atleast_level("$navaccess[0].$navaccess[1]", $navaccess[2]);

				if ($access === false or ($access === true and $level === false))
				{
					unset(static::$_data_admin[$key]);
				}
			}
		}
	}

	/**
	 * Gather the data for the main nav and store it in the class.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _gather_main_nav_data()
	{
		// get the items
		static::$_data_main = \Model_Nav::get_nav_items('main', false);

		// loop through the items
		foreach (static::$_data_main as $key => $item)
		{
			if (($item->needs_login == 'y' and \Sentry::check() === false) or ($item->needs_login == 'n' and \Sentry::check() === true))
			{
				unset(static::$_data_main[$key]);
			}

			if ( ! empty($item->access))
			{
				// get the access info for the nav item
				$navaccess = explode('|', $item->access);

				// find if the user has access
				$access = \Sentry::user()->has_access("$navaccess[0].$navaccess[1]");

				// find if the user has the proper level
				$level = \Sentry::user()->atleast_level("$navaccess[0].$navaccess[1]", $navaccess[2]);

				if ($access === false or ($access === true and $level === false))
				{
					unset(static::$_data_main[$key]);
				}
			}
		}
	}

	/**
	 * Gather the data for the sub nav and store it in the class.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _gather_sub_nav_data($category)
	{
		// get the items
		static::$_data_sub = \Model_Nav::get_nav_items('sub', $category);

		// loop through the items
		foreach (static::$_data_sub as $key => $item)
		{
			if (($item->needs_login == 'y' and \Sentry::check() === false) or ($item->needs_login == 'n' and \Sentry::check() === true))
			{
				unset(static::$_data_main[$key]);
			}

			if ( ! empty($item->access))
			{
				// get the access info for the nav item
				$navaccess = explode('|', $item->access);

				// find if the user has access
				$access = \Sentry::user()->has_access("$navaccess[0].$navaccess[1]");

				// find if the user has the proper level
				$level = \Sentry::user()->atleast_level("$navaccess[0].$navaccess[1]", $navaccess[2]);

				if ( ! $level)
				{
					unset(static::$_data_sub[$key]);
				}
			}
		}
	}

	/**
	 * Generate the classic main navigation.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _generate_classic_main_nav()
	{
		// open the nav
		$output = '<ul class="nav">';

		foreach (static::$_data_main as $item)
		{
			// get the url segments
			$segments = explode('/', $item->url);

			// get the first item of the URI
			$first = strtolower(\Uri::segment(1));

			// class output
			$active_output = ($segments[0] == $first) ? ' class="active"' : false;

			// figure out what should be shown
			$target_output = ($item->url_target == 'offsite') ? ' target="_blank"' : false;

			// generate the output for the nav item
			$output.= '<li'.$active_output.'><a href="'.\Uri::create($item->url).'"'.$target_output.'>'.$item->name.'</a></li>';
		}

		// close the nav
		$output.= '</ul>';

		// send the final output to the class
		static::$_output = $output;
	}

	/**
	 * Generate the classic sub navigation.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _generate_classic_sub_nav()
	{
		// open the nav
		$output = '<ul>';

		foreach (static::$_data_sub as $item)
		{
			if ($item->order == 0 and $item->group != 0)
			{
				$output.= '<li class="divider">';
			}

			// figure out what should be shown
			$target_output = ($item->url_target == 'offsite') ? ' target="_blank"' : false;

			// generate the output for the nav item
			$output.= '<li><a href="'.\Uri::create($item->url).'"'.$target_output.'>'.$item->name.'</a></li>';
		}

		// close the nav
		$output.= '</ul>';

		// send the final output to the class
		static::$_output = $output;
	}

	protected static function _generate_dropdown_nav($data, $sub_type = 'sub')
	{
		// open the nav
		$output = '<ul class="nav">';

		foreach ($data as $item)
		{
			// get the sub nav items under this section
			$sub = \Model_Nav::get_nav_items($sub_type, $item->category);

			// figure out what should be shown
			$target_output = ($item->url_target == 'offsite') ? ' target="_blank"' : false;

			if ($sub !== false)
			{
				$output.= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$item->name.' <b class="caret"></b></a>';
				$output.= '<ul class="dropdown-menu">';

				foreach ($sub as $i)
				{
					// default to allow access
					$level = true;

					if ( ! empty($i->access))
					{
						// get the access info for the nav item
						$navaccess = explode('|', $i->access);

						// find if the user has the proper level
						$level = \Sentry::user()->atleast_level("$navaccess[0].$navaccess[1]", $navaccess[2]);
					}

					if ($level)
					{
						if ($i->order == 0 and $i->group != 0)
						{
							$output.= '<li class="divider"></li>';
						}

						// figure out what should be shown
						$i_target_output = ($i->url_target == 'offsite') ? ' target="_blank"' : false;

						$output.= '<li><a href="'.\Uri::create($i->url).'"'.$target_output.'>'.$i->name.'</a></li>';
					}
				}

				$output.= '</ul>';
				$output.= '</li>';
			}
			else
			{
				// generate the output for the nav item
				$output.= '<li><a href="'.\Uri::create($item->url).'"'.$target_output.'>'.$item->name.'</a></li>';
			}
		}

		// close the nav
		$output.= '</ul>';

		// send the final output to the class
		static::$_output = $output;
	}

	/**
	 * Generate the user nav.
	 *
	 * Note: because of notifcations and dynamic elements, this menu cannot be cached.
	 *
	 * @internal
	 * @return	void
	 */
	protected static function _generate_user_nav()
	{
		if (\Sentry::check())
		{
			// get the user
			$user = \Sentry::user();

			// get the message count
			$message_count = 0;

			// get the writing count
			$writing_count = 0;
			
			// create a total count
			$total = $writing_count + $message_count;

			// figure out what the classes should be
			$total_class = ($total == 0) ? '' : ' label-warning';
			$writing_class = ($writing_count == 0) ? '' : ' label-warning';
			$message_class = ($message_count == 0) ? '' : ' label-important';

			// figure out the outputs
			$writing_output = ($writing_count > 0) ? '<span class="label'.$writing_class.'">'.$writing_count.'</span> ' : false;
			$message_output = ($message_count > 0) ? '<span class="label'.$message_class.'">'.$message_count.'</span> ' : false;

			// build the list of items that should be in the user nav
			$usernav = array(
				0 => array(
					array(
						'name' => ucwords(__('cp')),
						'url' => 'admin/index',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(\Inflector::pluralize(__('notification'))),
						'url' => 'admin/notifications',
						'extra' => array(),
						'additional' => ''),
				),
				1 => array(
					array(
						'name' => ucwords(__('my', array('thing' => __('account')))),
						'url' => 'admin/user/edit/'.\Sentry::user()->id,
						'extra' => array(),
						'additional' => ' <span class="icn icn-50 tooltip-left" data-icon="?" title="'.lang('short.help.user_account').'"></span>'),
					array(
						'name' => ucwords(__('my', array('thing' => \Inflector::pluralize(__('character'))))),
						'url' => 'admin/character/edit',
						'extra' => array(),
						'additional' => ''),
				),
				2 => array(
					array(
						'name' => $message_output.ucfirst(\Inflector::pluralize(__('message'))),
						'url' => 'admin/messages',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => $writing_output.ucfirst(__('writing')),
						'url' => 'admin/writing',
						'extra' => array(),
						'additional' => ''),
				),
				3 => array(
					array(
						'name' => ucwords(__('action.request').' '.__('loa')),
						'url' => 'admin/user/loa',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(__('action.nominate')).' '.__('for').' '.ucfirst(__('award')),
						'url' => 'admin/user/nominate',
						'extra' => array(),
						'additional' => ''),
				),
				4 => array(
					array(
						'name' => ucfirst(__('action.logout')),
						'url' => 'login/logout',
						'extra' => array(),
						'additional' => ''),
				),
			);

			// start the output
			$output = '<ul class="nav pull-right">';

			$output.= '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">';
			
			if ($total > 0)
			{
				$output.= '<span class="label'.$total_class.'">'.$total.'</span> ';
			}

			$output.= $user->get('name');
			$output.= ' <b class="caret"></b></a>';
			$output.= '<ul class="dropdown-menu">';

			foreach ($usernav as $key => $section)
			{
				if ($key != 0)
				{
					$output.= '<li class="divider"></li>';
				}

				foreach ($section as $item)
				{
					//$output.= '<li><a href="'.\Uri::create($item['url']).'">'.$item['name'].'</a></li>';
					$output.= '<li>'.\Html::anchor($item['url'], $item['name'].$item['additional'], $item['extra']).'</li>';
				}
			}

			$output.= '</ul>';
			$output.= '</li>';

			// close the output
			$output.= '</ul>';
		}
		else
		{
			// we aren't logged in, so show a log in link
			$output = '<ul class="nav pull-right">';
			$output.= '<li><a href="'.\Uri::create('login/index').'">'.ucwords(__('action.login')).'</a></li>';
			$output.= '</ul>';
		}

		// dump the output into the class
		static::$_output = $output;
	}
}
