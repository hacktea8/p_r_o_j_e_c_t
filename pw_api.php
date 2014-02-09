<?php

//error_reporting(0);
define('P_W','admincp');
define('R_P',strpos(__FILE__, DIRECTORY_SEPARATOR) !== FALSE ? substr(__FILE__, 0, strrpos(__FILE__,DIRECTORY_SEPARATOR)).'/' : './');
define('D_P',R_P);
function_exists('date_default_timezone_set') && date_default_timezone_set('Etc/GMT+0');

define('BASEPATH', dirname(__FILE__).'/system/');
require_once(R_P.'application/helpers/uclogin_helper.php');
$GLOBALS['db_siteownerid'] = $GLOBALS['db_siteappkey'] = $uc_key = getKeyBydomain();

require_once(R_P.'api/class_base.php');
$api = new api_client();
$response = $api->run($_POST + $_GET);

if ($response) {
	echo $api->dataFormat($response);
}


?>
