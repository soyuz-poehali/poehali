<?php
defined('AUTH') or die('Restricted access');

$com_arr = array('catalogs', 'poehali');

if (in_array($SITE->url_arr[2], $com_arr)) {
	include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/'.$SITE->url_arr[2].'/main.php';	
} else {
	switch ($SITE->url_arr[2]) {
		case 'help':
			include_once $_SERVER['DOCUMENT_ROOT'].'/administrator/components/help.php';
			break;
		
		default:
			header("HTTP/1.0 404 Not Found");
			include "404.php";
			exit;
	}
}
?>