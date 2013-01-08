<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * English language file - Base file
 *
 * @package		Nova
 * @category	Language
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 * @version		2.0
 */

// figure out what language the file is
$language = basename(dirname(__FILE__));

// include the various other language files
include_once MODPATH.'core/language/'.$language.'/headers_titles_lang.php';
include_once MODPATH.'core/language/'.$language.'/email_lang.php';
include_once MODPATH.'core/language/'.$language.'/error_lang.php';
include_once MODPATH.'core/language/'.$language.'/facebox_lang.php';
include_once MODPATH.'core/language/'.$language.'/text_lang.php';

/*
|---------------------------------------------------------------
| GLOBAL ITEMS
|---------------------------------------------------------------
*/

$lang['global_award']			= 'award';
$lang['global_awards']			= 'awards';
$lang['global_character']		= 'character';
$lang['global_characters']		= 'characters';
$lang['global_command_staff']	= 'command staff';
$lang['global_deck']			= 'deck';
$lang['global_decks']			= 'decks';
$lang['global_department']		= 'department';
$lang['global_departments']		= 'departments';
$lang['global_game_master']		= 'game master';
$lang['global_log']				= 'log';
$lang['global_logs']			= 'logs';
$lang['global_mission']			= 'mission';
$lang['global_missions']		= 'missions';
$lang['global_missiongroup']	= 'mission group';
$lang['global_missiongroups']	= 'mission groups';
$lang['global_missionpost']		= 'mission post';
$lang['global_missionposts']	= 'mission posts';
$lang['global_news']			= 'news';
$lang['global_newsitem']		= 'news item';
$lang['global_newsitems']		= 'news items';
$lang['global_personallog'] 	= 'personal log';
$lang['global_personallogs'] 	= 'personal logs';
$lang['global_position']		= 'position';
$lang['global_positions']		= 'positions';
$lang['global_post']			= 'post';
$lang['global_posts']			= 'posts';
$lang['global_privatemessage']	= 'private message';
$lang['global_privatemessages']	= 'private messages';
$lang['global_rank']			= 'rank';
$lang['global_ranks']			= 'ranks';
$lang['global_sim']				= 'sim';
$lang['global_sims']			= 'sims';
$lang['global_specification']	= 'specification';
$lang['global_specifications']	= 'specifications';
$lang['global_specs']			= 'specs';
$lang['global_subdepartment']	= 'sub department';
$lang['global_subdepartments']	= 'sub departments';
$lang['global_sysadmin']		= 'system administrator';
$lang['global_tour']			= 'tour';
$lang['global_touritem']		= 'tour item';
$lang['global_touritems']		= 'tour items';
$lang['global_user']			= 'user';
$lang['global_user_poss']		= 'user'. RSQUO .'s';
$lang['global_users']			= 'users';
$lang['global_webmaster']		= 'webmaster';
$lang['global_wiki']			= 'wiki';

/*
|---------------------------------------------------------------
| ABBREVIATIONS
|---------------------------------------------------------------
*/

$lang['abbr_avg']				= 'Avg';
$lang['abbr_eloa']				= 'ELOA';
$lang['abbr_forward']			= 'FWD';
$lang['abbr_html']				= 'HTML';
$lang['abbr_ic']				= 'IC';
$lang['abbr_id']				= 'ID';
$lang['abbr_loa']				= 'LOA';
$lang['abbr_npc']				= 'NPC';
$lang['abbr_npcs']				= 'NPCs';
$lang['abbr_ok']				= 'OK';
$lang['abbr_ooc']				= 'OOC';
$lang['abbr_reply']				= 'RE';
$lang['abbr_url']				= 'URL';

/*
|---------------------------------------------------------------
| ORDER
|---------------------------------------------------------------
*/

$lang['order_one']				= 'one';
$lang['order_two']				= 'two';
$lang['order_three']			= 'three';
$lang['order_four']				= 'four';
$lang['order_first']			= 'first';
$lang['order_second']			= 'second';
$lang['order_third']			= 'third';
$lang['order_fourth']			= 'fourth';
$lang['order_last']				= 'last';
$lang['order_middle']			= 'middle';
$lang['order_primary']			= 'primary';

