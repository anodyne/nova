<?php

class Generate extends Oil_Generate {
	
	/**
	 * Nova adds the ability to Oil to generate extensions. This will create a
	 * directory in the APPPATH/extensions directory with the name provided.
	 * Included in this process is the creation of the directory structure as
	 * well as a blank controller and view file as well as the extension init
	 * file.
	 *
	 *     php oil generate extension NAME
	 *
	 * @access	public
	 * @uses	Generate::extension_controller
	 * @uses	Generate::extension_views
	 * @return	void
	 */
	public static function extension($args)
	{
		$args = self::_clear_args($args);
		$singular = strtolower(array_shift($args));
		$actions = $args;
		
		// make sure the name is right
		$name = Inflector::underscore(trim($singular));
		
		// build the structure
		if ( ! is_dir(EXTPATH.$name))
		{
			mkdir(EXTPATH.$name, 0777);
			
			if (is_dir(EXTPATH.$name))
			{
				Cli::write('Extension directory created.');
				
				// create the classes directory
				mkdir(EXTPATH.$name.'/classes', 0777);
				mkdir(EXTPATH.$name.'/classes/controller', 0777);
				
				if (is_dir(EXTPATH.$name.'/classes') and is_dir(EXTPATH.$name.'/classes/controller'))
				{
					Cli::write('Class directory created.');
				}
				
				// create the views directory
				mkdir(EXTPATH.$name.'/views', 0777);
				mkdir(EXTPATH.$name.'/views/components', 0777);
				mkdir(EXTPATH.$name.'/views/components/pages', 0777);
				mkdir(EXTPATH.$name.'/views/components/js', 0777);
				mkdir(EXTPATH.$name.'/views/design', 0777);
				mkdir(EXTPATH.$name.'/views/design/images', 0777);
				
				if (is_dir(EXTPATH.$name.'/views') and is_dir(EXTPATH.$name.'/views/components') and is_dir(EXTPATH.$name.'/views/components/pages')
						and is_dir(EXTPATH.$name.'/views/components/js') and is_dir(EXTPATH.$name.'/views/design')
						and is_dir(EXTPATH.$name.'/views/design/images'))
				{
					Cli::write('Views directory created.');
				}
				
				// create the extension controller and views
				static::_extension_controller(array($name, 'index'));
				
				// create the init file
				$filename = EXTPATH.$name.'/init.php';
				$handle = fopen($filename, 'w');
				$contents = "<?php

// the init file is used for creating extension-specific routes and other work as the extensioni is loaded by Kohana
";
				fwrite($handle, $contents);
				fclose($handle);
				
				if (file_exists($filename))
				{
					Cli::write('Extension init file created.');
				}
			}
			else
			{
				Cli::write('Could not create the '.$name.' directory. You will need to create your extension file structure manually.', 'red');
			}
		}
		else
		{
			Cli::write('There is already an extensions directory named '.$name.', please choose another name.', 'red');
		}
	}
	
	/**
	 * Nova adds the ability to create extension controllers to Oil. This method
	 * cannot be called directly from the command line.
	 *
	 * @access	protected
	 * @return	void
	 */
	protected static function _extension_controller($args, $build = true)
	{
		$args = self::_clear_args($args);
		$singular = strtolower(array_shift($args));
		$actions = $args;
		
		// store the original name so we don't accidentally create multiple extensions
		$singular_original = $singular;
		
		// pull out all the underscores and camel-case the controller name
		$singular = str_replace('_', ' ', $singular);
		$singular = Inflector::camelize($singular);
		$singular = ucfirst($singular);
		
		$filename = trim(str_replace(array('_', '-'), DIRECTORY_SEPARATOR, strtolower($singular)), DIRECTORY_SEPARATOR);

		$filepath = EXTPATH.$singular_original.'/classes/controller/'.$filename.'.php';
		
		// Uppercase each part of the class name and remove hyphens
		$class_name = Inflector::classify($singular);
		
		// Stick "blogs" to the start of the array
		array_unshift($args, $singular_original);

		// Create views folder and each view file
		static::_extension_views($args, false);

		$actions or $actions = array('index');

		$action_str = '';
		foreach ($actions as $action)
		{
			$action_str .= '
	public function action_'.$action.'()
	{
		// Your code goes here...
	}'.PHP_EOL;
		}

		// Build Controller
		$controller = <<<CONTROLLER
<?php

class Controller_{$class_name} extends Controller_Nova_Base {
{$action_str}
}

// End of file $filename.php
CONTROLLER;

		// Write controller
		static::create($filepath, $controller, 'controller');
		$build and static::build();
	}
	
	/**
	 * Nova adds the ability to create extension views from Oil. This method
	 * cannot be called directly from the command line.
	 *
	 * @access	protected
	 * @return	void
	 */
	protected static function _extension_views($args, $build = true)
	{
		$args = self::_clear_args($args);
		$controller = strtolower(array_shift($args));
		$controller_title = Inflector::humanize($controller);
		
		// store the original controller name
		$controller_original = $controller;
		
		// pull out all the underscores and camel-case the controller name
		$controller = str_replace('_', ' ', $controller);
		$controller = ucfirst(Inflector::camelize($controller));
		
		// store a lower-cased version of the controller name
		$controller_lower = strtolower($controller);

		$view_dir = EXTPATH.$controller_original.'/views/components/pages/'.trim(str_replace(array('_', '-'), DIRECTORY_SEPARATOR, $controller_lower), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

		$args or $args = array('index');

		// Make the directory for these views to be store in
		is_dir($view_dir) or static::$create_folders[] = $view_dir;

		// Add the default template if it doesnt exist
		if ( ! file_exists($app_template = APPPATH.'views/template.php'))
		{
			static::create($app_template, file_get_contents(MODPATH.'modules/oil/views/default/template.php'), 'view');
		}

		foreach ($args as $action)
		{
			$view_title = Inflector::humanize($action);
			$view = <<<VIEW
<p>{$view_title}</p>
VIEW;

			// Create this view
			static::create($view_dir.$action.'.php', $view, 'view');
		}

		$build and static::build();
	}
}
