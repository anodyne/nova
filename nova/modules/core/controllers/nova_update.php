<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Update controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_update extends CI_Controller
{
    /**
     * @var	bool	Is the system installed?
     */
    public $installed = false;

    /**
     * @var	string	The version of the system
     */
    public $version;

    /**
     * @var	array 	The options array that stores all the settings from the database
     */
    public $options;

    /**
     * @var	array 	Variable to store all the information about template regions
     */
    protected $_regions = [];

    public function __construct()
    {
        parent::__construct();

        // load the nova core module
        $this->load->module('core', 'nova', MODPATH);

        if (! file_exists(APPPATH.'config/database.php')) {
            redirect('install/setupconfig');
        }

        $this->load->database();
        $this->load->library('session');
        $this->load->model('settings_model', 'settings');
        $this->load->model('system_model', 'sys');
        $this->nova->lang('install');
        $this->lang->load('app', $this->session->userdata('language'));

        $this->sys->prepare_database_session();

        // set the version
        $this->version = APP_VERSION_MAJOR.'.'.APP_VERSION_MINOR.'.'.APP_VERSION_UPDATE;

        // an array of items to pull from the settings table
        $settingsArr = [
            'sim_name',
            'date_format',
            'updates',
            'maintenance'
        ];

        // grab the settings
        $this->options = $this->settings->get_settings($settingsArr);

        // check if nova is installed
        $this->installed = $this->sys->check_install_status();

        // set the template file
        Template::$file = '_base/template_update';

        // set the module
        Template::$data['module'] = 'core';

        // assign all of the items to the template with false values to prevent errors
        $this->_regions = [
            'label' => false,
            'content' => false,
            'controls' => false,
            'javascript' => false,
            'flash_message' => false,
            '_redirect' => false,
            'title' => APP_NAME.' Setup Center :: ',
            'lowerWarning' => false,
            'lowerDanger' => false,
        ];

        Auth::is_logged_in(true);

        $systemAdmin = Auth::is_sysadmin($this->session->userdata('userid'));

        if (! $systemAdmin) {
            show_error('You are not a system administrator and cannot update Nova.', 500, 'Access denied');
        }
    }

    public function index()
    {
        $this->_regions['content'] = Location::view('update_index', '_base', 'update', []);

        if ($this->options['maintenance'] == 'off') {
            $this->_regions['lowerWarning'] = 'Maintenance mode is currently turned off. Before beginning to update Nova to a newer version, we recommend turning maintenance mode on from <a href="'.site_url('site/settings').'" class="underline text-warning-800 hover:text-warning-950 font-medium">site settings</a>.';
        }

        $this->_regions['title'].= lang('upd_index_title');
        $this->_regions['label'] = lang('upd_index_title');

        Template::assign($this->_regions);

        Template::render();
    }

    public function check()
    {
        $update = $this->_check_version();

        if (is_null($update['update']['version'])) {
            $this->_regions['lowerWarning'] = sprintf(
                lang('update_text_no_updates'),
                APP_NAME
            );
        }

        $this->_regions['content'] = Location::view('update_check_main', '_base', 'update', [
            'update' => $update['update'],
        ]);
        $this->_regions['javascript'] = Location::js('update_check_js', '_base', 'update');
        $this->_regions['title'].= lang('upd_index_title');
        $this->_regions['label'] = lang('upd_index_title');

        Template::assign($this->_regions);

        Template::render();
    }

    public function run()
    {
        ini_set('max_execution_time', -1);

        $this->load->dbforge();

        $this->load->helper('directory');

        $item = $this->sys->get_item('system_info', 'sys_id', 1);

        $version = $item->sys_version_major.$item->sys_version_minor.$item->sys_version_update;

        $formattedVersion = sprintf('%d.%d.%d', $item->sys_version_major, $item->sys_version_minor, $item->sys_version_update);

        $dir = directory_map(MODFOLDER.'/assets/update');

        if (is_array($dir)) {
            sort($dir);

            foreach ($dir as $key => $value) {
                if ($value == 'index.html' || $value == 'versions.php') {
                    unset($dir[$key]);
                } else {
                    $file = substr($value, 7, -4);

                    if ($file < $version) {
                        unset($dir[$key]);
                    }
                }
            }

            foreach ($dir as $d) {
                include_once(MODPATH.'assets/update/'.$d);

                sleep(1);
            }
        } else {
            include_once(MODPATH.'assets/update/versions.php');

            foreach ($version_array as $k => $v) {
                if ($v < $version) {
                    unset($version_array[$k]);
                }
            }

            foreach ($version_array as $value) {
                include_once(MODPATH.'assets/update/update_' .$value.'.php');

                sleep(1);
            }
        }

        // update the system info table
        $this->sys->update_system_info();

        $this->_register($formattedVersion);

        $data['label'] = [
            'text' => sprintf(lang('upd_step2_success'), APP_VERSION),
            'back' => lang('upd_step2_site')
        ];

        $next = [
            'name' => 'next',
            'type' => 'submit',
            'class' => 'btn-main',
            'id' => 'next',
            'content' => lang('upd_step2_site'),
        ];

        $this->_regions['content'] = Location::view('update_step', '_base', 'update', $data);
        $this->_regions['javascript'] = Location::js('update_step_2_js', '_base', 'update');
        $this->_regions['controls'] = form_open('main/index').form_button($next).form_close();
        $this->_regions['title'].= lang('upd_step2_title');
        $this->_regions['label'] = lang('upd_step2_title');

        Template::assign($this->_regions);

        Template::render();
    }

    public function verify()
    {
        $this->load->helper('utility');

        $verify = verify_server();
        $hasFailures = $verify['verify']['failures'] > 0;
        $hasWarnings = $verify['verify']['warnings'] > 0;

        $this->_regions['content'] = Location::view('update_verify', '_base', 'update', [
            'hasFailures' => $hasFailures,
            'hasWarnings' => $hasWarnings,
            'table' => show_server_verification_table($verify),
        ]);

        if ($hasFailures) {
            $this->_regions['lowerDanger'] = "While checking your server against Nova's requirements, we found that your server cannot run this version of Nova. Please address any failed items with your web host and try again.";
        }

        if (! $hasFailures && $hasWarnings) {
            $this->_regions['lowerWarning'] = "While checking your server against Nova's requirements, we found some potential issues. These won't necessarily be a problem, but you should review before continuing with the update.";
        }

        $this->_regions['title'].= lang('verify_title');
        $this->_regions['label'] = lang('verify_title');

        Template::assign($this->_regions);

        Template::render();
    }

    protected function _check_version()
    {
        $this->load->driver('cache', ['adapter' => 'file']);

        if (! $upstream = $this->cache->get('nova-version-check')) {
            try {
                $http = new \Illuminate\Http\Client\Factory();

                $response = $http->get(LATEST_VERSION_URL);

                // Check if the response was successful (2xx status code)
                if ($response->successful()) {
                    $upstream = $response->json();
                    $this->cache->save('nova-version-check', $upstream, 86_400);
                } else {
                    // If we got a 4xx or 5xx error, return a safe default
                    return $this->_get_default_version_check();
                }
            } catch (\Exception $e) {
                // If any exception occurs (network error, JSON parsing, etc.), return a safe default
                return $this->_get_default_version_check();
            }
        }

        [
            $upstreamVersionMajor,
            $upstreamVersionMinor,
            $upstreamVersionUpdate
        ] = explode('.', $upstream['version']);

        // get the system information
        $system = $this->sys->get_system_info();

        // build the array of version info
        $version = [
            'files' => [
                'full' => APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
                'major' => APP_VERSION_MAJOR,
                'minor' => APP_VERSION_MINOR,
                'update' => APP_VERSION_UPDATE
            ],
            'database' => [
                'full' => $system->sys_version_major .'.'. $system->sys_version_minor .'.'. $system->sys_version_update,
                'major' => (int) $system->sys_version_major,
                'minor' => (int) $system->sys_version_minor,
                'update' => (int) $system->sys_version_update
            ],
        ];

        $update = [
            'version' => null,
            'notes' => null,
            'severity' => null,
            'link' => null,
            'upgrade_guide_link' => null,
        ];

        switch ($this->options['updates']) {
            case 'major':
                if (
                    version_compare($upstreamVersionMajor, $version['files']['major'], '>') ||
                    version_compare($upstreamVersionMajor, $version['database']['major'], '>')
                ) {
                    $update = $upstream;
                }
                break;

            case 'minor':
                if (
                    version_compare($upstreamVersionMinor, $version['files']['minor'], '>') ||
                    version_compare($upstreamVersionMinor, $version['database']['minor'], '>')
                ) {
                    $update = $upstream;
                }
                break;

            case 'update':
                if (
                    version_compare($upstreamVersionUpdate, $version['files']['update'], '>') ||
                    version_compare($upstreamVersionUpdate, $version['database']['update'], '>')
                ) {
                    $update = $upstream;
                }
                break;

            case 'all':
                if (
                    version_compare($upstream['version'], $version['files']['full'], '>') ||
                    version_compare($upstream['version'], $version['database']['full'], '>')
                ) {
                    $update = $upstream;
                }
                break;
        }

        if (version_compare($version['database']['full'], $version['files']['full'], '>')) {
            $flash['header'] = lang('update_required');
            $flash['message'] = sprintf(
                lang('update_outofdate_files'),
                $version['files']['full'],
                $version['database']['full']
            );
            $flash['status'] = 2;
        } elseif (version_compare($version['database']['full'], $version['files']['full'], '<')) {
            $flash['header'] = lang('update_required');
            $flash['message'] = sprintf(
                lang('update_outofdate_database'),
                $version['database']['full'],
                $version['files']['full']
            );
            $flash['status'] = 2;
        } elseif (isset($update)) {
            $flash['header'] = sprintf(
                lang('update_available'),
                APP_NAME,
                $update['version'],
                ''
            );
            $flash['message'] = $update['notes'];
            $flash['status'] = 1;
        } else {
            $flash['header'] = '';
            $flash['message'] = '';
            $flash['status'] = '';
        }

        return [
            'flash' => $flash,
            'update' => $update
        ];
    }

    protected function _get_default_version_check()
    {
        return [
            'flash' => [
                'header' => '',
                'message' => '',
                'status' => ''
            ],
            'update' => [
                'version' => null,
                'notes' => null,
                'severity' => null,
                'link' => null,
                'upgrade_guide_link' => null,
            ]
        ];
    }

    private function _register($previousVersion = null)
    {
        try {
            $http = new \Illuminate\Http\Client\Factory();

            $response = $http->post(REGISTER_URL, Util::fullHeartbeat($previousVersion));

            // Check if the response was successful (2xx status code)
            if ($response->successful()) {
                $gameId = $response->json('game_id');

                if ($gameId !== null) {
                    $this->sys->update_anodyne_game_id($gameId);
                }
            }
            // If registration fails, silently continue - it's not critical to the update
        } catch (\Exception $e) {
            // If any exception occurs (network error, JSON parsing, etc.), silently continue
            // Registration failure should not block the update process
        }
    }
}
