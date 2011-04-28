<?php
/**
 * Oil is a Kohana port of Fuel's Oil utility.
 *
 * @package		Oil
 * @category	Classes
 * @author		Fuel Development Team
 * @copyright	2010 - 2011 Fuel Development Team
 * @version		1.0
 */

class Refine {
	
	public static function run($task, $args)
	{
		// Make sure something is set
		if ($task === null OR $task === 'help')
		{
			static::help();
			return;
		}

		// Just call and run() or did they have a specific method in mind?
		list($task, $method)=array_pad(explode(':', $task), 2, 'run');

		$task = ucfirst(strtolower($task));

		// Find the task
		if ( ! $file = Kohana::find_file('tasks', $task))
		{
			$files = Kohana::list_files('tasks');
			$possibilities = array();
			foreach($files as $file)
			{
				$possible_task = pathinfo($file, PATHINFO_FILENAME);
				$difference = levenshtein($possible_task, $task);
				$possibilities[$difference] = $possible_task;
			}

			ksort($possibilities);
			
			if ($possibilities and current($possibilities) <= 5)
			{
				throw new Kohana_Exception(sprintf('Task "%s" does not exist. Did you mean "%s"?', strtolower($task), current($possibilities)));
			}
			else
			{
				throw new Kohana_Exception(sprintf('Task "%s" does not exist.', strtolower($task)));
			}
			
			return;
		}

		require $file;

		$task = '\\Nova\\Tasks\\'.$task;

		$new_task = new $task;

		// The help option hs been called, so call help instead
		if (Cli::option('help') && is_callable(array($new_task, 'help')))
		{
			$method = 'help';
		}

		if ($return = call_user_func_array(array($new_task, $method), $args))
		{
			Cli::write($return);
		}
	}

	public static function help()
	{
		$output = <<<HELP

Usage:
  php oil [r|refine] <taskname>

Description:
    Tasks are classes that can be run through the the command line or set up as a cron job.

Examples:
    php oil refine robots [<message>]
    php oil refine robots:protect

Documentation:
	http://fuelphp.com/docs/packages/oil/refine.html
HELP;
		Cli::write($output);

	}
}
