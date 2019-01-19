<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'main/view';
$route['view/(:any)'] = 'view/$1';
$route['view/(:any)/(:any)'] = 'view/$1/$2';
$route['controller/(:any)'] = 'controller/$1';
$route['controller/(:any)/(:any)'] = 'controller/$1/$2';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
