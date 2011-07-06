<?php defined('SYSPATH') or die('No direct script access.');

class Kodoc extends Kohana_Kodoc
{
	/**
	 * Creates an html list of all classes sorted by category (or package if no category)
	 *
	 * @return   string   the html for the menu
	 */
	public static function menu()
	{
		$classes = Kodoc::classes();

		foreach ($classes as $class)
		{
			$exceptions = explode(',', Kohana::$config->load('userguide.api_prefix_ignore'));
			
			foreach ($exceptions as $e)
			{
				if (isset($classes[$e.$class]))
				{
					// Remove extended classes
					unset($classes[$e.$class]);
				}
			}
		}

		ksort($classes);

		$menu = array();

		$route = Route::get('docs/api');

		foreach ($classes as $class)
		{
			$class = Kodoc_Class::factory($class);

			// Test if we should show this class
			if ( ! Kodoc::show_class($class))
				continue;

			$link = HTML::anchor($route->uri(array('class' => $class->class->name)), $class->class->name);

			if (isset($class->tags['package']))
			{
				foreach ($class->tags['package'] as $package)
				{
					if (isset($class->tags['category']))
					{
						foreach ($class->tags['category'] as $category)
						{
							$menu[$package][$category][] = $link;
						}
					}
					else
					{
						$menu[$package]['Base'][] = $link;
					}
				}
			}
			else
			{
				$menu['[Unknown]']['Base'][] = $link;
			}
		}

		// Sort the packages
		ksort($menu);

		return View::factory('userguide/api/menu')
			->bind('menu', $menu);
	}
	
	/**
	 * Returns an array of all the classes available, built by listing all files in the classes folder and then trying to create that class.
	 *
	 * This means any empty class files (as in completely empty) will cause an exception
	 *
	 * @param   array   array of files, obtained using Kohana::list_files
	 * @return  array   an array of all the class names
	 */
	public static function classes(array $list = null)
	{
		if ($list === null)
		{
			$list = Kohana::list_files('classes');
		}

		$classes = array();

		foreach ($list as $name => $path)
		{
			if (strpos($name, 'index.html') === false)
			{
				if (is_array($path))
				{
					$classes += Kodoc::classes($path);
				}
				else
				{
					// Remove "classes/" and the extension
					$class = substr($name, 8, -(strlen(EXT)));

					// Convert slashes to underscores
					$class = str_replace(DIRECTORY_SEPARATOR, '_', strtolower($class));

					$classes[$class] = $class;
				}
			}
		}

		return $classes;
	}
	
	/**
	 * Get all classes and methods of files in a list.
	 *
	 * >  I personally don't like this as it was used on the index page.  Way too much stuff on one page.  It has potential for a package index page though.
	 * >  For example:  class_methods( Kohana::list_files('classes/sprig') ) could make a nice index page for the sprig package in the api browser
	 * >     ~bluehawk
	 *
	 */
	public static function class_methods(array $list = null)
	{
		$list = Kodoc::classes($list);
		
		$classes = array();

		foreach ($list as $class)
		{
			$_class = new ReflectionClass($class);
			
			//echo Kohana::debug($_class->getDeclaringClass());

			if (stripos($_class->name, 'Kohana') === 0)
			{
				// Skip the extension stuff stuff
				continue;
			}

			$methods = array();

			foreach ($_class->getMethods() as $_method)
			{
				$declares = $_method->getDeclaringClass()->name;

				if (stripos($declares, 'Kohana') === 0)
				{
					// Remove "Kohana_"
					$declares = substr($declares, 7);
				}

				if ($declares === $_class->name)
				{
					$methods[] = $_method->name;
				}
			}

			sort($methods);

			$classes[$_class->name] = $methods;
		}

		return $classes;
	}
}
