<?php
error_reporting (E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_PARSE);
ob_start();
session_start();
class Database{
	protected $db_host = "localhost";  // Change as required
	protected $db_user = "root";  // Change as required
	protected $db_pass = "";  // Change as required
	protected $db_name = "pmtools";	// Change as required
}
// Define global variables
define('SITE_URL','http://localhost/pmtools');
//define('SITE_URL','http://cre8ivelabs.biz/practicia');
define('SITE_URL_ADMIN',SITE_URL.'/ADMIN');

define('DATE',date('Y-m-d h:i:s'));
define('IP',$_SERVER['REMOTE_ADDR']);

include('plugin/mailer/PHPMailerAutoload.php');
include('plugin/mailer/mailer.php');
?>