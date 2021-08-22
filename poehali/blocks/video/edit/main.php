<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/copy.php'); break;
	case 'button_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/button_edit.php'); break;
	case 'button_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/button_update.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/insert.php'); break;
	case 'save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/save.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/settings_update.php'); break;
	case 'text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/text_update.php'); break;
	case 'video_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/video_add.php'); break;
	case 'video_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/video_edit.php'); break;
	case 'video_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/video_delete.php'); break;
	case 'video_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/video_ordering.php'); break;
	case 'video_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/video/edit/video_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>