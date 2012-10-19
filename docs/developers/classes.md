# Classes

## Extending Existing Classes

You can extend (and thereby override) existing classes in Nova from within the `app` or a module. If you want your changes to impact the entire system, you need only follow a couple simple steps.

1. Create a new file in the `app/classes` directory. For this example, we'll assume you want to override the Nav class that generates all of the navigation menus. In that instance, you can create a file called `nav.php` in `app/classes`.
2. Your Nav class must extend the core class, in this case `Fusion\Nav`.
3. Make your changes to the class. You can override existing methods or create new ones to use.
4. Tell the autoloader you want to use your version of the file instead of whatever is being loaded. This is done by creating a new record for the autoloader in the `app/bootstrap.php` file.

Your final nav class:

<pre>&lt;?php

class Nav extends \Fusion\Nav
{
	public static function run()
	{
		return 'This is Nav::run()';
	}
}</pre>

The app bootstrap autoloader:

<pre>&lt;?php
/**
 * The full content of the bootstrap file is in the Nova core. If you need to do
 * anything to the bootstrap, you can override the default from here after the 
 * require statement.
 */

require NOVAPATH.'nova/bootstrap.php';

Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',

	'Nav' => APPPATH.'classes/nav.php',
));</pre>