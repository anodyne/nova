<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Active template
|--------------------------------------------------------------------------
|
| The $template['active_template'] setting lets you choose which template 
| group to make active.  By default there is only one group (the 
| "default" group).
|
*/
$template['active_template'] = 'main';

/*
|--------------------------------------------------------------------------
| Explaination of template group variables
|--------------------------------------------------------------------------
|
| ['template'] The filename of your master template file in the Views folder.
|   Typically this file will contain a full XHTML skeleton that outputs your
|   full template or region per region. Include the file extension if other
|   than ".php"
| ['regions'] Places within the template where your content may land. 
|   You may also include default markup, wrappers and attributes here 
|   (though not recommended). Region keys must be translatable into variables 
|   (no spaces or dashes, etc)
| ['parser'] The parser class/library to use for the parse_view() method
|   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
|   Smarty Parser that works perfectly with Template
| ['parse_template'] FALSE (default) to treat master template as a View. TRUE
|   to user parser (see above) on the master template
|
| Region information can be extended by setting the following variables:
| ['content'] Must be an array! Use to set default region content
| ['name'] A string to identify the region beyond what it is defined by its key.
| ['wrapper'] An HTML element to wrap the region contents in. (We 
|   recommend doing this in your template file.)
| ['attributes'] Multidimensional array defining HTML attributes of the 
|   wrapper. (We recommend doing this in your template file.)
|
| Example:
| $template['default']['regions'] = array(
|    'header' => array(
|       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
|       'name' => 'Page Header',
|       'wrapper' => '<div>',
|       'attributes' => array('id' => 'header', 'class' => 'clearfix')
|    )
| );
|
*/

/*
|---------------------------------------------------------------
| THEMES TEMPLATES
|---------------------------------------------------------------
*/

/* main template */
$template['main']['template'] = 'template';
$template['main']['regions'] = array(
	'title',
	'flash_message',
	'content',
	'nav_main',
	'nav_sub',
	'javascript',
	'ajax',
	'panel_1',
	'panel_2',
	'panel_3',
	'panel_workflow'
);
$template['main']['parser'] = 'parser';
$template['main']['parser_method'] = 'parse';
$template['main']['parse_template'] = FALSE;

/* admin template */
$template['admin']['template'] = 'template';
$template['admin']['regions'] = array(
	'title',
	'flash_message',
	'content',
	'nav_main',
	'nav_sub',
	'javascript',
	'ajax',
	'panel_1',
	'panel_2',
	'panel_3',
	'panel_workflow'
);
$template['admin']['parser'] = 'parser';
$template['admin']['parser_method'] = 'parse';
$template['admin']['parse_template'] = FALSE;

/* wiki template */
$template['wiki']['template'] = 'template';
$template['wiki']['regions'] = array(
	'title',
	'content',
	'nav_main',
	'nav_sub',
	'javascript'
);
$template['wiki']['parser'] = 'parser';
$template['wiki']['parser_method'] = 'parse';
$template['wiki']['parse_template'] = FALSE;

/* login template */
$template['login']['template'] = 'template';
$template['login']['regions'] = array(
	'title',
	'content',
	'javascript',
	'flash_message'
);
$template['login']['parser'] = 'parser';
$template['login']['parser_method'] = 'parse';
$template['login']['parse_template'] = FALSE;

/*
|---------------------------------------------------------------
| GLOBAL TEMPLATES
|---------------------------------------------------------------
*/

/* install template */
$template['install']['template'] = '_base/template_install';
$template['install']['regions'] = array(
	'title',
	'content',
	'label',
	'javascript',
	'flash_message',
	'controls',
	'install_options'
);
$template['install']['parser'] = 'parser';
$template['install']['parser_method'] = 'parse';
$template['install']['parse_template'] = FALSE;

/* update template */
$template['update']['template'] = '_base/template_update';
$template['update']['regions'] = array(
	'title',
	'content',
	'label',
	'javascript',
	'flash_message',
	'controls',
	'update_options'
);
$template['update']['parser'] = 'parser';
$template['update']['parser_method'] = 'parse';
$template['update']['parse_template'] = FALSE;

/* RSS template */
$template['rss']['template'] = '_base/template_rss';
$template['rss']['regions'] = array(
	'header',
	'items',
);
$template['rss']['parser'] = 'parser';
$template['rss']['parser_method'] = 'parse';
$template['rss']['parse_template'] = FALSE;

/* ajax template */
$template['ajax']['template'] = '_base/template_ajax';
$template['ajax']['regions'] = array('content');
$template['ajax']['parser'] = 'parser';
$template['ajax']['parser_method'] = 'parse';
$template['ajax']['parse_template'] = FALSE;

/* End of file template.php */
/* Location: ./application/config/template.php */