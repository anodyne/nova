<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database Schema
 *
 * @package		Install Module
 * @subpackage	Asset
 * @author		Anodyne Productions
 * @version		2.0
 */

$dbconfig = Kohana::config('database');

/**
 * Commonly used items
 */
$user_id_type				= 'int';
$user_id_constraint			= 8;
$character_id_type			= 'int';
$character_id_constraint	= 8;
$date_type					= 'bigint';
$date_constraint			= 20;

$_genre						= strtolower(Kohana::config('nova.genre'));
$_prefix					= $dbconfig['default']['table_prefix'];
$_charset					= 'DEFAULT CHARACTER SET '.$dbconfig['default']['charset'].' COLLATE '.$dbconfig['default']['collate'];

$fields = "
CREATE TABLE IF NOT EXISTS ${_prefix}access_groups (
	group_id int(6) unsigned NOT NULL auto_increment,
	group_name varchar(255) NOT NULL default '',
	group_order int(4) NOT NULL default 99,
	PRIMARY KEY  (group_id)
) $_charset;

CREATE TABLE IF NOT EXISTS ${_prefix}access_pages (
	page_id int(6) unsigned NOT NULL auto_increment,
	page_name varchar(255) NOT NULL default '',
	page_url varchar(255) NOT NULL default '',
	page_level varchar(3) NOT NULL default '',
	page_group int(6) NOT NULL default 0,
	page_desc text NOT NULL,
	PRIMARY KEY  (page_id)
) $_charset;

CREATE TABLE IF NOT EXISTS ${_prefix}access_roles (
	role_id int(5) unsigned NOT NULL auto_increment,
	role_name varchar(255) NOT NULL default '',
	role_access text NOT NULL,
	role_desc text NOT NULL,
	PRIMARY KEY  (role_id)
) $_charset;

CREATE TABLE IF NOT EXISTS ${_prefix}applications (
	app_id int(10) unsigned NOT NULL auto_increment,
	app_email varchar(255) NOT NULL default '',
	app_user ${user_id_type}(${user_id_constraint}) NOT NULL,
	app_user_name varchar(255) NOT NULL default '',
	app_character ${character_id_type}(${character_id_constraint}) NOT NULL,
	app_character_name text NOT NULL,
	app_position varchar(255) NOT NULL default '',
	app_date ${date_type}(${date_constraint}) NOT NULL,
	app_action varchar(100) NOT NULL default '',
	app_message text NOT NULL,
	PRIMARY KEY  (app_id)
) $_charset;

CREATE TABLE IF NOT EXISTS ${_prefix}awards (
	award_id int(5) unsigned NOT NULL auto_increment,
	award_name varchar(255) NOT NULL default '',
	award_image varchar(100) NOT NULL default '',
	award_order int(5) NOT NULL default 99,
	award_desc text NOT NULL,
	award_cat enum('ic','ooc','both') NOT NULL default 'ic',
	award_display enum('y','n') NOT NULL default 'y',
	PRIMARY KEY  (award_id)
) $_charset;

CREATE TABLE IF NOT EXISTS ${_prefix}awards_queue (
	queue_id int(8) unsigned NOT NULL auto_increment,
	queue_receive_character ${character_id_type}(${character_id_constraint}) NOT NULL,
	queue_receive_user ${user_id_type}(${user_id_constraint}) NOT NULL,
	queue_nominate ${character_id_type}(${character_id_constraint}) NOT NULL,
	queue_award int(5) NOT NULL,
	queue_reason text NOT NULL,
	queue_status enum('pending','accepted','rejected') NOT NULL default 'pending',
	queue_date ${date_type}(${date_constraint}) NOT NULL,
	PRIMARY KEY  (queue_id)
) $_charset;
";

// End of file schema.php
// Location: modules/install/assets/schema.php