/*
|---------------------------------------------------------------
| STATUS
|---------------------------------------------------------------
*/

$lang['status_active']			= 'active';
$lang['status_activated']		= 'activated';
$lang['status_closed']			= 'closed';
$lang['status_completed']		= 'completed';
$lang['status_current']			= 'current';
$lang['status_end']				= 'end';
$lang['status_eloa']			= 'extended leave of absence';
$lang['status_inactive']		= 'inactive';
$lang['status_incremental']		= 'incremental';
$lang['status_latest']			= 'latest';
$lang['status_loa']				= 'leave of absence';
$lang['status_major']			= 'major';
$lang['status_minor']			= 'minor';
$lang['status_new']				= 'new';
$lang['status_nonplaying']		= 'non-playing';
$lang['status_old']				= 'old';
$lang['status_older']			= 'older';
$lang['status_open']			= 'open';
$lang['status_pending']			= 'pending';
$lang['status_playing']			= 'playing';
$lang['status_previous']		= 'previous';
$lang['status_recent']			= 'recent';
$lang['status_recently']		= 'recently';
$lang['status_saved']			= 'saved';
$lang['status_start']			= 'start';
$lang['status_unread']			= 'unread';
$lang['status_upcoming']		= 'upcoming';

/*
|---------------------------------------------------------------
| TIME
|---------------------------------------------------------------
*/

$lang['time_active_for']		= 'active for';
$lang['time_ago']				= 'ago';
$lang['time_dates']				= 'dates';
$lang['time_days']				= 'days';
$lang['time_from']				= 'from';
$lang['time_hours']				= 'hours';
$lang['time_hours_ahead']		= 'hours ahead of you';
$lang['time_hours_behind']		= 'hours behind you';
$lang['time_last_month']		= 'last month';
$lang['time_minute']			= 'minute';
$lang['time_minutes']			= 'minutes';
$lang['time_month']				= 'month';
$lang['time_months']			= 'months';
$lang['time_now']				= 'now';
$lang['time_per_week']			= 'per week';
$lang['time_hours_same']		= 'same timezone as you are';
$lang['time_this_month']		= 'this month';
$lang['time_timespan']			= 'timespan';
$lang['time_year']				= 'year';

/*
|---------------------------------------------------------------
| MISC
|---------------------------------------------------------------
*/

$lang['misc_label_online'] 		= "Who's Online Timespan";
$lang['misc_textarea_rows']		= 'Textarea Rows';
$lang['misc_select']			= 'For Dropdown Menus Only';
$lang['misc_html_attr']			= 'HTML Attributes';
$lang['misc_server_dir']		= 'Server Directory';
$lang['misc_development']		= 'In Development';
$lang['misc_login_y']			= 'Must be logged in';
$lang['misc_login_n']			= 'Must be logged out';
$lang['misc_level1_only']		= 'Level 1 Only';
$lang['misc_draft_cleanup']		= 'All drafts not associated with a page';

/*
|---------------------------------------------------------------
| ACTIONS
|---------------------------------------------------------------
*/

