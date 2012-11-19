<?php

/**
 * A space indicates a new lang item
 * A pipe (|) indicates new arguments
 * Wrapping in brackets ([]) indicates something that shouldn't be parsed
 */
if ( ! function_exists('langOLD'))
{
	function langOLD($str, $capitalize = 0)
	{
		// break the string into pieces
		$pieces = preg_split('/(\[\[.*?\]\])/', $str, null, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);

		// loop through the pieces
		foreach ($pieces as $key => $p)
		{
			// start by trimming the value
			$p = trim($p);

			if (substr($p, 0, 2) == '[[')
			{
				// clean up the string (removes the double brackets on either end)
				$p = preg_replace("/^.*\[\[([^)]*)\]\].*$/", '$1', $str);

				// break the string at the pipe
				$args = explode('|', $p);

				// the first element is the base
				$base = $args[0];

				// remove the first item now
				unset($args[0]);

				// loop through the arguments now
				foreach ($args as $arg)
				{
					// are we protecting this string?
					if (preg_match('/(\{\{.*?\}\})/', $arg) > 0)
					{
						// clean up the fragment (removes the double braces on either end)
						$arg = preg_replace("/^.*\{\{([^)]*)\}\}.*$/", '$1', $arg);

						$arg_output[] = $arg;
					}
					else
					{
						// break at the space
						$fragments = explode(' ', $arg);

						$frag_output = array();

						// loop through the spaced pieces
						foreach ($fragments as $frag)
						{
							$frag_output[] = __($frag);
						}

						$arg_output[] = implode(' ', $frag_output);
					}
				}

				$output[] = __($base, $arg_output);
			}
			else
			{
				// are we protecting this string?
				if (preg_match('/(\{\{.*?\}\})/', $p) > 0)
				{
					// clean up the fragment (removes the double braces on either end)
					$p = preg_replace("/^.*\{\{([^)]*)\}\}.*$/", '$1', $p);

					$output[] = $p;
				}
				else
				{
					// break at the space
					$fragments = explode(' ', $p);

					$frag_output = array();

					// loop through the spaced pieces
					foreach ($fragments as $frag)
					{
						$frag_output[] = __($frag);
					}

					$output[] = implode(' ', $frag_output);
				}
			}
		}

		$final = implode(' ', $output);

		switch ($capitalize)
		{
			case 0:
			default:
				return $final;
			break;

			case 1:
				return ucfirst($final);
			break;

			case 2:
				return ucwords($final);
			break;
		}
	}
}

/**
 * @param	string	The i18n key to translate
 * @param	string	Any values that need to be passed to the key as well
 * @return	string
 * @throws	Exception
 */
if ( ! function_exists('lang'))
{
	function lang()
	{
		// Get all the arguments passed
		$args = func_get_args();

		// We have to have arguments
		if (count($args) == 0)
		{
			throw new Exception('lang() must have at least 1 parameter defined for the language key');
		}

		// The first will always be the key to translate
		$key = $args[0];

		// Set up an empty array of arguments
		$argsArray = array();

		// Remove the first item from the arguments
		unset($args[0]);

		// Re-index the array
		$argsArray = array_values($args);

		return __($key, $argsArray);
	}
}

/**
 * Takes a string with spaces and translates each of the pieces.
 *
 * @param	string	The string
 * @return	string
 */
if ( ! function_exists('langConcat'))
{
	function langConcat($str)
	{
		// Break the string into an array
		$pieces = explode(' ', $str);

		// Loop through the array
		foreach ($pieces as $key => $value)
		{
			// Run the content through the translator
			$retval[$key] = __($value);
		}

		return implode(' ', $retval);
	}
}
