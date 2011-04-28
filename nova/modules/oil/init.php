<?php

if (Kohana::$environment != Kohana::DEVELOPMENT)
{
	Cli::write('Oil cannot be run under the current environment! Quitting now...', 'red');
	exit;
}