$lang['actions_accept']			= 'accept';
$lang['actions_accepted']		= 'accepted';
$lang['actions_action']			= 'action';
$lang['actions_activate']		= 'activate';
$lang['actions_activated']		= 'activated';
$lang['actions_add']			= 'add';
$lang['actions_added']			= 'added';
$lang['actions_agree']			= 'agree';
$lang['actions_agreed']			= 'agreed';
$lang['actions_applied']		= 'applied';
$lang['actions_apply']			= 'apply';
$lang['actions_approve']		= 'approve';
$lang['actions_approved']		= 'approved';
$lang['actions_assign']			= 'assign';
$lang['actions_assigned']		= 'assigned';
$lang['actions_awarded']		= 'awarded';
$lang['actions_back']			= 'back';
$lang['actions_change']			= 'change';
$lang['actions_changes']		= 'changes';
$lang['actions_choose']			= 'choose';
$lang['actions_cleanup']		= 'clean up';
$lang['actions_confirm']		= 'confirm';
$lang['actions_contact']		= 'contact';
$lang['actions_create']			= 'create';
$lang['actions_created']		= 'created';
$lang['actions_deactivate']		= 'deactivate';
$lang['actions_deactivated']	= 'deactivated';
$lang['actions_delete']			= 'delete';
$lang['actions_deleted']		= 'deleted';
$lang['actions_demote']			= 'demote';
$lang['actions_demoted']		= 'demoted';
$lang['actions_dock']			= 'dock';
$lang['actions_docked']			= 'docked';
$lang['actions_docking']		= 'docking';
$lang['actions_duplicate']		= 'duplicate';
$lang['actions_duplicated']		= 'duplicated';
$lang['actions_edit']			= 'edit';
$lang['actions_edited']			= 'edited';
$lang['actions_editing']		= 'editing';
$lang['actions_forward']		= 'forward';
$lang['actions_found']			= 'found';
$lang['actions_get']			= 'get';
$lang['actions_give']			= 'give';
$lang['actions_given']			= 'given';
$lang['actions_hide']			= 'hide';
$lang['actions_ignore']			= 'ignore';
$lang['actions_install']		= 'install';
$lang['actions_installed']		= 'installed';
$lang['actions_join']			= 'join';
$lang['actions_joined']			= 'joined';
$lang['actions_keep']			= 'keep';
$lang['actions_loading']		= 'loading';
$lang['actions_login']			= 'log in';
$lang['actions_logout']			= 'log out';
$lang['actions_make']			= 'make';
$lang['actions_manage']			= 'manage';
$lang['actions_managed']		= 'managed';
$lang['actions_moderate']		= 'moderate';
$lang['actions_moderated']		= 'moderated';
$lang['actions_next']			= 'next';
$lang['actions_nominate']		= 'nominate';
$lang['actions_nominated']		= 'nominated';
$lang['actions_post']			= 'post';
$lang['actions_posted']			= 'posted';
$lang['actions_processing']		= 'processing';
$lang['actions_promote']		= 'promote';
$lang['actions_promoted']		= 'promoted';
$lang['actions_reassign']		= 'reassign';
$lang['actions_receive']		= 'receive';
$lang['actions_received']		= 'received';
$lang['actions_reject']			= 'reject';
$lang['actions_rejected']		= 'rejected';
$lang['actions_release']		= 'release';
$lang['actions_remember']		= 'remember';
$lang['actions_remove']			= 'remove';
$lang['actions_removed']		= 'removed';
$lang['actions_reply']			= 'reply';
$lang['actions_request']		= 'request';
$lang['actions_reset']			= 'reset';
$lang['actions_restrict']		= 'restrict';
$lang['actions_revert']			= 'revert';
$lang['actions_reverted']		= 'reverted';
$lang['actions_run']			= 'run';
$lang['actions_save']			= 'save';
$lang['actions_saved']			= 'saved';
$lang['actions_search']			= 'search';
$lang['actions_seeall']			= 'see all';
$lang['actions_select']			= 'select';
$lang['actions_send']			= 'send';
$lang['actions_sent']			= 'sent';
$lang['actions_show']			= 'show';
$lang['actions_submit']			= 'submit';
$lang['actions_submitted']		= 'submitted';
$lang['actions_taken']			= 'taken';
$lang['actions_toggle']			= 'toggle';
$lang['actions_update']			= 'update';
$lang['actions_updated']		= 'updated';
$lang['actions_upload']			= 'upload';
$lang['actions_uploaded']		= 'uploaded';
$lang['actions_use']			= 'use';
$lang['actions_verified']		= 'verified';
$lang['actions_verify']			= 'verify';
$lang['actions_view']			= 'view';
$lang['actions_viewed']			= 'viewed';
$lang['actions_viewall']		= 'view all';
$lang['actions_write']			= 'write';
$lang['actions_wrote']			= 'wrote';

/*
|---------------------------------------------------------------
| LABELS
|---------------------------------------------------------------
*/

