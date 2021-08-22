<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[3])
{
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/delete.php'); break;
	case 'fields': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/fields.php'); break;
	case 'field_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/field_add.php'); break;
	case 'field_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/field_delete.php'); break;
	case 'field_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/field_edit.php'); break;
	case 'field_mapyandex_save': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/field_mapyandex_save.php'); break;
	case 'fields_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/fields_ordering.php'); break;
	case 'field_update': case 'field_insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/field_update.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/insert.php'); break;
	case 'settings': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/contacts/edit/settings_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>