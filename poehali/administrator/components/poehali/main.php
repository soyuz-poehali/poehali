<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case '':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/mainpage.php';
		break;
	case 'projects':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/main.php';
		break;
	case 'blogers':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/main.php';
		break;
	case 'help':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/help.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}
?>