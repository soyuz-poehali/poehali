<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/insert.php'); break;
	case 'save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/save.php'); break;
	case 'settings_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/settings_update.php'); break;
	case 'photo_add': case 'photo_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/photo_edit.php'); break;
	case 'photo_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/photo_delete.php'); break;
	case 'photo_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/photo_ordering.php'); break;
	case 'photo_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/photogallery/edit/photo_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>