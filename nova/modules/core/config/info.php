<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

define('APP_NAME', 'Nova');

define('APP_VERSION', '2.7.9');
define('APP_VERSION_MAJOR', 2);
define('APP_VERSION_MINOR', 7);
define('APP_VERSION_UPDATE', 9);

define('WIKI_NAME', 'Thresher');
define('WIKI_VERSION', 'Release 2');

define('SMS_UPGRADE_VERSION', '2.6.9');

define('LATEST_VERSION_URL', 'https://anodyne-productions.com/api/nova/latest-version');

define('REGISTER_URL', 'https://anodyne-productions.com/api/games');

// figure out whether to install the bare essentials or the dev stuff
define('APP_DATA_SRC', 'basic');
define('APP_DATA_DEV', false);

// figure out if the request is an ajax request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

// CI_VERSION is available as a constant and is defined in ./nova/codeigniter/codeigniter/CodeIgniter.php
