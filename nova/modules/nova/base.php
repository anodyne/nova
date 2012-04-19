<?php

/**
 * A space indicates a new lang item
 * A pipe (|) indicates new arguments
 * A tilde (~) indicates new lang items within arguments
 * Wrapping in brackets ([]) indicates a variable that shouldn't be parsed
 */
if ( ! function_exists('lang'))
{
	function lang($string, $capitalize = 0)
	{
		// explode the string into an array
		$pieces = explode(' ', $string);

		// an empty array for storing the pieces
		$output = '';

		foreach ($pieces as $p)
		{
			// explode for arguments
			$args = explode('|', $p);

			// get the main piece
			$main = $args[0];

			// now remove the main piece
			unset($args[0]);

			// reset the values
			$args = array_values($args);

			if (count($args) > 0)
			{
				foreach ($args as $key => $a)
				{
					// create a holding array for the sub pieces
					$subpiece = array();
					
					// looks for a string wrapped in brackets and prints it as is
					if (preg_match("/\[[^]]+\]/i", $a))
					{
						$a = substr_replace($a, '', 0, 1);
						$a = substr_replace($a, '', -1, 1);

						$subpiece[] = $a;
					}
					else
					{
						// see if there's a space in the argument
						$arg_pieces = explode('~', $a);

						if (count($arg_pieces) > 1)
						{
							foreach ($arg_pieces as $x)
							{
								$subpiece[] = __($x);
							}
						}
						else
						{
							$subpiece[] = __($a);
						}
					}

					// update the argument
					$args[$key] = implode(' ', $subpiece);
				}

				$output[] = __($main, $args);
			}
			else
			{
				$output[] = __($main);
			}
		}

		// implode the array back to a string
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
