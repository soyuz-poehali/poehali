<?php
defined('AUTH') or die('Restricted access');

switch($SITE->url_arr[2]) {
	case 'add':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/add.php';
		break;

	case 'list':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/list.php';
		break;

	case 'delete':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/delete_ajax.php';
		break;

	case 'form':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/form.php';
		break;

	case 'send':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/send.php';
		break;

	case 'add_item_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/add_item_ajax.php';
		break;

	case 'get_coupon_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/get_coupon_ajax.php';
		break;

	case 'get_list_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/get_list_ajax.php';
		break;

	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}

?>