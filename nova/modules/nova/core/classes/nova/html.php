<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The HTML class extends Kohana's native Form class to add additional methods
 * for handling HTML5 content like video, audio and canvas. If you use these
 * items, it's important to understand the elements and what's involved. More
 * information about these items can be found in the inline help documentation
 * for each method.
 *
 * The HTML5 elements are based off of work done by Adam Fairholm for CodeIgniter 2.0.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Html extends Kohana_Html {
	
	/**
	 * Creates an audio element. Takes an associative array of attributes in the
	 * first parameter. More information about the audio tag can be found 
	 * [here](http://www.w3schools.com/html5/tag_audio.asp).
	 *
	 * The source array must be formatted in the manner below. The _src_ item 
	 * is required and the _attr_ item can be an array of attributes that'll be 
	 * added to the source. More information about source tags can be found 
	 * [here](http://www.w3schools.com/html5/tag_source.asp).
	 *
	 *     $sources = array(
	 *         'src' => "",
	 *         'type' => "",
	 *         'media' => "",
	 *         'attr' => ""
	 *     );
	 *
	 *     echo audio($attributes, $sources);
	 *
	 * @access	public
	 * @uses	Html::attributes
	 * @param	array 	an associative array of attributes
	 * @param	array 	an associative array of soruces
	 * @param	string	a message to display if the feature isn't supported
	 * @return	string	the complete audio tag
	 */
	public static function audio(array $attributes, array $sources, $no_support = false)
	{
		// set the default no support message
		$no_support = ($no_support === false) ? __('Your browser does not support the HTML5 audio tag') : $no_support;
		
		// set the initial audio element
		$html = "<audio ".html::attributes($attributes).">";
		
		if (count($sources) > 0)
		{
			$html.= self::_parse_sources($sources);
		}
		
		$html.= $no_support_message;
		
		return $html.= "</audio>";
	}
	
	/**
	 * Creates a canvas element. Takes an associative array of attributes in the 
	 * first parameter. More information about the canvas tag can be found 
	 * [here](http://www.w3schools.com/html5/tag_canvas.asp).
	 *
	 * __Note:__ The canvas tag is not natively supported in Internet Explorer 
	 * prior to version 9 and requires the use of a plugin to get it to work. 
	 * You should understand the limitations of this tag before attempting to use it.
	 *
	 *     echo canvas($attributes);
	 *
	 * @access	public
	 * @uses	Html::attributes
	 * @param	array 	an array of attributes
	 * @param	string	a message to display if the feature isn't supported
	 * @return	string	the complete canvas tag
	 */
	public static function canvas(array $attributes, $no_support = false)
	{
		// set the default no support message
		$no_support = ($no_support === false) ? __('Your browser does not support the HTML5 canvas tag') : $no_support;
		
		return '<canvas '.html::attributes($attributes).'>'.$no_support.'</canvas>';
	}
	
	/**
	 * Creates a video element. Takes an associative array of attributes in the 
	 * first parameter and an array of sources in the second. More information 
	 * about the video tag can be found [here](http://www.w3schools.com/html5/tag_video.asp).
	 *
	 * The source array must be formatted in the manner below. The _src_ item is 
	 * required and the _attr_ item can be an array of attributes that'll be added 
	 * to the source. More information about source tags can be found 
	 * [here](http://www.w3schools.com/html5/tag_source.asp).
	 *
	 *     $sources = array(
	 *         'src' => "",
	 *         'type' => "",
	 *         'media' => "",
	 *         'attr' => ""
	 *     );
	 *
	 *     echo video($attributes, $sources);
	 *
	 * @access	public
	 * @uses	Html::attributes
	 * @param	array 	an array of attributes
	 * @param	array 	an array of sources
	 * @param	string	a message to display if the feature isn't supported
	 * @return	string	the complete video tag
	 */
	public static function video(array $attributes, array $sources, $no_support = false)
	{
		// set the default no support message
		$no_support = ($no_support === false) ? __('Your browser does not support the HTML5 video tag') : $no_support;
		
		// set the initial video element
		$html = "<video ".html::attributes($attributes).">";
		
		if (count($sources) > 0)
		{
			$html.= self::_parse_sources($sources);
		}
		
		// set the no support message
		$html.= $no_support;
		
		return $html.= "</video>";
	}
	
	/**
	 * Parse the sources for the HTML5 elements.
	 *
	 * @access	protected
	 * @uses	Html::attributes
	 * @param	array 	array of sources
	 * @return	string	the source items
	 */
	protected static function _parse_sources(array $sources)
	{
		// if there's nothing in the array, return null
		if (count($sources) == 0)
		{
			return null;
		}
		
		// set the initial HTML element	
		$html = null;
		
		// loop through the sources
		foreach ($sources as $source)
		{
			$html.= '<source src="'.$source['src'].'"';
			
			if (isset($source['type']))
				$html.= ' type="'.$source['type'].'"';

			if (isset($source['media']))
				$html.= ' media="'.$source['media'].'"';
			 
			if (isset($source['attr']) and ! empty($source['attr']))
				$html.= ' '.html::attributes($source['attr']);
			 
			$html.= ' />';
		}
	
		return $html;
	}
}
