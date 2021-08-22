<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/insert.php'); break;
	case 'settings_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/settings_update.php'); break;
	case 'icon_edit': case 'icon_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/icon_edit.php'); break;
	case 'icon_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/icon_delete.php'); break;
	case 'icon_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/icon_ordering.php'); break;
	case 'icon_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/icon/edit/icon_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>