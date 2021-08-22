<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[2]) {
	case 'upgrade':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/upgrade.php';
		break;

	default:
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/upgrade/start.php';
		break;
}

?>