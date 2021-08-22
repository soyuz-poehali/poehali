<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/delete.php'); break;
	case 'edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/edit.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/insert.php'); break;
	case 'update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/update.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/code/edit/settings_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>