<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Development Data
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

/**
 * Data array with the table/array names used
 */
$data = array(
	'awards',
	'characters',
	'mission_groups',
	'missions',
	'news',
	'users',
);

$data1 = array(
	'awards',
	'awards_queue',
	'awards_received',
	'characters_data',
	'characters_fields',
	'characters_values',
	'characters',
	'coc',
	'docking_fields',
	'docking_sections',
	//'forms',
	'mission_groups',
	'missions',
	'news',
	'news_comments',
	'personal_logs',
	'personal_logs_comments',
	'users',
	'posts',
	'posts_comments',
	'specs_data',
	'specs_fields',
	'specs_sections',
	'tour',
	'tour_data',
	'tour_fields',
	'tour_decks'
);

/**
 * Arrays of data with the information being inserted into the database
 */
$awards = array(
	array(
		'award_name' => 'Star of Kobol',
		'award_order' => 0,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic'),
	array(
		'award_name' => 'Tauron Medal of Valor',
		'award_order' => 1,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'both'),
	array(
		'award_name' => 'Oustanding Volunteer',
		'award_order' => 2,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ooc'),
	array(
		'award_name' => 'Caprican Medal of Cooperation',
		'award_order' => 3,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic'),
	array(
		'award_name' => 'Wings of Aerilon',
		'award_order' => 4,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic'),
	array(
		'award_name' => 'Order of the 12 Colonies',
		'award_order' => 5,
		'award_desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		'award_cat' => 'ic'),
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
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Male'),
	array(
		'data_field' => 2,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Human'),
	array(
		'data_field' => 3,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => '59'),
	array(
		'data_field' => 4,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => '6\'0"'),
	array(
		'data_field' => 5,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => '225 lbs.'),
	array(
		'data_field' => 6,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Gray'),
	array(
		'data_field' => 7,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Brown'),
	array(
		'data_field' => 8,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
		
	array(
		'data_field' => 9,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => "Personality overview here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 10,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => "Strengths and weaknesses go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 11,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => "Ambitions go here.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."),
	array(
		'data_field' => 12,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'All my hobbies and different interests go here.'),
		
	array(
		'data_field' => 13,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Father'),
	array(
		'data_field' => 14,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Mother'),
	array(
		'data_field' => 15,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Brother'),
	array(
		'data_field' => 16,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Sister'),
	array(
		'data_field' => 17,
		'data_user' => 1,
		'data_char' => 1,
		'data_updated' => date::now(),
		'data_value' => 'Other Family'),
);

$characters = array(
	array(
		'first_name' => 'William',
		'last_name' => 'Adama',
		'position_1' => 1,
		'rank' => 2,
		'date_activate' => date::now(),
		'user' => 1),
	array(
		'first_name' => 'Saul',
		'last_name' => 'Tigh',
		'position_1' => 2,
		'rank' => 4,
		'date_activate' => date::now(),
		'user' => 2),
	array(
		'first_name' => 'Lee',
		'last_name' => 'Adama',
		'position_1' => 9,
		'rank' => 6,
		'date_activate' => date::now(),
		'user' => 3),
	array(
		'first_name' => 'Kara',
		'last_name' => 'Thrace',
		'position_1' => 10,
		'rank' => 7,
		'date_activate' => date::now(),
		'user' => 4),
	array(
		'first_name' => 'Gaius',
		'last_name' => 'Baltar',
		'position_1' => 31,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Karl',
		'last_name' => 'Agathon',
		'position_1' => 14,
		'rank' => 7,
		'date_activate' => date::now(),
		'user' => 5),
	array(
		'first_name' => 'Sharon',
		'last_name' => 'Valerii',
		'position_1' => 13,
		'rank' => 9,
		'date_activate' => date::now(),
		'user' => 5),
	array(
		'first_name' => 'Galen',
		'last_name' => 'Tyrol',
		'position_1' => 15,
		'rank' => 12,
		'date_activate' => date::now(),
		'user' => 2),
	array(
		'first_name' => 'Felix',
		'last_name' => 'Gaeta',
		'position_1' => 4,
		'rank' => 9,
		'date_activate' => date::now(),
		'user' => 4),
	array(
		'first_name' => 'Samuel',
		'last_name' => 'Anders',
		'position_1' => 11,
		'rank' => 10,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Anastasia',
		'last_name' => 'Dualla',
		'position_1' => 5,
		'rank' => 15,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Brendan',
		'last_name' => 'Costanza',
		'position_1' => 11,
		'rank' => 9,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Louanne',
		'last_name' => 'Katraine',
		'position_1' => 10,
		'rank' => 7,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Laura',
		'last_name' => 'Roslin',
		'position_1' => 26,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Tom',
		'last_name' => 'Zarek',
		'position_1' => 27,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
	array(
		'first_name' => 'Tory',
		'last_name' => 'Foster',
		'position_1' => 28,
		'rank' => 20,
		'crew_type' => 'npc',
		'date_activate' => date::now()),
);

$docking_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'duration',
		'field_label_page' => 'Duration',
		'field_order' => 0,
		'field_section' => 1),
	array(
		'field_type' => 'textarea',
		'field_name' => 'reason',
		'field_label_page' => 'Reason for Docking',
		'field_order' => 1,
		'field_section' => 1),
);

$docking_sections = array(
	array(
		'section_name' => 'Details',
		'section_order' => 0)
);

$mission_groups = array(
	array(
		'misgroup_name' => 'Miniseries',
		'misgroup_order' => 0,
		'misgroup_desc' => "The gambit. This is the story of how the Cylons attacked the Galactica began its journey toward Earth."),
	array(
		'misgroup_name' => 'Season 1',
		'misgroup_order' => 1,
		'misgroup_desc' => "After the Cylons genocidal attack on the Twelve Colonies, a rag-tag fugitive fleet under the aegis of the battlestar Galactica tackles the problems inherent of their evasive flight from their murderers."),
	array(
		'misgroup_name' => 'Season 2',
		'misgroup_order' => 2,
		'misgroup_desc' => "Following the discovery of Kobol, the arrest of Laura Roslin, and the attempted assassination of William Adama, the Fleet finds itself thrust into more peril, but, with the discovery of Pegasus and New Caprica, also hope. Yet, all prospects of a better future are squashed sooner or later."),
	array(
		'misgroup_name' => 'Season 3',
		'misgroup_order' => 3,
		'misgroup_desc' => "The stranded Colonials struggle to survive under the brutal Cylon rule of New Caprica, but when Galactica returns to save humanity, the fledgling Fleet resumes its search for Earth. The Cylons, after losing control on New Caprica, depart on their own mysterious quest for Earth."),
	array(
		'misgroup_name' => 'Season 4',
		'misgroup_order' => 4,
		'misgroup_desc' => "The final season of the Re-imagined Series, surrounding the revelation of the last member of the Final Five, the mystery surrounding Kara Thrace's return, the continuing search for Earth that will likely end in her discovery by the Fleet, and a cult lead by the well-loathed, unwanted (yet pardoned) disgraced former president, Gaius Baltar."),
);

$missions = array(
	array(
		'mission_title' => 'Saga of a Star World, Part 1',
		'mission_order' => 0,
		'mission_status' => 'completed',
		'mission_start' => 1167631200,
		'mission_end' => 1170309600,
		'mission_group' => 1,
		'mission_desc' => "After 40 years of peace with their creations, the Cylons, the peoples of the Twelve Colonies of Kobol find themselves victims of a genocidal attack."),
	array(
		'mission_title' => 'Saga of a Star World, Part 2',
		'mission_order' => 1,
		'mission_status' => 'completed',
		'mission_start' => 1167631200,
		'mission_end' => 1170309600,
		'mission_group' => 1,
		'mission_desc' => "Galactica, the last battlestar, is determined to join the fight against the Cylons that attacked the Twelve Colonies. But the faces of the Cylons are changing, and the odds are against the last battlestar's survival."),
	array(
		'mission_title' => '33',
		'mission_order' => 2,
		'mission_status' => 'completed',
		'mission_start' => 1170309600,
		'mission_end' => 1172728800,
		'mission_group' => 2,
		'mission_desc' => "Galactica and the Fleet must avoid their Cylon pursuers, which ambush them every 33 minutes after each successful jump."),
	array(
		'mission_title' => 'Water',
		'mission_order' => 3,
		'mission_status' => 'completed',
		'mission_start' => 1172728800,
		'mission_end' => 1175403600,
		'mission_group' => 2,
		'mission_desc' => "Galactica loses over 60% of her water reserves due to sabotage, forcing the Fleet into a crisis and Commander Adama to seek a new supply."),
	array(
		'mission_title' => 'Bastille Day',
		'mission_order' => 4,
		'mission_status' => 'completed',
		'mission_start' => 1175403600,
		'mission_end' =>  1177995600,
		'mission_group' => 2,
		'mission_desc' => "After the Fleet finds water ice to replace that which was lost in sabotage, Galactica and the Fleet face a shortage of manpower to mine the ice, turning to their prisoner barge for help, with unexpected complications."),
	array(
		'mission_title' => 'Act of Contrition',
		'mission_order' => 5,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 2,
		'mission_desc' => "When several Viper pilots are killed in a freak accident, Adama turns to Starbuck for help - but her involvement in the aftermath of the accident and in training new pilots causes the truth surrounding Zak Adama's death to finally surface."),
	array(
		'mission_title' => "You Can't Go Home Again",
		'mission_order' => 6,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 3,
		'mission_desc' => "Commander Adama and Captain Lee Adama risk the security of the Fleet as they try to locate a downed Kara Thrace..."),
	array(
		'mission_title' => "Litmus",
		'mission_order' => 7,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 3,
		'mission_desc' => "When Aaron Doral turns up on Galactica and detonates a device made from the ship's own munitions, Adama orders a full investigation - and Galen Tyrol's relationship with Boomer becomes the focus of the investigation."),
	array(
		'mission_title' => "Six Degrees of Separation",
		'mission_order' => 8,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 3,
		'mission_desc' => "Shelly Godfrey, a copy of the humanoid Cylon Number Six claiming to be a former aide to Doctor Amarak, arrives on Galactica and accuses Gaius Baltar of collaborating with the Cylons."),
	array(
		'mission_title' => "Flesh and Bone",
		'mission_order' => 9,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 3,
		'mission_desc' => "When a copy of Leoben Conoy is captured aboard a civilian ship, President Roslin orders his interrogation, and Lieutenant Thrace is assigned the job. She finds herself facing the possibility that the Cylon may have planted a bomb somewhere in the Fleet."),
	array(
		'mission_title' => "Tigh Me Up, Tigh Me Down",
		'mission_order' => 10,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 4,
		'mission_desc' => "Colonel Tigh's world is turned upside down when his wife arrives on Galactica - but is she all she claims to be?"),
	array(
		'mission_title' => "The Hand of God",
		'mission_order' => 11,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 4,
		'mission_desc' => "With the Fleet short of fuel, Galactica launches a daring attack on a Cylon base."),
	array(
		'mission_title' => "Colonial Day",
		'mission_order' => 12,
		'mission_status' => 'completed',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 4,
		'mission_desc' => "Colonial Day is due, and Laura Roslin is using the occasion to institute an interim Quorum of Twelve; then Tom Zarek, duly selected as the representative of Sagittaron, stands for the post of Vice President, a position Roslin is determined he will not hold."),
	array(
		'mission_title' => "Kobol's Last Gleaming, Part 1",
		'mission_order' => 13,
		'mission_status' => 'current',
		'mission_start' => 1177995600,
		'mission_end' =>  1180674000,
		'mission_group' => 5,
		'mission_desc' => "Galactica discovers Kobol, and a chain of events are set in motion that threatens to change everything."),
	array(
		'mission_title' => "Kobol's Last Gleaming, Part 2",
		'mission_order' => 14,
		'mission_status' => 'upcoming',
		'mission_start' => 1177995600,
		'mission_group' => 5,
		'mission_desc' => "Starbuck has gone to Caprica. Adama insists Roslin must stand down as President. When she refuses, he is forced to deal with that situation while simultaneously adapting the plan to rid themselves of the Cylon baseship over Kobol."),
);

$news = array(
	array(
		'news_title' => "Welcome to Nova 2",
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "But wait, Nova 1 just came out, why Nova 2 so soon?",
		'news_date' => 1229483743,
		'news_cat' => 1,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Nova Says Hello to Comments',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_content' => "One of the new features that's found its way into Nova is comments. Users are now able to leave comments on personal logs, news items, and mission posts. Later on, comments will be available on the wiki as well!",
		'news_date' => 1229484743,
		'news_cat' => 2,
		'news_status' => 'saved'),
	array(
		'news_title' => 'Nova Goes Private',
		'news_author_user' => 1,
		'news_author_character' => 1,
		'news_private' => 'y',
		'news_content' => "A feature that's making it's way over from SMS is private news items. Sometimes, you just don't want everyone to see what you're telling the crew, or you need an easy way to get in touch with all of them quickly. Private news items insure that only your crew can see the news item. If a user navigates to the page, they won't ever know that there are more news items than what's shown.",
		'news_date' => 1229485743,
		'news_cat' => 3,
		'news_status' => 'activated'),
	array(
		'news_title' => 'Pending News',
		'news_author_user' => 2,
		'news_author_character' => 2,
		'news_content' => "One of the new features that's found its way into Nova is comments. Users are now able to leave comments on personal logs, news items, and mission posts. Later on, comments will be available on the wiki as well!",
		'news_date' => 1229484743,
		'news_cat' => 2,
		'news_status' => 'pending'),
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

$personal_logs = array(
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

$personal_logs_comments = array(
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
		'pcomment_date' => date::now()),
	array(
		'pcomment_author_user' => 1,
		'pcomment_author_character' => 1,
		'pcomment_post' => 2,
		'pcomment_content' => 'Thanks, I really enjoyed writing this one. You and I should do one soon.',
		'pcomment_date' => date::now()),
	array(
		'pcomment_author_user' => 2,
		'pcomment_author_character' => 2,
		'pcomment_post' => 1,
		'pcomment_content' => 'Sounds like a plan, just drop me a note when you want to get started.',
		'pcomment_date' => date::now())
);

$security_questions = array(
	array('question_value' => "What is your father's middle name?"),
	array('question_value' => "What was the name of your first pet?"),
	array('question_value' => "What city were you born in?"),
	array('question_value' => "What is your favorite animal?"),
	array('question_value' => "Who was your favorite teacher?"),
	array('question_value' => "What is the last book you read?")
);

$settings = array(
	array(
		'setting_key' => 'sim_name',
		'setting_value' => 'Nova 2 Beta',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_year',
		'setting_value' => '2386',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_type',
		'setting_value' => 2,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'maintenance',
		'setting_value' => 'off',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_main',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_admin',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_wiki',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_login',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'display_rank',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'bio_num_awards',
		'setting_value' => 10,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_playing',
		'setting_value' => 1,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_npc',
		'setting_value' => 3,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'system_email',
		'setting_value' => 'on',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'email_subject',
		'setting_value' => '[Nova 2 Beta]',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'timezone',
		'setting_value' => 'UTC',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'daylight_savings',
		'setting_value' => 'FALSE',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'date_format',
		'setting_value' => 'D M jS, Y @ g:ia',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_logs_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_posts_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'manifest_defaults',
		'setting_value' => "$('tr.active').show();,$('tr.npc').show();",
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'updates',
		'setting_value' => 'all',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'show_news',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'post_count_format',
		'setting_value' => 'multiple',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_sample_post',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_name',
		'setting_value' => 'Nova',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_address',
		'setting_value' => 'nova@anodyne-productions.com',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_mission_notes',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'online_timespan',
		'setting_value' => '5',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'posting_requirement',
		'setting_value' => 14,
		'setting_user_created' => 'n'),
);

$sim_type = array(
	array('simtype_name' => 'all'),
	array('simtype_name' => 'ship'),
	array('simtype_name' => 'base'),
	array('simtype_name' => 'colony'),
	array('simtype_name' => 'unit'),
	array('simtype_name' => 'realm'),
	array('simtype_name' => 'planet'),
	array('simtype_name' => 'organization')
);

$specs_data = array(
	array(
		'data_field' => 1,
		'data_value' => 'Prometheus'),
	array(
		'data_field' => 2,
		'data_value' => 'Heavy Cruiser'),
	array(
		'data_field' => 3,
		'data_value' => '75 years'),
	array(
		'data_field' => 4,
		'data_value' => '5 years'),
	array(
		'data_field' => 5,
		'data_value' => '1 year'),
		
	array(
		'data_field' => 6,
		'data_value' => '445 meters'),
	array(
		'data_field' => 7,
		'data_value' => '100 meters'),
	array(
		'data_field' => 8,
		'data_value' => '45 meters'),
	array(
		'data_field' => 9,
		'data_value' => '15'),
		
	array(
		'data_field' => 10,
		'data_value' => '10'),
	array(
		'data_field' => 11,
		'data_value' => '20'),
	array(
		'data_field' => 12,
		'data_value' => '30'),
	array(
		'data_field' => 13,
		'data_value' => '40'),
	array(
		'data_field' => 14,
		'data_value' => '500'),
		
	array(
		'data_field' => 15,
		'data_value' => 'Warp 7'),
	array(
		'data_field' => 16,
		'data_value' => 'Warp 9.8'),
	array(
		'data_field' => 17,
		'data_value' => 'Warp 9.9975'),
		
	array(
		'data_field' => 18,
		'data_value' => 'Shields'),
	array(
		'data_field' => 19,
		'data_value' => 'Weapon systems'),
	array(
		'data_field' => 20,
		'data_value' => 'Default load out'),
		
	array(
		'data_field' => 21,
		'data_value' => '2'),
	array(
		'data_field' => 22,
		'data_value' => '2 Standard Shuttles'),
	array(
		'data_field' => 23,
		'data_value' => '5 Fighters'),
	array(
		'data_field' => 24,
		'data_value' => '1 Runabout'),
);

$specs_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'class',
		'field_fid' => 'class',
		'field_class' => '',
		'field_label_page' => 'Class',
		'field_order' => 0,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'role',
		'field_fid' => 'role',
		'field_class' => '',
		'field_label_page' => 'Role',
		'field_order' => 1,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'duration',
		'field_fid' => 'duration',
		'field_class' => '',
		'field_label_page' => 'Duration',
		'field_order' => 2,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'refit',
		'field_fid' => 'refit',
		'field_class' => '',
		'field_label_page' => 'Time Between Refits',
		'field_order' => 3,
		'field_section' => 1),
	array(
		'field_type' => 'text',
		'field_name' => 'resupply',
		'field_fid' => 'resupply',
		'field_class' => '',
		'field_label_page' => 'Time Between Resupply',
		'field_order' => 4,
		'field_section' => 1),
		
	array(
		'field_type' => 'text',
		'field_name' => 'length',
		'field_fid' => 'length',
		'field_class' => '',
		'field_label_page' => 'Length',
		'field_order' => 0,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'width',
		'field_fid' => 'width',
		'field_class' => '',
		'field_label_page' => 'Width',
		'field_order' => 1,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'height',
		'field_fid' => 'height',
		'field_class' => '',
		'field_label_page' => 'Height',
		'field_order' => 2,
		'field_section' => 2),
	array(
		'field_type' => 'text',
		'field_name' => 'decks',
		'field_fid' => 'decks',
		'field_class' => 'medium',
		'field_label_page' => 'Decks',
		'field_order' => 3,
		'field_section' => 2),
		
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_officers',
		'field_fid' => 'compliment_officers',
		'field_class' => 'medium',
		'field_label_page' => 'Officers',
		'field_order' => 0,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_enlisted',
		'field_fid' => 'compliment_enlisted',
		'field_class' => 'medium',
		'field_label_page' => 'Enlisted Crew',
		'field_order' => 1,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_marines',
		'field_fid' => 'compliment_marines',
		'field_class' => 'medium',
		'field_label_page' => 'Marines',
		'field_order' => 2,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_civilians',
		'field_fid' => 'compliment_civilians',
		'field_class' => 'medium',
		'field_label_page' => 'Civilians',
		'field_order' => 3,
		'field_section' => 3),
	array(
		'field_type' => 'text',
		'field_name' => 'compliment_emergency',
		'field_fid' => 'compliment_emergency',
		'field_class' => 'medium',
		'field_label_page' => 'Emergency Capacity',
		'field_order' => 4,
		'field_section' => 3),
		
	array(
		'field_type' => 'text',
		'field_name' => 'speed_normal',
		'field_fid' => 'speed_normal',
		'field_class' => 'medium',
		'field_label_page' => 'Cruise Speed',
		'field_order' => 0,
		'field_section' => 4),
	array(
		'field_type' => 'text',
		'field_name' => 'speed_max',
		'field_fid' => 'speed_max',
		'field_class' => 'medium',
		'field_label_page' => 'Maximum Speed',
		'field_order' => 1,
		'field_section' => 4),
	array(
		'field_type' => 'text',
		'field_name' => 'speed_emergency',
		'field_fid' => 'speed_emergency',
		'field_class' => 'medium',
		'field_label_page' => 'Emergency Speed',
		'field_order' => 2,
		'field_section' => 4),
		
	array(
		'field_type' => 'textarea',
		'field_name' => 'defensive',
		'field_fid' => 'defensive',
		'field_class' => '',
		'field_label_page' => 'Shields',
		'field_order' => 0,
		'field_section' => 5,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'weapons',
		'field_fid' => 'weapons',
		'field_class' => '',
		'field_label_page' => 'Weapon Systems',
		'field_order' => 1,
		'field_section' => 5,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'armament',
		'field_fid' => 'armament',
		'field_class' => '',
		'field_label_page' => 'Armament',
		'field_order' => 2,
		'field_section' => 5,
		'field_rows' => 5),
		
	array(
		'field_type' => 'text',
		'field_name' => 'shuttlebays',
		'field_fid' => 'shuttlebays',
		'field_class' => 'small',
		'field_label_page' => 'Shuttlebays',
		'field_order' => 0,
		'field_section' => 6),
	array(
		'field_type' => 'textarea',
		'field_name' => 'shuttles',
		'field_fid' => 'shuttles',
		'field_class' => '',
		'field_label_page' => 'Shuttles',
		'field_order' => 1,
		'field_section' => 6,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'fighters',
		'field_fid' => 'fighters',
		'field_class' => '',
		'field_label_page' => 'Fighters',
		'field_order' => 2,
		'field_section' => 6,
		'field_rows' => 5),
	array(
		'field_type' => 'textarea',
		'field_name' => 'runabouts',
		'field_fid' => 'runabouts',
		'field_class' => '',
		'field_label_page' => 'Runabouts',
		'field_order' => 3,
		'field_section' => 6,
		'field_rows' => 5),
);

$specs_sections = array(
	array(
		'section_name' => 'General',
		'section_order' => 0),
	array(
		'section_name' => 'Dimensions',
		'section_order' => 1),
	array(
		'section_name' => 'Personnel',
		'section_order' => 2),
	array(
		'section_name' => 'Speed',
		'section_order' => 3),
	array(
		'section_name' => 'Weapons &amp; Defensive Systems',
		'section_order' => 4),
	array(
		'section_name' => 'Auxiliary Craft',
		'section_order' => 5),
);

$system_components = array(
	array(
		'comp_name' => 'CodeIgniter',
		'comp_version' => '1.7.2',
		'comp_url' => 'http://codeigniter.com/',
		'comp_desc' => 'CodeIgniter is an open source web application framework for use in building dynamic web sites with PHP. It enables developers to build applications faster - compared to coding from scratch - by providing a rich set of libraries for commonly needed tasks, as well as a simple interface and a logical structure to access these libraries.'),
	array(
		'comp_name' => 'Thresher',
		'comp_version' => 'Release 1',
		'comp_url' => '',
		'comp_desc' => "Thresher is Anodyne Productions' integrated mini-wiki for Nova."),
	array(
		'comp_name' => 'Template Library',
		'comp_version' => '1.4.1',
		'comp_desc' => "The Template library, written for the CodeIgniter PHP-framework, is a wrapper for CI's View implementation. Template is a reaction to the numerous questions from the CI community regarding how one would display multiple views for one controller, and how to embed \"views within views\" in a standardized fashion. In addition, Template provides extra Views loading capabilities, the ability to utilize any template parser (like Smarty), and shortcuts for including CSS, JavaScript, and other common elements in your final rendered HTML.",
		'comp_url' => 'http://www.williamsconcepts.com/ci/codeigniter/libraries/template/index.html'),
	array(
		'comp_name' => 'jQuery',
		'comp_version' => '1.4.2',
		'comp_url' => 'http://www.jquery.com/',
		'comp_desc' => 'jQuery is a lightweight JavaScript library that emphasizes interaction between JavaScript and HTML.'),
	array(
		'comp_name' => 'jQuery UI',
		'comp_version' => '1.8',
		'comp_url' => 'http://jqueryui.com/',
		'comp_desc' => 'jQuery UI is a lightweight, easily customizable interface library for the jQuery Javascript library.'),
	array(
		'comp_name' => 'jQuery ColorBox',
		'comp_version' => '1.3.6',
		'comp_desc' => "A light-weight, customizable lightbox plugin for jQuery.",
		'comp_url' => 'http://colorpowered.com/colorbox/'),
	array(
		'comp_name' => 'Facebox',
		'comp_version' => '1.2',
		'comp_desc' => "Facebox is a jQuery-based lightbox which can display images, divs, or entire remote pages.",
		'comp_url' => 'http://famspam.com/facebox'),
	array(
		'comp_name' => 'AjaxQ',
		'comp_version' => '0.0.1',
		'comp_desc' => "AjaxQ is a jQuery plugin that implements an AJAX request queueing mechanism.",
		'comp_url' => 'http://plugins.jquery.com/project/ajaxq'),
	array(
		'comp_name' => 'qTip',
		'comp_version' => '1.0-r29',
		'comp_desc' => "qTip is an advanced tooltip plugin for the ever popular jQuery JavaScript framework. Built from the ground up to be user friendly, yet feature rich, qTip provides you with tonnes of features like rounded corners and speech bubble tips, and best of all... it's completely free under the MIT license!",
		'comp_url' => 'http://craigsworks.com/projects/qtip/'),
	array(
		'comp_name' => 'Lazy',
		'comp_version' => '1.3.1',
		'comp_desc' => "Lazy is an on-demand jQuery plugin loader, also known as a lazy loader. Instead of downloading all jQuery plugins you might or might not need when the page loads, Lazy downloads the plugins when you actually use them. Lazy is very lightweight, super fast, and smart. Lazy will keep track of all your plugins and dependencies and make sure that they are only downloaded once.",
		'comp_url' => 'http://www.unwrongest.com/projects/lazy/'),
	array(
		'comp_name' => 'Reflection.js',
		'comp_version' => '2.0',
		'comp_desc' => "Reflection.js allows you to add reflections to images on your webpages. It uses unobtrusive Javascript to keep your code clean.",
		'comp_url' => 'http://cow.neondragon.net/stuff/reflection/'),
	array(
		'comp_name' => 'jQuery QuickSearch',
		'comp_version' => '',
		'comp_desc' => "QuickSearch is a simple plugin for filtering tables, lists and paragraphs.",
		'comp_url' => 'http://rikrikrik.com/jquery/quicksearch/'),
	array(
		'comp_name' => 'markItUp!',
		'comp_version' => '1.1.6.1',
		'comp_desc' => "markItUp! is a JavaScript plugin built on the jQuery library that allows you to turn any textarea into a markup editor.",
		'comp_url' => 'http://markitup.jaysalvat.com/home/'),
	array(
		'comp_name' => 'Textile',
		'comp_version' => '2.0.0',
		'comp_desc' => "Textile is a lightweight markup language that converts its marked-up text input to valid, well-formed XHTML and also inserts character entity references for apostrophes, opening and closing single and double quotation marks, ellipses and em dashes.",
		'comp_url' => 'http://textile.thresholdstate.com/'),
	array(
		'comp_name' => 'PHP Markdown Extra',
		'comp_version' => '1.2.4',
		'comp_desc' => "PHP Markdown is a port to PHP of the Markdown program written by John Gruber. Markdown is two things: a plain text markup syntax, and a software tool that converts the plain text markup to HTML for publishing on the web.",
		'comp_url' => 'http://michelf.com/projects/php-markdown/'),
	array(
		'comp_name' => 'YAYparser',
		'comp_version' => '',
		'comp_desc' => "YAYparser is a regular expression driven YAML parser that is aimed to be small and easy to use.",
		'comp_url' => 'http://codeigniter.com/wiki/YAYparser/'),
	array(
		'comp_name' => 'jQuery Countdown',
		'comp_version' => '',
		'comp_desc' => "A simple plugin that counts down and updates the text every second.",
		'comp_url' => 'http://davidwalsh.name/jquery-countdown-plugin'),
	array(
		'comp_name' => 'Uniform',
		'comp_version' => '1.5',
		'comp_desc' => "Uniform masks your standard form controls with custom themed controls. It works in sync with your real form elements to ensure accessibility and compatibility.",
		'comp_url' => 'http://pixelmatrixdesign.com/uniform/'),
);

$system_info = array(
	array(
		'sys_uid' => text::random('alnum', 32),
		'sys_install_date' => date::now(),
		'sys_version_major' => 1,
		'sys_version_minor' => 0,
		'sys_version_update' => 4)
);

$system_versions = array(
	array(
		'version' => '1.0.0',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '0',
		'version_date' => 1271393940,
		'version_launch'	=> 'Nova 1.0 is the first release of the next generation RPG management software from Anodyne Productions.',
		'version_changes'	=> "* Initial release"),
	array(
		'version' => '1.0.1',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '1',
		'version_date' => 1271424600,
		'version_launch'	=> 'Nova 1.0.1 is a maintenance release that fixes two important issues with Nova 1.0. The release fixes a bug where the upgrade process did not create a necessary field in the missions table as well as two issues with installations oh PHP4 servers. This update is recommended for all users who have upgraded from SMS and/or are running on a PHP4 server.',
		'version_changes'	=> "* fixed bug in the upgrade process where a database field wasn't added to the table
* fixed bug where models couldn't be autoloaded because Base4 doesn't extend MY_Loader
* fixed error that was thrown because the date_default_timezone_set function doesn't exist in PHP before version 5.1"),
	array(
		'version' => '1.0.2',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '2',
		'version_date' => 1271817000,
		'version_launch'	=> 'Nova 1.0.2 is a maintenance release that fixes a majority of the outstanding issues with Nova 1.0, including: login issues, post display issues and bug with posting mission entries. See the changelog after updating for a complete list of changes. This update is recommended for all users.',
		'version_changes'	=> "* added the 1.0.2 update file
* added the MY\_Input library to add a call to a text cleanup function after filtering for XSS
* updated the database schema to use a genre field in the rank catalogue table
* updated the genre install files to populate the new genre field in the rank catalogue table on creation
* updated the language files
    * [base\_lang] added labels_genre key
    * [error\_lang] added error_login_7
* updated the ranks model to pull the genre when looking for the default rank catalogue item
* updated the ranks model to pull only the ranks sets from a genre when getting all ranks
* updated the ranks model to only pull rank catalogue items for the given genre
* updated the site controller to handle adding and editing the genre for a rank catalogue item
* updated the ajax controller to handle adding and editing the genre for a rank catalogue item
* updated the upload management page to show messages if uploaded images weren't found in specific categories
* updated the write news item page to not allow a user to have a news item without a category
* updated the index file to use a higher debug to allow people to see any errors for debugging purposes
* updated the upgrade process to fix some minor schema differences between sms and nova
* updated the ranks model so the get\_group\_ranks() method had a customizable identifier
* updated the auth library to check for a user's status and not allow pending users to log in to the system
* updated the login page to handle the new pending user error
* updated the Auth library to increase the login attempts allowed to 5
* updated the Auth library to attempt a fix to the remember me lockout issue
* updated the user account page to reset the cookie in the event of a password reset if the user has elected to have nova remember them
* updated the admin controller so that nova resets the cookie password after an SMS upgrade if the user has elected to have nova remember them
* fixed bug where the menu library wouldn't respect any access control put on main navigation menu items (#101)
* fixed bug where the menu library wouldn't respect any access control put on sub navigation menu items
* fixed undefined variable error thrown on site/catalogueranks
* fixed bug where rank catalogue items didn't work well when multiple genres were installed (#102)
* fixed bug where uploaded images besides bio images couldn't be deleted
* fixed bug where authors were being dropped off of posts because of faulty logic
* fixed bug where sample post wasn't sent out in the email sent to game masters
* fixed bug in IE where ranks couldn't be added
* fixed bug where rank classes wouldn't be shown for ranks sets without a blank name rank item
* fixed bug where the user bio pointed to the wrong location for user posts and awards
* fixed bug where listing all of a users' posts would display posts besides their own
* fixed error thrown on commenting on a mission post
* fixed fatal error thrown when updating a news item
* fixed fatal error thrown when updating a personal log
* fixed a presentational bug in login error #6
* fixed bug where the mission dropdown wasn't properly populated when viewing a saved post"),
	array(
		'version' => '1.0.3',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '3',
		'version_date' => 1272321000,
		'version_launch'	=> "Nova 1.0.3 is the third maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, several bugs with Thresher, changes to the update center to allow users to update even if they can't get the update information from the Anodyne server, NPC removal issues, updates to the user removal process and much more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.3 update file
* updated the install data
    * menu items
    * version info
* updated the language files
    * [base\_lang] added labels_you
    * [text\_lang] added character_change
* updated the versions array file
* updated the ajax controller to have a separate method for removing NPCs instead of piggybacking off of the delete character method
* updated the characters controller to put the NPC removal inside its own method instead of using the character removal process
* updated the posts model to clean some code up and added a parameter to the unattended posts method
* updated the dynamic form management pages (bio, docking, specs) to show notices if there are no fields in a section
* updated the panel tabs on the control panel to display a notice if there's no content available
* updated thresher to use the proper regions in the template config file
* updated the user deactivation process to deactivate a users' characters at the same time
* updated the update center to show the links to start the update regardless of whether there's information about the update or not
* updated the auth library to add some debugging code to help track down the remember me bug
* updated the process of updating the system to remove dependence on the versions array file and instead pull a listing of the update directory (we still use the versions array file in the event the directory listing fails)
* fixed bug where the create wiki entry page wasn't showing up in the sub navigation menu
* fixed bug where the posts model wasn't accurately counting unattended posts when a character ID was passed in as an integer instead of array
* fixed bug where errors were thrown when deleting characters and NPCs
* fixed an error being thrown on the write mission post page
* fixed bug where the post notification stayed active even after the post had been updated and/or sent out
* fixed errors that were thrown when adding a rank
* fixed error thrown when there are no fields in a specs form section
* fixed error thrown in the dashboard
* fixed bug where wiki pages were being put in the uncategorized section even if they had categories
* fixed error thrown for missing option parameters
* fixed error thrown during accepting/rejecting a docked ship application"),
	array(
		'version' => '1.0.4',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '4',
		'version_date' => 1273705200,
		'version_launch'	=> "Nova 1.0.4 is the fourth maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.4 update file
* added the MY\_Email library file
* updated the version update files to make sure the values get reset at the start of every file
* updated jquery ui to version 1.8.1
* updated markItUp! to version 1.1.7
* updated the textile parser to fix some bugs (thanks to dustin for catching this)
* updated the wiki controller to show an error message if the server is running php 4
* updated the archives controller to show an error message if the server is running php 4
* updated the MY\_Input library to try and do filtering for MS Word characters a little better
* fixed error thrown when a user with level 1 user account privileges updates their account
* fixed bug where saved personal logs could be shown in along with activated logs for users with multiple characters associated with their account
* fixed bug where IE threw an exception on the post, log, news and docked item management pages
* fixed error thrown on the contact page
* fixed errors thrown on the manage bio page for users with level 1 privileges
* fixed bug with the manage bio page where positions were updated when they shouldn't be
* fixed bug where the status change request email wasn't populated properly"),
);

$tour = array(
	array(
		'tour_name' => 'Main Bridge',
		'tour_order' => 0,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
	array(
		'tour_name' => 'Main Engineering',
		'tour_order' => 1,
		'tour_summary' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),
);

$tour_data = array(
	array(
		'data_field' => 1,
		'data_tour_item' => 1,
		'data_value' => 'Deck 1',
		'data_updated' => date::now()),
	array(
		'data_field' => 2,
		'data_tour_item' => 1,
		'data_value' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
		'data_updated' => date::now()),
);

$tour_fields = array(
	array(
		'field_type' => 'text',
		'field_name' => 'location',
		'field_fid' => 'location',
		'field_class' => '',
		'field_label_page' => 'Location',
		'field_order' => 0),
	array(
		'field_type' => 'textarea',
		'field_name' => 'long_desc',
		'field_fid' => 'long_desc',
		'field_class' => '',
		'field_label_page' => 'Description',
		'field_order' => 1,
		'field_rows' => 8),
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

$users = array(
	array(
		'name' => 'John Doe',
		'email' => 'john@example.com',
		'password' => Auth::hash('test'),
		'main_char' => 1,
		'access_role' => 4,
		'join_date' => date::now()),
	array(
		'name' => 'Jane Doe',
		'email' => 'jane@example.com',
		'password' => Auth::hash('test'),
		'main_char' => 2,
		'access_role' => 4,
		'join_date' => date::now()),
	array(
		'name' => 'Bill Doe',
		'email' => 'bill@example.com',
		'password' => Auth::hash('test'),
		'main_char' => 3,
		'access_role' => 4,
		'join_date' => date::now()),
	array(
		'name' => 'Deb Doe',
		'email' => 'deb@example.com',
		'password' => Auth::hash('test'),
		'main_char' => 4,
		'access_role' => 4,
		'join_date' => date::now()),
	array(
		'name' => 'Joe Doe',
		'email' => 'joe@example.com',
		'password' => Auth::hash('test'),
		'main_char' => 5,
		'access_role' => 4,
		'join_date' => date::now()),
);