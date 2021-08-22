<?php
defined('AUTH') or die('Restricted access');

$arr = array('users');
if (in_array($SITE->url_arr[2], $arr)) {
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/crm/'.$SITE->url_arr[2].'/main.php';
} else {
	include $_SERVER['DOCUMENT_ROOT'].'/administrator/crm/mainpage.php';	
}

?>