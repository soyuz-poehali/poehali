<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[3]) {
	case 'areas': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/areas.php'); break;
	case 'area_logo': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_logo.php'); break;
	case 'area_logo_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_logo_update.php'); break;
	case 'area_logo_text': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_logo_text.php'); break;
	case 'area_logo_text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_logo_text_update.php'); break;
	case 'area_phone': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_phone.php'); break;
	case 'area_phone_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_phone_update.php'); break;
	case 'area_sn': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_sn.php'); break;
	case 'area_sn_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_sn_update.php'); break;
	case 'area_right_text': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_right_text.php'); break;
	case 'area_right_text_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_right_text_update.php'); break;
	case 'area_basket': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_basket.php'); break;
	case 'area_basket_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/area_basket_update.php'); break;
	case 'cpanel': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/cpanel.php'); break;
	case 'delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/delete.php'); break;
	case 'insert': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/insert.php'); break;
	case 'settings_edit': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/settings_edit.php'); break;
	case 'settings_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/settings_update.php'); break;
	case 'menu_edit': case 'menu_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/menu_edit.php'); break;
	case 'menu_delete': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/menu_delete.php'); break;
	case 'menu_ordering': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/menu_ordering.php'); break;
	case 'menu_list': case 'menu_add': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/menu_list.php'); break;
	case 'menu_update': include($_SERVER['DOCUMENT_ROOT'].'/blocks/menu/edit/menu_update.php'); break;
	default: include($_SERVER['DOCUMENT_ROOT'].'/404.php'); exit;			
}

exit;
?>