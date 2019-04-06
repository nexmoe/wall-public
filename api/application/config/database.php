<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$path = str_replace("api\\","",FCPATH);
$path = str_replace("api/","",$path);

$config = include $path."config.php";
$active_group = 'wall';
$query_builder = TRUE;

$db['wall'] = array(
	'dsn'	=> '',
	'hostname' => $config['hostname'],
	'username' => $config['username'],
	'password' => $config['password'],
	'database' => $config['database'],
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