$lang['labels_a'] 				= 'a';
$lang['labels_access']			= 'access';
$lang['labels_account']			= 'account';
$lang['labels_activity'] 		= 'activity';
$lang['labels_actual']			= 'actual';
$lang['labels_addtl_info'] 		= 'additional information';
$lang['labels_admin']			= 'admin';
$lang['labels_again']			= 'again';
$lang['labels_all']				= 'all';
$lang['labels_allowed']			= 'allowed';
$lang['labels_an'] 				= 'an';
$lang['labels_answer']			= 'answer';
$lang['labels_appearance'] 		= 'appearance';
$lang['labels_application']		= 'application';
$lang['labels_applications']	= 'applications';
$lang['labels_area']			= 'area';
$lang['labels_association']		= 'association';
$lang['labels_author']			= 'author';
$lang['labels_authors']			= 'authors';
$lang['labels_available']		= 'available';
$lang['labels_average']			= 'average';
$lang['labels_ban']				= 'ban';
$lang['labels_bans']			= 'bans';
$lang['labels_basic']			= 'basic';
$lang['labels_bio']				= 'bio';
$lang['labels_biography']		= 'biography';
$lang['labels_blank']			= 'blank';
$lang['labels_blurb'] 			= 'blurb';
$lang['labels_both'] 			= 'both';
$lang['labels_by'] 				= 'by';
$lang['labels_catalogue']		= 'catalogue';
$lang['labels_categories'] 		= 'categories';
$lang['labels_category'] 		= 'category';
$lang['labels_coc']				= 'Chain of Command';
$lang['labels_codeigniter']		= 'CodeIgniter';
$lang['labels_components']		= 'components';
$lang['labels_control']			= 'control';
$lang['labels_class'] 			= 'class';
$lang['labels_classes'] 		= 'classes';
$lang['labels_comment'] 		= 'comment';
$lang['labels_comments'] 		= 'comments';
$lang['labels_contact']			= 'contact form';
$lang['labels_content'] 		= 'content';
$lang['labels_controlpanel'] 	= 'Control Panel';
$lang['labels_count']			= 'count';
$lang['labels_credits']			= 'credits';
$lang['labels_crew']			= 'crew';
$lang['labels_dashboard']		= 'dashboard';
$lang['labels_data']			= 'data';
$lang['labels_database']		= 'database';
$lang['labels_date']			= 'date';
$lang['labels_dates']			= 'dates';
$lang['labels_default']			= 'default';
$lang['labels_dob'] 			= 'Date of Birth';
$lang['labels_dst']				= 'daylight savings time';
$lang['labels_desc'] 			= 'description';
$lang['labels_details'] 		= 'details';
$lang['labels_display'] 		= 'display';
$lang['labels_draft']			= 'draft';
$lang['labels_drafts']			= 'drafts';
$lang['labels_dropdown']		= 'dropdown';
$lang['labels_duration'] 		= 'duration';
$lang['labels_email'] 			= 'email';
$lang['labels_email_address'] 	= 'email address';
$lang['labels_enlisted']		= 'enlisted';
$lang['labels_entries']			= 'entries';
$lang['labels_entry'] 			= 'entry';
$lang['labels_expected']		= 'expected';
$lang['labels_extension']		= 'extension';
$lang['labels_external']		= 'external';
$lang['labels_field']			= 'field';
$lang['labels_fields']			= 'fields';
$lang['labels_file']			= 'file';
$lang['labels_files']			= 'files';
$lang['labels_filters']			= 'filters';
$lang['labels_for'] 			= 'for';
$lang['labels_form']			= 'form';
$lang['labels_format']			= 'format';
$lang['labels_from']			= 'from';
$lang['labels_general'] 		= 'general';
$lang['labels_genre']			= 'genre';
$lang['labels_group'] 			= 'group';
$lang['labels_grouping']		= 'grouping';
$lang['labels_groups']			= 'groups';
$lang['labels_header']			= 'header';
$lang['labels_history']			= 'history';
$lang['labels_image'] 			= 'image';
$lang['labels_images'] 			= 'images';
$lang['labels_im'] 				= 'instant messenger(s)';
$lang['labels_in'] 				= 'in';
$lang['labels_included']		= 'included';
$lang['labels_ic'] 				= 'in character';
$lang['labels_inbox']			= 'inbox';
$lang['labels_info']			= 'info';
$lang['labels_information']		= 'information';
$lang['labels_interests']		= 'interests';
$lang['labels_ipaddr']			= 'IP address';
$lang['labels_item']			= 'item';
$lang['labels_items']			= 'items';
$lang['labels_key'] 			= 'key';
$lang['labels_label']			= 'label';
$lang['labels_language'] 		= 'language';
$lang['labels_left']			= 'left';
$lang['labels_less'] 			= 'less';
$lang['labels_level']			= 'level';
$lang['labels_link']			= 'link';
$lang['labels_linked']			= 'linked';
$lang['labels_links']			= 'links';
$lang['labels_list']			= 'list';
$lang['labels_listing']			= 'listing';
$lang['labels_listings']		= 'listings';
$lang['labels_location'] 		= 'location';
$lang['labels_lock'] 			= 'lock';
$lang['labels_locked'] 			= 'locked';
$lang['labels_login']			= 'login';
$lang['labels_main'] 			= 'main';
$lang['labels_maintanance']		= 'maintanance';
$lang['labels_manifest']		= 'manifest';
$lang['labels_manifests']		= 'manifests';
$lang['labels_me']				= 'me';
$lang['labels_menu']			= 'menu';
$lang['labels_menus']			= 'menus';
$lang['labels_message'] 		= 'message';
$lang['labels_messages'] 		= 'messages';
$lang['labels_milestones'] 		= 'milestones';
$lang['labels_mode']			= 'mode';
$lang['labels_more'] 			= 'more';
$lang['labels_multiple']		= 'multiple';
$lang['labels_my'] 				= 'my';
$lang['labels_name'] 			= 'name';
$lang['labels_navigation']		= 'navigation';
$lang['labels_no'] 				= 'no';
$lang['labels_nomination']		= 'nomination';
$lang['labels_nominations']		= 'nominations';
$lang['labels_none'] 			= 'none';
$lang['labels_notes']			= 'notes';
$lang['labels_notification'] 	= 'notification';
$lang['labels_notifications'] 	= 'notifications';
$lang['labels_number']			= 'number';
$lang['labels_of']				= 'of';
$lang['labels_off'] 			= 'off';
$lang['labels_officer'] 		= 'officer';
$lang['labels_offsite']			= 'offsite';
$lang['labels_on'] 				= 'on';
$lang['labels_only']			= 'only';
$lang['labels_onsite']			= 'onsite';
$lang['labels_ooc'] 			= 'out of character';
$lang['labels_open_slots'] 		= 'open slots';
$lang['labels_options']			= 'options';
$lang['labels_order'] 			= 'order';
$lang['labels_other'] 			= 'other';
$lang['labels_pace'] 			= 'pace';
$lang['labels_page']			= 'page';
$lang['labels_pages']			= 'pages';
$lang['labels_parent'] 			= 'parent';
$lang['labels_part']			= 'part';
$lang['labels_participants']	= 'participants';
$lang['labels_password'] 		= 'password';
$lang['labels_per']				= 'per';
$lang['labels_please'] 			= 'please';
$lang['labels_post_count']		= 'Post Count: ';
$lang['labels_posting'] 		= 'posting';
$lang['labels_preference']		= 'preference';
$lang['labels_preferences']		= 'preferences';
$lang['labels_preview']			= 'preview';
$lang['labels_private'] 		= 'private';
$lang['labels_question']		= 'question';
$lang['labels_queue']			= 'queue';
$lang['labels_reason'] 			= 'reason';
$lang['labels_recipient']		= 'recipient';
$lang['labels_recipients']		= 'recipients';
$lang['labels_records']			= 'records';
$lang['labels_refresh']			= 'refresh';
$lang['labels_request']			= 'request';
$lang['labels_requests']		= 'requests';
$lang['labels_requirement']		= 'requirement';
$lang['labels_requirements']	= 'requirements';
$lang['labels_restricted']		= 'restricted';
$lang['labels_restrictions']	= 'restrictions';
$lang['labels_result']			= 'result';
$lang['labels_results']			= 'results';
$lang['labels_role']			= 'role';
$lang['labels_roles']			= 'roles';
$lang['labels_rules']			= 'rules';
$lang['labels_sample_post'] 	= 'sample post';
$lang['labels_section']			= 'section';
$lang['labels_sections']		= 'sections';
$lang['labels_security']		= 'security';
$lang['labels_senior'] 			= 'senior';
$lang['labels_set'] 			= 'set';
$lang['labels_sets'] 			= 'sets';
$lang['labels_setting']			= 'setting';
$lang['labels_settings']		= 'settings';
$lang['labels_shortname'] 		= 'short name';
$lang['labels_single']			= 'single';
$lang['labels_site']			= 'site';
$lang['labels_skin']			= 'skin';
$lang['labels_skins']			= 'skins';
$lang['labels_slots'] 			= 'slots';
$lang['labels_sorting']			= 'sorting';
$lang['labels_standard']		= 'standard';
$lang['labels_stats'] 			= 'stats';
$lang['labels_status'] 			= 'status';
$lang['labels_step'] 			= 'step';
$lang['labels_sub'] 			= 'sub';
$lang['labels_subject'] 		= 'subject';
$lang['labels_suffix'] 			= 'suffix';
$lang['labels_summary'] 		= 'summary';
$lang['labels_system']			= 'system';
$lang['labels_tab']				= 'tab';
$lang['labels_tabs']			= 'tabs';
$lang['labels_tags']			= 'tags';
$lang['labels_text']			= 'text';
$lang['labels_than']			= 'than';
$lang['labels_thank_you'] 		= 'thank you';
$lang['labels_the'] 			= 'the';
$lang['labels_these']			= 'these';
$lang['labels_this']			= 'this';
$lang['labels_timeline']		= 'timeline';
$lang['labels_times']			= 'times';
$lang['labels_timezone']		= 'timezone';
$lang['labels_title'] 			= 'title';
$lang['labels_titles'] 			= 'titles';
$lang['labels_to'] 				= 'to';
$lang['labels_top'] 			= 'top';
$lang['labels_total'] 			= 'total';
$lang['labels_totals'] 			= 'totals';
$lang['labels_type'] 			= 'type';
$lang['labels_types'] 			= 'types';
$lang['labels_uncategorized']	= 'uncategorized';
$lang['labels_unlinked']		= 'unlinked';
$lang['labels_update']			= 'update';
$lang['labels_updates']			= 'updates';
$lang['labels_uploads']			= 'uploads';
$lang['labels_unassigned']		= 'unassigned';
$lang['labels_us']				= 'us';
$lang['labels_user']			= 'user';
$lang['labels_users']			= 'users';
$lang['labels_value']			= 'value';
$lang['labels_values']			= 'values';
$lang['labels_version']			= 'version';
$lang['labels_writing']			= 'writing';
$lang['labels_yes']				= 'yes';
$lang['labels_you']				= 'you';
$lang['labels_your'] 			= 'your';

