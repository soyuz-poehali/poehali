<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/insert.php'); break;
	case 'save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/save.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/settings_update.php'); break;
	case 'help': include($_SERVER['DOCUMENT_ROOT'].'/blocks/text/edit/help/help.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>