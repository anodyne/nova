<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Development install data
 *
 * @package		Nova
 * @category	Install
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.3
 */

/*
|---------------------------------------------------------------
| Data array with the table/array names being used.
|---------------------------------------------------------------
*/
$data = array(
	'awards',
	'awards_queue',
	'awards_received',
	'characters_data',
	'characters',
	'coc',
	'manifests',
	'mission_groups',
	'missions',
	'news',
	'news_comments',
	'personallogs',
	'personallogs_comments',
	'users',
	'posts',
	'posts_comments',
	'specs_data',
	'tour',
	'tour_data',
	'tour_decks'
);

/*
|---------------------------------------------------------------
| Arrays of data with the information being inserted into the
| database.
|---------------------------------------------------------------
*/

$awards = array(
	array(
		'award_name' => 'Silver Star',
		'award_order' => 0,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic',
		'award_image' => 'silver_star.jpg'),
	array(
		'award_name' => 'Bronze Medal',
		'award_order' => 1,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'both',
		'award_image' => 'bronze_medal.jpg')
);

$awards_queue = array(
	array(
		'queue_receive_character' => 2,
		'queue_receive_user' => 2,
		'queue_nominate' => 1,
		'queue_award' => 1,
		'queue_reason' => 'Jon definitely deserves the Silver Star because of what he did in our last mission.',
		'queue_status' => 'pending',
		'queue_date' => 1229483743),
	array(
		'queue_receive_character' => 1,
		'queue_receive_user' => 1,
		'queue_nominate' => 2,
		'queue_award' => 2,
		'queue_reason' => 'David deserves the Bronze Medal because he came in third in the race we were doing.',
		'queue_status' => 'pending',
		'queue_date' => 1229484743),
);

$awards_received = array(
	array(
		'awardrec_award' => 1,
		'awardrec_user' => 1,
		'awardrec_character' => 1,
		'awardrec_nominated_by' => 2,
		'awardrec_reason' => 'This is my first reason.',
		'awardrec_date' => 1229483743),
	array(
		'awardrec_award' => 2,
		'awardrec_user' => 1,
		'awardrec_character' => 1,
		'awardrec_nominated_by' => 2,
		'awardrec_reason' => 'This is my second reason.',
		'awardrec_date' => 1229483943),
	array(
		'awardrec_award' => 1,
		'awardrec_user' => 2,
		'awardrec_character' => 2,
		'awardrec_nominated_by' => 1,
		'awardrec_reason' => 'This is my third reason.',
		'awardrec_date' => 1229484143)
);