/*
|---------------------------------------------------------------
| LOGIN
|---------------------------------------------------------------
*/

$lang['login_proceed'] = 'You must provide your email address and password to proceed!';
$lang['login_error_incorrect'] = 'Either your username and/or password are incorrect. Please try again.';
$lang['login_instructions'] = 'Login with your email address and password below. If you have forgotten your password, you can reset your password using the link below and a new password will be emailed to you.';
$lang['login_redirect'] = 'Login successful. Redirecting to Control Panel in <span id="countdown"></span>&nbsp;seconds...';
$lang['logout_message'] = 'You have successfully logged out. You can %s or proceed to the %s. You will be redirected in <span id="countdown"></span>&nbsp;seconds.';
$lang['login_questions_selectone'] = 'Please select your security question';
$lang['login_reset_message'] = "Please provide your email address, security question, and answer to reset your password. Once you have reset your password, your new one will be emailed to you and you will be prompted to change it the next time you log in.";
$lang['login_message'] = 'Login successful. Redirecting to %s in <span id="countdown"></span>&nbsp;seconds...';
$lang['login_forgot'] = 'Forgot your password?';

/*
|---------------------------------------------------------------
| FLASH MESSAGE CONTENT
|---------------------------------------------------------------
*/

$lang['flash_success'] = "%s was successfully %s.%s";
$lang['flash_failure'] = "%s was not successfully %s. Please try again.%s";
$lang['flash_success_plural'] = "%s were successfully %s.%s";
$lang['flash_failure_plural'] = "%s were not successfully %s. Please try again.%s";

