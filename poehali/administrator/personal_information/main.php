<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/personal_information/update.php';
		break;

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/personal_information/edit.php';
		break;
}

?>