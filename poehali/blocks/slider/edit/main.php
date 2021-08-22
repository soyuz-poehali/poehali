<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/insert.php'); break;
	case 'save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/save.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/settings_update.php'); break;
	case 'slides': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/slides.php'); break;
	case 'slide_add': case 'slide_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/slide_edit.php'); break;
	case 'slide_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/slide_delete.php'); break;
	case 'slides_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/slides_ordering.php'); break;
	case 'slide_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/slider/edit/slide_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>