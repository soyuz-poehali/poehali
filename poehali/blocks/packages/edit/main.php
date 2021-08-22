<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'button_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/button_edit.php'); break;
	case 'button_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/button_update.php'); break;
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/insert.php'); break;
	case 'image_select': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/image_select.php'); break;
	case 'image_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/image_update.php'); break;
	case 'link_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/link_edit.php'); break;
	case 'link_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/link_update.php'); break;
	case 'package_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/package_add.php'); break;
	case 'package_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/package_delete.php'); break;
	case 'packages_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/packages_ordering.php'); break;	
	case 'package_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/package_update.php'); break;
	case 'settings_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/packages/edit/settings_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>