$characters_data = array(
	array(
		'data_field' => 1,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Male'),
	array(
		'data_field' => 2,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Human'),
	array(
		'data_field' => 3,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => '59'),
	array(
		'data_field' => 4,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => '6\'0"'),
	array(
		'data_field' => 5,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => '225 lbs.'),
	array(
		'data_field' => 6,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Gray'),
	array(
		'data_field' => 7,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Brown'),
	array(
		'data_field' => 8,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
	array(
		'data_field' => 9,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => "Personality overview here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 10,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => "Strengths and weaknesses go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 11,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => "Ambitions go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 12,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'All my hobbies and different interests go here.'),
	array(
		'data_field' => 13,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Father'),
	array(
		'data_field' => 14,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Mother'),
	array(
		'data_field' => 15,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Brother'),
	array(
		'data_field' => 16,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Sister'),
	array(
		'data_field' => 17,
		'data_user' => 2,
		'data_char' => 2,
		'data_updated' => now(),
		'data_value' => 'Other Family'),
);

$characters = array(
	array(
		'first_name' => 'William',
		'last_name' => 'Adama',
		'position_1' => 1,
		'rank' => 2,
		'date_activate' => now(),
		'user' => 1),
	array(
		'first_name' => 'Saul',
		'last_name' => 'Tigh',
		'position_1' => 2,
		'rank' => 4,
		'date_activate' => now(),
		'user' => 2),
	array(
		'first_name' => 'Lee',
		'last_name' => 'Adama',
		'position_1' => 9,
		'rank' => 6,
		'date_activate' => now(),
		'user' => 3),
	array(
		'first_name' => 'Kara',
		'last_name' => 'Thrace',
		'position_1' => 10,
		'rank' => 7,
		'date_activate' => now(),
		'user' => 4),
	array(
		'first_name' => 'Gaius',
		'last_name' => 'Baltar',
		'position_1' => 26,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Karl',
		'last_name' => 'Agathon',
		'position_1' => 14,
		'rank' => 7,
		'date_activate' => now(),
		'user' => 5),
	array(
		'first_name' => 'Sharon',
		'last_name' => 'Valerii',
		'position_1' => 13,
		'rank' => 9,
		'date_activate' => now(),
		'user' => 5),
	array(
		'first_name' => 'Galen',
		'last_name' => 'Tyrol',
		'position_1' => 15,
		'rank' => 12,
		'date_activate' => now(),
		'user' => 2),
	array(
		'first_name' => 'Felix',
		'last_name' => 'Gaeta',
		'position_1' => 4,
		'rank' => 9,
		'date_activate' => now(),
		'user' => 4),
	array(
		'first_name' => 'Samuel',
		'last_name' => 'Anders',
		'position_1' => 11,
		'rank' => 10,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Anastasia',
		'last_name' => 'Dualla',
		'position_1' => 5,
		'rank' => 15,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Brendan',
		'last_name' => 'Costanza',
		'position_1' => 11,
		'rank' => 9,
		'crew_type' => 'npc',
		'date_activate' => now()),
	array(
		'first_name' => 'Louanne',
		'last_name' => 'Katraine',
		'position_1' => 10,
		'rank' => 7,
		'crew_type' => 'npc',
		'date_activate' => now()),
);

$coc = array(
	array(
		'coc_crew' => 1,
		'coc_order' => 1),
	array(
		'coc_crew' => 2,
		'coc_order' => 2),
	array(
		'coc_crew' => 3,
		'coc_order' => 3),
	array(
		'coc_crew' => 4,
		'coc_order' => 4)
);

$manifests = array(
	array(
		'manifest_name' => 'Primary Manifest',
		'manifest_desc' => "This is the primary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 0,
		'manifest_display' => 'y',
		'manifest_default' => 'y'),
	array(
		'manifest_name' => 'Secondary Manifest',
		'manifest_desc' => "This is the secondary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 1,
		'manifest_display' => 'y',
		'manifest_default' => 'n'),
	array(
		'manifest_name' => 'Tertiary Manifest',
		'manifest_desc' => "This is the tertiary manifest used by the sim.",
		'manifest_header_content' => "Update your manifest header content from the manifest management page.",
		'manifest_order' => 0,
		'manifest_display' => 'y',
		'manifest_default' => 'n'),
);

$mission_groups = array(
	array(
		'misgroup_name' => 'Mission Group 1',
		'misgroup_order' => 0,
		'misgroup_desc' => 'This is the first mission group I have'),
	array(
		'misgroup_name' => 'Mission Group 2',
		'misgroup_order' => 1,
		'misgroup_desc' => 'This is the second mission group I have'),
);

$missions = array(
	array(
		'mission_title' => 'Encounter at Farpoint',
		'mission_images' => 'yellow.jpg, green.jpg',
		'mission_order' => 0,
		'mission_status' => 'completed',
		'mission_start' => 1167631200,
		'mission_end' => 1170309600,
		'mission_group' => 1,
		'mission_desc' => "Captain Jean-Luc Picard leads the crew of the USS Enterprise-D on its maiden voyage, to examine a new planetary station for trade with the Federation. On the way, they encounter Q, an omnipotent extra-dimensional being, who challenges humanity as a barbaric, inferior species. Picard and his new crew must hold off Q's challenge and solve the puzzle of Farpoint station on Deneb IV, a base that is far more than it seems to be."),
	array(
		'mission_title' => 'The Naked Now',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 1,
		'mission_status' => 'completed',
		'mission_start' => 1170309600,
		'mission_end' => 1172728800,
		'mission_group' => 1,
		'mission_desc' => "The crew of the Enterprise is subjected to an exotic illness that drives them to unusual manic behavior."),
	array(
		'mission_title' => 'Code of Honor',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 2,
		'mission_status' => 'completed',
		'mission_start' => 1172728800,
		'mission_end' => 1175403600,
		'mission_group' => 2,
		'mission_desc' => "A mission of mercy is jeopardized when a planetary ruler decides he wants an Enterprise officer as his wife."),
	array(
		'mission_title' => 'The Last Outpost',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 3,
		'mission_status' => 'completed',
		'mission_start' => 1175403600,
		'mission_end' =>  1177995600,
		'mission_group' => 1,
		'mission_desc' => "In pursuit of Ferengi marauders, the Enterprise and its quarry become trapped by a mysterious planet that is draining both ship's energies."),
	array(
		'mission_title' => 'Where No One Has Gone Before',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 4,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_desc' => "When a specialist in propulsion makes modifications to the Enterprise's warp drive that send it 2.7 million light years out of the galaxy, it is his assistant, a mysterious alien, and Wesley Crusher that must bring it back home."),
	array(
		'mission_title' => 'Lonely Among Us',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 5,
		'mission_status' => 'completed',
		'mission_start' => 1180674000,
		'mission_end' =>  1183266000,
		'mission_desc' => "While transporting delegates, Picard and his crew are enveloped by a cloud that seizes control of their minds and alters their behavior."),
	array(
		'mission_title' => 'Justice',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 6,
		'mission_status' => 'completed',
		'mission_start' => 1183266000,
		'mission_end' =>  1185944400,
		'mission_desc' => "The Enterprise takes shore leave on a pleasurable and peaceful planet. However, things quickly turn ugly when Wesley Crusher is sentenced to death for a seemingly slight rules violation."),
	array(
		'mission_title' => 'The Battle',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 7,
		'mission_status' => 'completed',
		'mission_start' => 1185944400,
		'mission_end' =>  1188622800,
		'mission_desc' => "A Ferengi captain returns the abandoned Stargazer to its former captain, Jean-Luc Picard. Picard, who experiences severe headaches, begins to relive the \"Battle of Maxia\" in which he lost the ship."),
	array(
		'mission_title' => 'Hide and Q',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 8,
		'mission_status' => 'completed',
		'mission_start' => 1188622800,
		'mission_end' => 1191214800,
		'mission_desc' => "Q returns to the Enterprise to tempt Commander Riker into joining the Q Continuum with the lure of Q's powers."),
	array(
		'mission_title' => 'Haven',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 9,
		'mission_status' => 'completed',
		'mission_start' => 1191214800,
		'mission_end' => 1193893200,
		'mission_desc' => "Lwaxana Troi visits her daughter, Counselor Troi, and prepares her for an arranged marriage."),
	array(
		'mission_title' => 'The Big Goodbye',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 10,
		'mission_status' => 'completed',
		'mission_start' => 1193893200,
		'mission_end' => 1196488800,
		'mission_desc' => "A computer malfunction traps Picard, Data, and Beverly in a Dixon Hill holodeck program set in early 20th-century Earth."),
	array(
		'mission_title' => 'Datalore',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 11,
		'mission_status' => 'completed',
		'mission_start' => 1196488800,
		'mission_end' => 1199167200,
		'mission_desc' => "The Enterprise crew finds a disassembled android identical to Data at the site of the Omicron Theta colony—where Data was found—which was destroyed by a life form dubbed \"the Crystalline Entity.\" The reassembled android, Lore, brings the Crystalline Entity to the Enterprise."),
	array(
		'mission_title' => 'Angel One',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 12,
		'mission_status' => 'completed',
		'mission_start' => 1199167200,
		'mission_end' => 1201845600,
		'mission_desc' => "The Enterprise visits a world dominated by women to rescue survivors of a downed freighter."),
	array(
		'mission_title' => '11001001',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 13,
		'mission_status' => 'completed',
		'mission_start' => 1201845600,
		'mission_end' => 1204351200,
		'mission_desc' => "Bynars upgrade the Enterprise's computers in spacedock. Riker and Picard become distracted by a surprisingly realistic holodeck character."),
	array(
		'mission_title' => 'Too Short a Season',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 14,
		'mission_status' => 'completed',
		'mission_start' => 1204351200,
		'mission_end' => 1207026000,
		'mission_desc' => "The Enterprise transports a legendary geriatric admiral who must once again negotiate a hostage situation involving a man from decades earlier in his career. The admiral is mysteriously growing younger; by the time the Enterprise arrives he is a young man."),
	array(
		'mission_title' => 'When the Bough Breaks',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 15,
		'mission_status' => 'completed',
		'mission_start' => 1207026000,
		'mission_end' => 1209618000,
		'mission_desc' => "A planet formerly existing only in legend uncloaks and requests help from the Enterprise. Their cloaking device causes sterility, and they want to adopt children from the Enterprise - by force, if necessary."),
	array(
		'mission_title' => 'Home Soil',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 16,
		'mission_status' => 'completed',
		'mission_start' => 1209618000,
		'mission_end' => 1212296400,
		'mission_desc' => "The crew of the Enterprise discovers a crystalline lifeform with murderous intelligence that has been killing the scientists on a terraforming project."),
	array(
		'mission_title' => 'Coming of Age',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 17,
		'mission_status' => 'completed',
		'mission_start' => 1212296400,
		'mission_end' => 1214888400,
		'mission_desc' => "While Wesley takes a Starfleet Academy entrance exam, the senior staff of the Enterprise are placed under investigation by Starfleet."),
	array(
		'mission_title' => 'Heart of Glory',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 18,
		'mission_status' => 'completed',
		'mission_start' => 1214888400,
		'mission_end' => 1217566800,
		'mission_desc' => "Fugitive Klingons seeking battle attempt to hijack the Enterprise, and ask Worf to join them."),
	array(
		'mission_title' => 'The Arsenal of Freedom',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 19,
		'mission_status' => 'completed',
		'mission_start' => 1217566800,
		'mission_end' => 1217566800,
		'mission_desc' => "Trapped on the surface of an abandoned planet, an away team becomes unwitting participants in the demonstration of an advanced weapons system."),
	array(
		'mission_title' => 'Symbiosis',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 20,
		'mission_status' => 'completed',
		'mission_start' => 1217566800,
		'mission_end' => 1220245200,
		'mission_desc' => "Picard tries to mediate a trade dispute between two neighboring planets, one of which it is the sole supplier of a drug to treat the other's apparently fatal disease."),
	array(
		'mission_title' => 'Skin of Evil',
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 21,
		'mission_status' => 'completed',
		'mission_start' => 1220245200,
		'mission_end' => 1222837200,
		'mission_desc' => "An evil, tar-like creature holds Troi hostage on an alien world. During a rescue mission, one of the Enterprise crew is killed."),
	array(
		'mission_title' => "We'll Always Have Paris",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 22,
		'mission_status' => 'completed',
		'mission_start' => 1222837200,
		'mission_end' => 1225515600,
		'mission_desc' => "Picard meets an old flame, whose husband has been affected by a dimensional experiment accident."),
	array(
		'mission_title' => "Conspiracy",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 23,
		'mission_status' => 'current',
		'mission_start' => 1225515600,
		'mission_desc' => "The strange behavior of high-ranking officers - which earlier prompted the investigation of the crew (in \"Coming of Age\") - leads Picard to uncover a conspiracy within Starfleet."),
	array(
		'mission_title' => "The Neutral Zone",
		'mission_images' => 'green.jpg, yellow.jpg',
		'mission_order' => 24,
		'mission_status' => 'upcoming',
		'mission_desc' => "A derelict satellite is found containing cryonically frozen humans from the 20th century as the Enterprise is sent to investigate the destruction of outposts near Romulan space."),
);

$news = array(
	array(
		'news_title' => 'Welcome to Nova',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "Nova is the start of something very special and something that's going to make a big difference in the way that people manage their RPGs. No more is Anodyne focusing on Star Trek; now, we are providing a multitude of genres for game masters to choose from. We're offering everything from DS9 to Enterprise to Battlestar Galactica. Check out Nova and RPG management evolved.",
		'news_date' => 1229483743,
		'news_cat' => 1,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Nova Says Hello to Comments',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "One of the new features that's found its way into Nova is comments. Users are now able to leave comments on personal logs, news items, and mission posts. Later on, comments will be available on the wiki as well!",
		'news_date' => 1229484743,
		'news_cat' => 1,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Nova Goes Private',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_private' => 'y',
		'news_content' => "A feature that's making it's way over from SMS is private news items. Sometimes, you just don't want everyone to see what you're telling the crew, or you need an easy way to get in touch with all of them quickly. Private news items insure that only your crew can see the news item. If a user navigates to the page, they won't ever know that there are more news items than what's shown.",
		'news_date' => 1229485743,
		'news_cat' => 4,
		'news_status' => 'activated')
);

$news_comments = array(
	array(
		'ncomment_author_user' => 2,
		'ncomment_author_character' => 2,
		'ncomment_news' => 1,
		'ncomment_content' => "This is really cool to hear! I've been running a BSG sim for a couple years now and it's kind of frustrating that I've had to modify SMS 2 so much, especially when a new release comes out. Nova should make things a lot easier. Thank you!",
		'ncomment_date' => 1229483783),
	array(
		'ncomment_author_user' => 1,
		'ncomment_author_character' => 1,
		'ncomment_news' => 1,
		'ncomment_content' => "No problem! That's the whole goal of Nova - to make it easier. Though if you're still using SMS 2, you'll definitely want to check out the official BSG MOD that we released. It'll turn SMS 2 into a BSG sim in a couple of minutes. Enjoy!",
		'ncomment_date' => 1229483813)
);

$personallogs = array(
	array(
		'log_title' => 'First Personal Log',
		'log_author_user' => 1,
		'log_author_character' => 1,
		'log_content' => 'This is the content of my first personal log!',
		'log_date' => 1229483743),
	array(
		'log_title' => 'Second Personal Log',
		'log_author_user' => 2,
		'log_author_character' => 2,
		'log_content' => 'This is the content of the second personal log!',
		'log_date' => 1229483843)
);

$personallogs_comments = array(
	array(
		'lcomment_author_character' => 2,
		'lcomment_author_user' => 2,
		'lcomment_log' => 1,
		'lcomment_content' => 'Very good first personal log!',
		'lcomment_date' => 1229483843),
	array(
		'lcomment_author_character' => 1,
		'lcomment_author_user' => 1,
		'lcomment_log' => 1,
		'lcomment_content' => 'Thank you, I really enjoyed writing this one! You should give it a try sometime.',
		'lcomment_date' => 1229483943),
	array(
		'lcomment_author_character' => 2,
		'lcomment_author_user' => 2,
		'lcomment_log' => 1,
		'lcomment_content' => "I was actually thinking about it.\r\n\r\nWhat do you think I should write mine about though?",
		'lcomment_date' => 1229484143)
);

$users = array(
	array(
		'name' => 'John Doe',
		'email' => 'john@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 2,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UTC'),
	array(
		'name' => 'Jane Doe',
		'email' => 'jane@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 3,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM8'),
	array(
		'name' => 'Bill Doe',
		'email' => 'bill@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 4,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM3'),
	array(
		'name' => 'Deb Doe',
		'email' => 'deb@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 5,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM10'),
	array(
		'name' => 'Joe Doe',
		'email' => 'joe@example.com',
		'password' => '2825652a8bfb76b05548e2cb40076c1b3a586dfb',
		'main_char' => 5,
		'access_role' => 4,
		'join_date' => now(),
		'timezone' => 'UM2'),
);

$posts = array(
	array(
		'post_title' => '101-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1167631200,
		'post_mission' => 1),
	array(
		'post_title' => '101-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1167632200,
		'post_mission' => 1),
	array(
		'post_title' => '101-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1167633200,
		'post_mission' => 1),
	array(
		'post_title' => '101-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1167634200,
		'post_mission' => 1),
	
	array(
		'post_title' => '102-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1170309600,
		'post_mission' => 2),
	array(
		'post_title' => '102-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1170310600,
		'post_mission' => 2),
	array(
		'post_title' => '102-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1170311600,
		'post_mission' => 2),
	array(
		'post_title' => '102-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1170312600,
		'post_mission' => 2),
		
	array(
		'post_title' => '103-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1172729800,
		'post_mission' => 3),
	array(
		'post_title' => '103-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1172730800,
		'post_mission' => 3),
	array(
		'post_title' => '103-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1172731800,
		'post_mission' => 3),
	array(
		'post_title' => '103-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1172732800,
		'post_mission' => 3),
		
	array(
		'post_title' => '104-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1175403600,
		'post_mission' => 4),
	array(
		'post_title' => '104-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1175404600,
		'post_mission' => 4),
	array(
		'post_title' => '104-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1175405600,
		'post_mission' => 4),
	array(
		'post_title' => '104-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1175406600,
		'post_mission' => 4),
	
	array(
		'post_title' => '105-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1177995600,
		'post_mission' => 5),
	array(
		'post_title' => '105-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1177996600,
		'post_mission' => 5),
	array(
		'post_title' => '105-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1177997600,
		'post_mission' => 5),
	array(
		'post_title' => '105-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1177998600,
		'post_mission' => 5),
		
	array(
		'post_title' => '106-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1180674000,
		'post_mission' => 6),
	array(
		'post_title' => '103-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1180675000,
		'post_mission' => 6),
	array(
		'post_title' => '106-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1180676000,
		'post_mission' => 6),
	array(
		'post_title' => '106-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1180677000,
		'post_mission' => 6),
		
	array(
		'post_title' => '107-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1183266000,
		'post_mission' => 7),
	array(
		'post_title' => '107-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1183267000,
		'post_mission' => 7),
	array(
		'post_title' => '107-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1183268000,
		'post_mission' => 7),
	array(
		'post_title' => '107-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1183269000,
		'post_mission' => 7),
	
	array(
		'post_title' => '108-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1185944400,
		'post_mission' => 8),
	array(
		'post_title' => '108-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1185945400,
		'post_mission' => 8),
	array(
		'post_title' => '108-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1185946400,
		'post_mission' => 8),
	array(
		'post_title' => '108-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1185947400,
		'post_mission' => 8),
		
	array(
		'post_title' => '109-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1188622800,
		'post_mission' => 9),
	array(
		'post_title' => '109-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1188623800,
		'post_mission' => 9),
	array(
		'post_title' => '109-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1188624800,
		'post_mission' => 9),
	array(
		'post_title' => '109-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1188625800,
		'post_mission' => 9),
		
	array(
		'post_title' => '110-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1191214800,
		'post_mission' => 10),
	array(
		'post_title' => '110-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1191215800,
		'post_mission' => 10),
	array(
		'post_title' => '110-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1191216800,
		'post_mission' => 10),
	array(
		'post_title' => '110-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1191217800,
		'post_mission' => 10),
	
	array(
		'post_title' => '111-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1193893200,
		'post_mission' => 11),
	array(
		'post_title' => '111-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1193894200,
		'post_mission' => 11),
	array(
		'post_title' => '111-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1193895200,
		'post_mission' => 11),
	array(
		'post_title' => '111-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1193896200,
		'post_mission' => 11),
		
	array(
		'post_title' => '112-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1196488800,
		'post_mission' => 12),
	array(
		'post_title' => '112-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1196489800,
		'post_mission' => 12),
	array(
		'post_title' => '112-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1196490800,
		'post_mission' => 12),
	array(
		'post_title' => '112-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1196491800,
		'post_mission' => 12),
		
	array(
		'post_title' => '113-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1199167200,
		'post_mission' => 13),
	array(
		'post_title' => '113-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1199168200,
		'post_mission' => 13),
	array(
		'post_title' => '113-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1199169200,
		'post_mission' => 13),
	array(
		'post_title' => '113-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1199170200,
		'post_mission' => 13),
	
	array(
		'post_title' => '114-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1201845600,
		'post_mission' => 14),
	array(
		'post_title' => '114-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1201846600,
		'post_mission' => 14),
	array(
		'post_title' => '114-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1201847600,
		'post_mission' => 14),
	array(
		'post_title' => '114-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1201848600,
		'post_mission' => 14),
		
	array(
		'post_title' => '115-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1204351200,
		'post_mission' => 15),
	array(
		'post_title' => '115-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1204352200,
		'post_mission' => 15),
	array(
		'post_title' => '115-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1204353200,
		'post_mission' => 15),
	array(
		'post_title' => '115-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1204354200,
		'post_mission' => 15),
		
	array(
		'post_title' => '116-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1207026000,
		'post_mission' => 16),
	array(
		'post_title' => '116-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1207027000,
		'post_mission' => 16),
	array(
		'post_title' => '116-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1207028000,
		'post_mission' => 6),
	array(
		'post_title' => '116-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1207029000,
		'post_mission' => 16),
	
	array(
		'post_title' => '117-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1209618000,
		'post_mission' => 17),
	array(
		'post_title' => '117-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1209619000,
		'post_mission' => 17),
	array(
		'post_title' => '117-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1209620000,
		'post_mission' => 17),
	array(
		'post_title' => '117-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1209621000,
		'post_mission' => 17),
		
	array(
		'post_title' => '118-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1212296400,
		'post_mission' => 18),
	array(
		'post_title' => '118-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1212297400,
		'post_mission' => 18),
	array(
		'post_title' => '118-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1212298400,
		'post_mission' => 18),
	array(
		'post_title' => '118-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1212299400,
		'post_mission' => 18),
		
	array(
		'post_title' => '119-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1214888400,
		'post_mission' => 19),
	array(
		'post_title' => '119-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1214889400,
		'post_mission' => 19),
	array(
		'post_title' => '119-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1214890400,
		'post_mission' => 19),
	array(
		'post_title' => '119-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1214891400,
		'post_mission' => 19),
	
	array(
		'post_title' => '120-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1217566800,
		'post_mission' => 20),
	array(
		'post_title' => '120-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1217567800,
		'post_mission' => 20),
	array(
		'post_title' => '120-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1217568800,
		'post_mission' => 20),
	array(
		'post_title' => '120-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1217569800,
		'post_mission' => 20),
		
	array(
		'post_title' => '121-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1220245200,
		'post_mission' => 21),
	array(
		'post_title' => '121-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1220246200,
		'post_mission' => 21),
	array(
		'post_title' => '121-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1220247200,
		'post_mission' => 21),
	array(
		'post_title' => '121-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1220248200,
		'post_mission' => 21),
		
	array(
		'post_title' => '122-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1222837200,
		'post_mission' => 22),
	array(
		'post_title' => '122-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1222838200,
		'post_mission' => 22),
	array(
		'post_title' => '122-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1222839200,
		'post_mission' => 22),
	array(
		'post_title' => '122-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1222840200,
		'post_mission' => 22),
	
	array(
		'post_title' => '123-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1225515600,
		'post_mission' => 23),
	array(
		'post_title' => '123-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1225516600,
		'post_mission' => 23),
	array(
		'post_title' => '123-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1225517600,
		'post_mission' => 23),
	array(
		'post_title' => '123-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1225518600,
		'post_mission' => 23),
		
	array(
		'post_title' => '124-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1228111200,
		'post_mission' => 24),
	array(
		'post_title' => '124-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1228112200,
		'post_mission' => 24),
	array(
		'post_title' => '124-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1228113200,
		'post_mission' => 24),
	array(
		'post_title' => '124-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1228114200,
		'post_mission' => 24),
		
	array(
		'post_title' => '125-01 Act 1',
		'post_authors' => '1',
		'post_content' => "Content",
		'post_date' => 1230789600,
		'post_mission' => 25),
	array(
		'post_title' => '125-02 Act 2',
		'post_authors' => '2',
		'post_content' => "Content",
		'post_date' => 1230790600,
		'post_mission' => 25),
	array(
		'post_title' => '125-03 Act 3',
		'post_authors' => '3',
		'post_content' => "Content",
		'post_date' => 1230791600,
		'post_mission' => 25),
	array(
		'post_title' => '125-04 Act 4',
		'post_authors' => '1,2',
		'post_content' => "Content",
		'post_date' => 1230792600,
		'post_mission' => 25),
);

$posts_comments = array(
	array(
		'pcomment_author_user' => 2,
		'pcomment_author_character' => 2,
		'pcomment_post' => 1,
		'pcomment_content' => 'Very good first mission post!',
		'pcomment_date' => now()),
	array(
		'pcomment_author_user' => 1,
		'pcomment_author_character' => 1,
		'pcomment_post' => 2,
		'pcomment_content' => 'Thanks, I really enjoyed writing this one. You and I should do one soon.',
		'pcomment_date' => now()),
	array(
		'pcomment_author_user' => 2,
		'pcomment_author_character' => 2,
		'pcomment_post' => 1,
		'pcomment_content' => 'Sounds like a plan, just drop me a note when you want to get started.',
		'pcomment_date' => now())
);

$specs = array(
	array(
		'specs_name' => 'Item 1',
		'specs_order' => 0,
		'specs_summary' => 'Lorem ipsum...'),
	array(
		'specs_name' => 'Item 2',
		'specs_order' => 1,
		'specs_summary' => 'Lorem ipsum...'),
);

$specs_data = array(
	array(
		'data_field' => 1,
		'data_value' => 'Prometheus',
		'data_item' => 1),
	array(
		'data_field' => 2,
		'data_value' => 'Heavy Cruiser',
		'data_item' => 1),
	array(
		'data_field' => 3,
		'data_value' => '75 years',
		'data_item' => 1),
	array(
		'data_field' => 4,
		'data_value' => '5 years',
		'data_item' => 1),
	array(
		'data_field' => 5,
		'data_value' => '1 year',
		'data_item' => 1),
	array(
		'data_field' => 6,
		'data_value' => '445 meters',
		'data_item' => 1),
	array(
		'data_field' => 7,
		'data_value' => '100 meters',
		'data_item' => 1),
	array(
		'data_field' => 8,
		'data_value' => '45 meters',
		'data_item' => 1),
	array(
		'data_field' => 9,
		'data_value' => '15',
		'data_item' => 1),
	array(
		'data_field' => 10,
		'data_value' => '10',
		'data_item' => 1),
	array(
		'data_field' => 11,
		'data_value' => '20',
		'data_item' => 1),
	array(
		'data_field' => 12,
		'data_value' => '30',
		'data_item' => 1),
	array(
		'data_field' => 13,
		'data_value' => '40',
		'data_item' => 1),
	array(
		'data_field' => 14,
		'data_value' => '500',
		'data_item' => 1),
	array(
		'data_field' => 15,
		'data_value' => 'Warp 7',
		'data_item' => 1),
	array(
		'data_field' => 16,
		'data_value' => 'Warp 9.8',
		'data_item' => 1),
	array(
		'data_field' => 17,
		'data_value' => 'Warp 9.9975',
		'data_item' => 1),
	array(
		'data_field' => 18,
		'data_value' => 'Shields',
		'data_item' => 1),
	array(
		'data_field' => 19,
		'data_value' => 'Weapon systems',
		'data_item' => 1),
	array(
		'data_field' => 20,
		'data_value' => 'Default load out',
		'data_item' => 1),
	array(
		'data_field' => 21,
		'data_value' => '2',
		'data_item' => 1),
	array(
		'data_field' => 22,
		'data_value' => '2 Standard Shuttles',
		'data_item' => 1),
	array(
		'data_field' => 23,
		'data_value' => '5 Fighters',
		'data_item' => 1),
	array(
		'data_field' => 24,
		'data_value' => '1 Runabout',
		'data_item' => 1),
		
	array(
		'data_field' => 1,
		'data_value' => 'Prometheus',
		'data_item' => 2),
	array(
		'data_field' => 2,
		'data_value' => 'Heavy Cruiser',
		'data_item' => 2),
	array(
		'data_field' => 3,
		'data_value' => '75 years',
		'data_item' => 2),
	array(
		'data_field' => 4,
		'data_value' => '5 years',
		'data_item' => 2),
	array(
		'data_field' => 5,
		'data_value' => '1 year',
		'data_item' => 2),
	array(
		'data_field' => 6,
		'data_value' => '445 meters',
		'data_item' => 2),
	array(
		'data_field' => 7,
		'data_value' => '100 meters',
		'data_item' => 2),
	array(
		'data_field' => 8,
		'data_value' => '45 meters',
		'data_item' => 2),
	array(
		'data_field' => 9,
		'data_value' => '15',
		'data_item' => 2),
	array(
		'data_field' => 10,
		'data_value' => '10',
		'data_item' => 2),
	array(
		'data_field' => 11,
		'data_value' => '20',
		'data_item' => 2),
	array(
		'data_field' => 12,
		'data_value' => '30',
		'data_item' => 2),
	array(
		'data_field' => 13,
		'data_value' => '40',
		'data_item' => 2),
	array(
		'data_field' => 14,
		'data_value' => '500',
		'data_item' => 2),
	array(
		'data_field' => 15,
		'data_value' => 'Warp 7',
		'data_item' => 2),
	array(
		'data_field' => 16,
		'data_value' => 'Warp 9.8',
		'data_item' => 2),
	array(
		'data_field' => 17,
		'data_value' => 'Warp 9.9975',
		'data_item' => 2),
	array(
		'data_field' => 18,
		'data_value' => 'Shields',
		'data_item' => 2),
	array(
		'data_field' => 19,
		'data_value' => 'Weapon systems',
		'data_item' => 2),
	array(
		'data_field' => 20,
		'data_value' => 'Default load out',
		'data_item' => 2),
	array(
		'data_field' => 21,
		'data_value' => '2',
		'data_item' => 2),
	array(
		'data_field' => 22,
		'data_value' => '2 Standard Shuttles',
		'data_item' => 2),
	array(
		'data_field' => 23,
		'data_value' => '5 Fighters',
		'data_item' => 2),
	array(
		'data_field' => 24,
		'data_value' => '1 Runabout',
		'data_item' => 2),
);

$tour = array(
	array(
		'tour_name' => 'Main Bridge',
		'tour_order' => 0,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'tour_spec_item' => 1),
	array(
		'tour_name' => 'Main Engineering',
		'tour_order' => 1,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'tour_spec_item' => 2),
);

$tour_data = array(
	array(
		'data_field' => 1,
		'data_tour_item' => 1,
		'data_value' => 'Deck 1',
		'data_updated' => now()),
	array(
		'data_field' => 2,
		'data_tour_item' => 1,
		'data_value' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
		'data_updated' => now()),
);

$tour_decks = array(
	array(
		'deck_name' => 'Deck 1',
		'deck_order' => 1,
		'deck_content' => "Main Bridge\r\nCO's Ready Room\r\nObservation Lounge"),
	array(
		'deck_name' => 'Beta Deck',
		'deck_order' => 2,
		'deck_content' => "CO's Quarters"),
);
