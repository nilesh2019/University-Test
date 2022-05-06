<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group = 'default';
$active_record = TRUE;
$localhost = array('127.0.0.1','::1');
if(in_array($_SERVER['REMOTE_ADDR'], $localhost))
{
	$db['default']['hostname'] = 'localhost';
	$db['default']['username'] = 'root';
	$db['default']['password'] =  '';

	$db['maac_db']['hostname'] = 'localhost';
	$db['maac_db']['username'] = 'root';
	$db['maac_db']['password'] = '';

	$db['default']['database'] = 'creosouls_arena_db';
	$db['maac_db']['database'] = 'creosouls_maac_db';
}
else
{
	$db['default']['hostname'] = 'node93503-demouniversity.cloudjiffy.net';
	$db['default']['username'] = 'root';
	$db['default']['password'] = 'XBDxdd91574';

	$db['maac_db']['hostname'] = 'node93503-demouniversity.cloudjiffy.net';
	$db['maac_db']['username'] = 'root';
	$db['maac_db']['password'] = 'XBDxdd91574';

	$db['lakme_db']['hostname'] = 'node93503-demouniversity.cloudjiffy.net';
	$db['lakme_db']['username'] = 'root';
	$db['lakme_db']['password'] = 'XBDxdd91574';


	/* test */
	$db['default']['database'] = 'creonow';
	$db['maac_db']['database'] = 'maac_db';
	$db['lakme_db']['database'] = 'lakme_db';


	/* live */
	/*$db['default']['database'] = 'creonow_db';
	$db['maac_db']['database'] = 'maac_db';*/
}

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] =(ENVIRONMENT !== 'production');
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
//$db['default']['dbcollat'] = 'utf8_general_ci';
//$db['default']['char_set'] = 'utf8mb4';
$db['default']['dbcollat'] = 'utf8mb4_unicode_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//Another database configuration
$db['maac_db']['dbdriver'] = 'mysqli';
$db['maac_db']['dbprefix'] = '';
$db['maac_db']['pconnect'] = FALSE;
$db['maac_db']['db_debug'] = TRUE;
$db['maac_db']['cache_on'] = FALSE;
$db['maac_db']['cachedir'] = '';
$db['maac_db']['char_set'] = 'utf8';

$db['maac_db']['dbcollat'] = 'utf8_general_ci';
$db['maac_db']['swap_pre'] = '';
$db['maac_db']['autoinit'] = TRUE;
$db['maac_db']['stricton'] = FALSE;


//Lakme database configuration
$db['lakme_db']['dbdriver'] = 'mysqli';
$db['lakme_db']['dbprefix'] = '';
$db['lakme_db']['pconnect'] = FALSE;
$db['lakme_db']['db_debug'] = TRUE;
$db['lakme_db']['cache_on'] = FALSE;
$db['lakme_db']['cachedir'] = '';
$db['lakme_db']['char_set'] = 'utf8';
$db['lakme_db']['dbcollat'] = 'utf8_general_ci';
$db['lakme_db']['swap_pre'] = '';
$db['lakme_db']['autoinit'] = TRUE;
$db['lakme_db']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */







