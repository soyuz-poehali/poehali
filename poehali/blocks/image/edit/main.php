<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/insert.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/settings_update.php'); break;
	case 'text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/text_update.php'); break;
	case 'image_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/image/edit/image_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>