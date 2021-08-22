<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/cpanel.php'); break;	
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/insert.php'); break;
	case 'save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/save.php'); break;
	case 'settings_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/mapsyandex/edit/settings_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>