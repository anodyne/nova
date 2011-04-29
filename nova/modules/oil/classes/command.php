<?php

class Command extends Oil_Command {
	
	/**
	 * Nova adds the ability to generate extensions from the command line and
	 * print out the Kohana, Nova, Thresher and Mako version numbers.
	 *
	 * In addition, for the time being, Nova removes the ability to generate
	 * scaffolding, migrations and views and removes the ability to run unit
	 * tests as well as pull packages from Github. Some of these functions may
	 * be added to the Oil port in the future.
	 *
	 *     php oil generate extension NAME
	 *
	 * @access	public
	 * @return	void
	 */
	public static function init($args)
	{
		// Remove flag options from the main argument list
		for ($i =0; $i < count($args); $i++)
		{
			if (strpos($args[$i], '-') === 0)
			{
				unset($args[$i]);
			}
		}

		try
		{
			if ( ! isset($args[1]))
			{
				if (Cli::option('v', Cli::option('version')))
				{
					Cli::write('Kohana: ' . Kohana::VERSION . ' (' . Kohana::CODENAME . ')');
					return;
				}

				static::help();
				return;
			}

			switch ($args[1])
			{
				case 'g':
				case 'generate':

					$action = isset($args[2]) ? $args[2]: 'help';

					$subfolder = 'default';
					if (is_int(strpos($action, 'scaffold/')))
					{
						$subfolder = str_replace('scaffold/', '', $action);
						$action = 'scaffold';
					}

					switch ($action)
					{
						case 'controller':
						case 'model':
						//case 'views':
						//case 'migration':
						case 'extension':
							call_user_func('Generate::'.$action, array_slice($args, 3));
						break;
						
						/*
						case 'scaffold':
							call_user_func('Scaffold::generate', array_slice($args, 3), $subfolder);
						break;
						*/
						
						default:
							Generate::help();
					}

				break;

				case 'c':
				case 'console':
					new Console;

				case 'r':
				case 'refine':

					// Developers of third-party tasks may not be displaying PHP errors. Report any error and quit
					set_error_handler(function($errno, $errstr, $errfile, $errline){
						Cli::error("Error: {$errstr} in $errfile on $errline");
						Cli::beep();
						exit;
					});

					$task = isset($args[2]) ? $args[2] : null;

					call_user_func('Refine::run', $task, array_slice($args, 3));
				break;
				
				/*
				case 'p':
				case 'package':

					$action = isset($args[2]) ? $args[2]: 'help';

					switch ($action)
					{
						case 'install':
						case 'uninstall':
							call_user_func_array('Package::'.$action, array_slice($args, 3));
						break;

						default:
							Package::help();
					}

				break;

				case 't':
				case 'test':

					// Suppressing this because if the file does not exist... well thats a bad thing and we can't really check
					// I know that supressing errors is bad, but if you're going to complain: shut up. - Phil
					@include_once('PHPUnit/Autoload.php');

					// Attempt to load PHUnit.  If it fails, we are done.
					if ( ! class_exists('PHPUnit_Framework_TestCase'))
					{
						throw new Kohana_Exception('PHPUnit does not appear to be installed.'.PHP_EOL.PHP_EOL."\tPlease visit http://phpunit.de and install.");
					}

					// CD to the root of Fuel and call up phpunit with a path to our config
					$command = 'cd '.DOCROOT.'; phpunit -c "'.COREPATH.'phpunit.xml"';

					// Respect the group option
					Cli::option('group') and $command .= ' --group '.Cli::option('group');

					// Respect the coverage-html option
					Cli::option('coverage-html') and $command .= ' --coverage-html '.Cli::option('coverage-html');

					passthru($command);

				break;
				*/
				
				case 'version':
					Cli::write('Kohana: ' . Kohana::VERSION . ' (' . Kohana::CODENAME . ')');
					Cli::write('Nova: '.Kohana::config('nova.app_version_full'));
					Cli::write('Thresher: '.Kohana::config('nova.wiki_version_full'));
					Cli::write('Mako: '.Kohana::config('nova.forum_version_full'));
				break;
				
				default:

					static::help();
			}
		}

		catch (Exception $e)
		{
			Cli::error('Error: '.$e->getMessage());
			Cli::beep();
		}
	}
	
	/**
	 * Nova changes the help message to take in to account some of the changes
	 * made to Oil.
	 *
	 *     php oil
	 *
	 * @access	public
	 * @return	string
	 */
	public static function help()
	{
		echo <<<HELP

Usage:
  php oil [console|generate|help|refine]

Runtime options:
  -f, [--force]    # Overwrite files that already exist
  -s, [--skip]     # Skip files that already exist
  -q, [--quiet]    # Supress status output

Description:
  The 'oil' command can be used in several ways to facilitate quick development,
  help with testing your application and for running Tasks.

HELP;

	}
}
