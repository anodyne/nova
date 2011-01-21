<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  GENRE SELECTION
| -------------------------------------------------------------------
| You will need to set your genre choice from this page. Use the
| options below to change your genre. You MUST set the genre variable
| to exactly what you see below. The value does not have to be
| uppercase.
|
| If you are changing your genre from one to another, you will need
| to install the genre data by pointing your browser toward
| http://yoursite/install/genre
|
| BL5	- Babylon 5
| BSG	- Battlestar Galactica
| BLANK - Empty genre setup
| DND	- Dungeons and Dragons
| ENT	- Star Trek, Enterprise era
| TOS	- Star Trek, Original Series
| MOV	- Star Trek, Movie Era
| DS9	- Star Trek, Deep Space Nine
| KLI	- Star Trek, Klingon
| ROM	- Star Trek, Romulan
| CRD	- Star Trek, Cardassian
| BAJ	- Star Trek, Bajoran
| STO	- Star Trek Online
| SG1	- Stargate SG-1
| SGA	- Stargate Atlantis
*/

$config['genre'] = "BSG";

/*
| -------------------------------------------------------------------
|  LAYOUT HEAD INCLUDE FILES
| -------------------------------------------------------------------
| One of the few required pieces of the system layout are the include
| files. These are files that pull in the system's necessary stylesheets
| and Javascript files. These are used globally by the entire system,
| so modifying them can cause things to break. If your skin is going
| to use a different or new file, it's recommended that you hard code
| that into your specific skin and not into the global includes.
*/

$config['include_head_main']	= MODFOLDER.'/assets/include_head_main.php';
$config['include_head_wiki']	= MODFOLDER.'/assets/include_head_wiki.php';
$config['include_head_admin']	= MODFOLDER.'/assets/include_head_admin.php';
$config['include_head_login']	= MODFOLDER.'/assets/include_head_login.php';

/*
| -------------------------------------------------------------------
|  META DATA
| -------------------------------------------------------------------
| Meta data is, essentially, data about data. Use these meta tags (if
| you want) to specify the meta data found in the HEAD of the layouts
| of the system. More information can be found about meta tags by doing
| a simple Google search from your web browser.
*/

$config['meta_desc']		= "Anodyne Productions' premier online RPG management software";
$config['meta_author']		= "Anodyne Productions";
$config['meta_keywords']	= "nova, rpg management, anodyne, rpg, sms";

/*
| -------------------------------------------------------------------
|  RSS SETTINGS
| -------------------------------------------------------------------
| Change these values if you want to change the way your RSS feeds are
| identified to a news aggregator.
*/

$config['rss_num_entries']		= 25;
$config['rss_encoding']			= 'utf-8';
$config['rss_description']		= "Nova, Anodyne Productions' premier RPG management software";
$config['rss_feed_lang']		= 'en-us';
$config['rss_creator_email']	= 'john.doe@example.com';

/** DO NOT EDIT BELOW THIS LINE! **/
define('GENRE', strtolower($config['genre']));
