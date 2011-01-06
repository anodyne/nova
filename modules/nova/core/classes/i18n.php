<?php

class I18n extends Kohana_I18n {}

/**
 * Kohana translation/internationalization function. The PHP function
 * [strtr](http://php.net/strtr) is used for replacing parameters.
 *
 *    __('Welcome back, :user', array(':user' => $username));
 *
 * [!!] The target language is defined by [I18n::$lang].
 * 
 * @uses    I18n::get
 * @param   string  text to translate
 * @param   array   values to replace in the translated text
 * @param   string  source language
 * @return  string
 */
function __($string, array $values = NULL, $lang = 'nova')
{
	if ($lang !== I18n::$lang)
	{
		// The message and target languages are different
		// Get the translation for this message
		$string = I18n::get($string);
	}

	return empty($values) ? $string : strtr($string, $values);
}
