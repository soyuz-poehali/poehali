<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/copy.php'); break;
	case 'button_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/button_edit.php'); break;
	case 'button_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/button_update.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/insert.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/settings_update.php'); break;
	case 'text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/text_update.php'); break;
	case 'image_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/image_add.php'); break;
	case 'image_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/image_edit.php'); break;
	case 'image_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/image_delete.php'); break;
	case 'images_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/images_ordering.php'); break;
	case 'image_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/case/edit/image_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>