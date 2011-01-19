<?php defined('SYSPATH') or die('No direct script access.');
/**
 *	Document   : rss2.php
 *	Created on : 1 mai 2009, 13:03:03
 *	@author Cedric de Saint Leger <c.desaintleger@gmail.com>
 *
 *	Description:
 *      RSS2 driver
 */

class XML_Driver_Rss2 extends XML
{
	public $root_node = 'rss';

	protected static function initialize(XML_Meta $meta)
	{
		$meta	->content_type("application/rss+xml")
				->nodes (
							array(
								"rss"				=> array("attributes"	=> array("version" => "2.0")),
								"link"				=> array("filter"		=> "normalize_uri"),
								"docs"				=> array("filter"		=> "normalize_uri"),
								"guid"				=> array("filter"		=> "normalize_uri"),
								"pubDate"			=> array("filter"		=> "normalize_date"),
								"lastBuildDate"		=> array("filter"		=> "normalize_date"),
								)
						);
	}

	public function normalize_date($value)
	{
		if ( ! is_numeric($value))
		{
			$value = strtotime($value);
		}

		// Convert timestamps to RFC 822 formatted dates
		return date(DATE_RFC822, $value);
	}
}