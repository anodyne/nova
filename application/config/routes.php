<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once MODPATH.'core/config/nova_routes.php';

$route['example/(.*)'] = 'modulerouter/example/$1';

$route['awesimreport/(.*)'] = 'modulerouter/awesimreport/$1';
