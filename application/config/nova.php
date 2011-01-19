<?php defined('SYSPATH') or die('No direct script access.');

return array(
	/**
	 * Genre
	 *
	 * The genre is determined by the zip archive you downloaded. In
	 * the event you want to change your genre, you will change this
	 * variable to the abbreviation of the genre you have installed
	 * and want to use.
	 *
	 * THIS VARIABLE NEEDS TO BE LOWERCASED!
	 */
	'genre' => 'bsg',
	
	/**
	 * Meta Data
	 *
	 * Meta data is, essentially, data about data. Use these meta tags
	 * (if you want) to specify the meta data found in the head of the
	 * layouts of the system. More information can be found about meta
	 * tags by doing a simple Google search from your web browser.
	 */
	'meta_desc' => "Anodyne Productions' premier online RPG management software",
	'meta_author' => "Anodyne Productions",
	'meta_keywords' => "nova, rpg management, anodyne, rpg, sms",
	
	/**
	 * RSS Feed Settings
	 *
	 * Change these values if you want tochange the way your RSS feeds
	 * are identified to a news aggregator.
	 */
	'rss_num_entries' => 25,
	'rss_encoding' => 'utf-8',
	'rss_description' => "Nova, Anodyne Productions' premier RPG management software",
	'rss_feed_lang' => 'en-us',
	'rss_creator_email' => 'john.doe@example.com',
);