$lang['flash_empty_fields'] = "You must complete %s in order to %s a %s. Please try again.";
$lang['flash_duplicate_key'] = "Your %s key is a duplicate of an existing key. Please create a unique key and try again.";

$lang['flash_reset_error_1'] = 'Email address not found, please try again.';
$lang['flash_reset_error_2'] = 'The security question you selected does not match the security question we have on file for you, please try again.';
$lang['flash_reset_error_3'] = 'The answer you provided is wrong. Your answer must be identical to the answer you provided originally. Please try again.';
$lang['flash_reset_error_4'] = 'We have found more than one account with your email address. Please contact the game master to resolve this issue before continuing.';
$lang['flash_reset_success'] = 'Your password has been successfully reset. You will receive an email shortly with your new password and you will be prompted to reset your password next time you log in.';
$lang['flash_reset_fail'] = 'Password reset failed! Please try again. If the problem persists, please contact the game master';
$lang['flash_reset_no_question'] = 'You must select a security question and provide an answer to reset your password. If you have not done so yet, please contact the game master to assist you.';

$lang['flash_system_email_off'] = 'System email has been disabled. You will be able to submit this form, but its data will not be emailed to the appropriate parties!';
$lang['flash_system_email_off_disabled'] = 'System email has been disabled and you cannot submit this form.';
$lang['flash_contact_recipient'] = 'You must specify a recipient for this email!';
$lang['flash_add_comment_empty_body'] = 'You cannot submit an empty comment! Please try again.';
$lang['flash_error_skin_sections'] = 'You cannot delete a skin until all sections have first been removed! Please delete all skin sections from the skin then try again.';

