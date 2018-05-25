<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 2.4.10 to 2.5.0
 */
$system_info	= null;
$add_tables		= null;
$drop_tables	= null;
$rename_tables	= null;
$add_column		= null;
$modify_column	= null;
$drop_column	= null;

/**
 * Version info for the database
 */
$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 2,
	'sys_version_minor'		=> 5,
	'sys_version_update'	=> 0,
);

/*
|---------------------------------------------------------------
| TABLES TO ADD
|
| $add_tables = array(
|	'table_name' => array(
|		'id' => 'table_id',
|		'fields' => 'fields_table_name')
| );
|
| $fields_table_name = array(
|	'table_id' => array(
|		'type' => 'INT',
|		'constraint' => 6,
|		'auto_increment' => TRUE),
|	'table_field_1' => array(
|		'type' => 'VARCHAR',
|		'constraint' => 255,
|		'default' => ''),
|	'table_field_2' => array(
|		'type' => 'INT',
|		'constraint' => 4,
|		'default' => '99')
| );
|---------------------------------------------------------------
*/

if ($add_tables !== null)
{
	foreach ($add_tables as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], true);
		$this->dbforge->create_table($key, true);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null)
{
	foreach ($drop_tables as $value)
	{
		$this->dbforge->drop_table($value);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

if ($rename_tables !== null)
{
	foreach ($rename_tables as $key => $value)
	{
		$this->dbforge->rename_table($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO ADD
|
| $add_column = array(
|	'table_name' => array(
|		'field_name_1' => array('type' => 'TEXT'),
|		'field_name_2' => array(
|			'type' => 'VARCHAR',
|			'constraint' => 100)
|	)
| );
|---------------------------------------------------------------
*/

if ($add_column !== null)
{
	foreach ($add_column as $key => $value)
	{
		$this->dbforge->add_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO MODIFY
|
| $modify_column = array(
|	'table_name' => array(
|		'old_field_name' => array(
|			'name' => 'new_field_name',
|			'type' => 'TEXT')
|	)
| );
|---------------------------------------------------------------
*/

if ($modify_column !== null)
{
	foreach ($modify_column as $key => $value)
	{
		$this->dbforge->modify_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO DROP
|
| $drop_column = array(
|	'table_name' => array('field_name')
| );
|---------------------------------------------------------------
*/

if ($drop_column !== null)
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}

/**
 * Add the new settings fields
 */
$this->db->insert('settings', array(
	'setting_key' => 'hosting_company',
	'setting_value' => '',
	'setting_user_created' => 'n'
));

$this->db->insert('settings', array(
	'setting_key' => 'access_log_purge',
	'setting_value' => '24 hours',
	'setting_user_created' => 'n'
));

/**
 * Add the new messages
 */
$this->db->insert('messages', array(
	'message_key' => 'policy-privacy',
	'message_label' => 'Privacy Policy',
	'message_content' => "The #sim_name# (\"Service\" or \"We\") collects and uses personal information solely for the purpose of providing an online collaborative writing environment. Where feasible, We collect personal information only with the knowledge and consent of the individual concerned (\"Individual\"), and, if the Individual notifies us that they wish to revoke their consent, We will make a best effort to remove all personal information related to the Individual from our Service.

This Privacy Policy, along with our Cookie Policy, Do Not Track Policy, and Your California Privacy Rights page, define in full how the Service collects, manages and processes an Individual's personal information.

WHAT INFORMATION IS COLLECTED?

\"Required Member Information\": When an Individual signs up for the Service (becoming a \"Member\"), We collect the Member's name, age, email address, language and timezone.

\"Optional Member Information\": We allow a Member, at their discretion, to provide additional contact information, a geographic location, interests and a biography.

\"Access Logs\": When an Individual visits the Service, We collect incidental personal information in the Service's logs including the Individual's IP address and user agent.

HOW IS INFORMATION COLLECTED?

Required Member Information and Optional Member Information are collected with an Individual's consent when the Individual signs up for the Service or edits their account within the Service. In order to participate in the Service, a Member must provide all Required Member Information. A Member may provide a pseudonym instead of their real name, if they do not wish to disclose their real name.

Access Logs are collected by our web server and web application when an Individual uses the Service.

WHY IS INFORMATION COLLECTED?

Required Member Information is collected in order to allow a Member to participate in the Service. A Member's name, email address and timezone are listed on their profile. A Member's email address will also be used to contact the Member and to send the Member story posts and other content directly related to the Service. A Member's age is only used to confirm the Member meets the legal requirements to participate in this Service.

Optional Member Information is collected in order to allow a Member to share more details about themselves to other Members of the service.

Access Logs are collected for diagnosing technical problems with our Service. In rare situations, We may also use Access Logs to ban an Individual found to be acting inappropriately with the Service, including, but not limited to, violating the rules of the Service, placing an undue burden on the Service or violating applicable laws (\"Inappropriate Use\").

WITH WHOM IS INFORMATION SHARED?

A Member's name, email address, timezone and Optional Member Information are shared with other Members of the Service through the Member's user profile.

A Member's name, age, email address, timezone and Optional Member Information may also be shared with any applicable parent organization to which the Service belongs.

Access Logs are generally not shared, although they may in rare circumstances be shared with any applicable parent organization to which the Service belongs or the #hosting_company# (\"Host\") to diagnose technical problems or when an Individual is reasonably believed to have committed Inappropriate Use of the Service.

The Service or the Host may share personal information with relevant law enforcement authorities as required to comply with applicable laws. The Service will notify the Individual, if permitted by applicable laws, when this occurs.

The Service will not share any personal information with any other parties without the Individual's consent.

HOW IS INFORMATION PROTECTED?

We protect all personal information using reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification. We are committed to managing the Service in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.

Upon request from an Individual, we will make readily available information about our practices and policies relating to the management of personal data.

HOW LONG IS INFORMATION RETAINED?

Required Member Information and Optional Member Information is retained as long as the Individual remains a Member of the Service.

Access Logs are retained for #access_log_purge#.

HOW CAN INFORMATION BE REMOVED?

An Member may submit a request to <strong>#admin_email#</strong> to have their account deleted and all Required Member Information and Optional Member Information removed from the Service. This will cause them to no longer be a Member.

The Service cannot ensure that other Members do not personally retain Required Member Information or Optional Member Information shared to these other Members through the Service as described in this Policy.

The Service routinely deletes all Access Logs, so an Individual does not need to request its removal explicitly.",
	'message_type' => 'message'
));

$this->db->insert('messages', array(
	'message_key' => 'policy-cookie',
	'message_label' => 'Cookie Policy',
	'message_content' => "The #sim_name# (\"Service\" or \"We\") uses cookies solely for the purpose of providing an online collaborative writing environment.

Cookies are small pieces of text sent back and forth between your web browser and a website you visit. A cookie file is stored in your web browser and allows the Service to recognize you and make your next visit easier and the Service more useful to you. Cookies can be \"persistent\" or \"session\" cookies.

When an Individual accesses or uses the Service, the Service may place a number of cookies in the Individual's web browser. We use both session and persistent cookies. Specifically, We use cookies to authenticate Individuals and prevent fraudulent use of accounts, and We use cookies to remember an Individual's email address when prompting the Individual to log in again.",
	'message_type' => 'message'
));

$this->db->insert('messages', array(
	'message_key' => 'policy-do-not-track',
	'message_label' => 'Do Not Track Policy',
	'message_content' => "The #sim_name# (\"Service\" or \"We\") does not track Individuals over time to provide targeted advertising and therefore does not respond to Do Not Track (\"DNT\") signals.",
	'message_type' => 'message'
));

$this->db->insert('messages', array(
	'message_key' => 'policy-california',
	'message_label' => 'California Privacy Rights Policy',
	'message_content' => "If you are a California resident, California Civil Code Section 1798.83 permits you to request information regarding the disclosure of your personal information by #sim_name# to third parties for the third parties' direct marketing purposes. To make such a request, please email <strong>#admin_email#</strong>.",
	'message_type' => 'message'
));
