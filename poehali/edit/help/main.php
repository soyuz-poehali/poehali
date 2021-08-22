<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'mainpage':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/help/mainpage.php';
		break;

	case 'authors':
		include $_SERVER['DOCUMENT_ROOT'].'/edit/help/authors.php';
		break;
		
	default:
		header ('HTTP/1.0 404 Not Found');
		include '404.php';
		exit;
}

exit;