$lang['flash_additional_bio_tab'] = ' You can now add bio sections to this tab.';
$lang['flash_additional_bio_section'] = ' You can now add bio fields to this section.';
$lang['flash_additional_specs_section'] = ' You can now add specification fields to this section.';
$lang['flash_additional_docking_section'] = ' You can now add docking fields to this section.';
$lang['flash_additional_use_contact'] = ' If the problem persists, please use the contact form to contact the game master.';
$lang['flash_additional_contact_gm'] = ' If the error persists, please contact the game master.';
$lang['flash_additional_thank_you'] = ' Thank you!';
$lang['flash_additional_char_quota'] = "You have reached the allowed quota for %s %s on your account.";
$lang['flash_additional_refresh'] = ' In order to see your changes, please navigate to another page.';

$lang['flash_settings_delete_nonuser'] = 'You cannot delete a system setting that is not user-created. Please try again.';
$lang['flash_settings_edit_nonuser'] = 'You cannot updated a system setting that is not user-created. Please try again.';
$lang['flash_privmsgs_no_recipient'] = 'You must specify at least one recipient for your private message. Please try again.';
$lang['flash_personallogs_no_author'] = 'You must specify a character as the author of your personal log. Please try again.';
$lang['flash_missionposts_no_author'] = 'You must specify a character as the author of your mission post. Please try again.';

$lang['flash_fields_all'] = 'all fields';
$lang['flash_fields_role_pages'] = 'the name and URL fields';
$lang['flash_fields_role_groups'] = 'the name field';
$lang['flash_fields_menus'] = 'the name, link, type and category fields';
$lang['flash_fields_menucats'] = 'the name and category fields';
$lang['flash_fields_join'] = 'the character name, position, password and email fields';
