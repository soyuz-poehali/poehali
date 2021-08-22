<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	//case 'copy': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/copy.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/insert.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/settings.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/settings_update.php'); break;
	case 'text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/text_update.php'); break;
	case 'field_add': case 'field_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/field_edit.php'); break;
	case 'field_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/field_delete.php'); break;
	case 'fields_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/fields_ordering.php'); break;
	case 'field_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/form/edit/field_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>