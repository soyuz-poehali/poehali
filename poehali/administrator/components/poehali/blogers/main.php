<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[4]) {
	case '':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/mainpage.php';
		break;
	case 'add':
	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/edit.php';
		break;
	case 'insert':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/insert.php';
		break;
	case 'update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/update.php';
		break;
	case 'delete':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/delete.php';
		break;
	case 'up':
	case 'down':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/ordering.php';
		break;
	case 'pub':
	case 'unpub':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/status.php';
		break;
	case 'blogers_list_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/blogers_list_ajax.php';
		break;
	case 'blogers_delete_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/blogers_delete_ajax.php';
		break;
	case 'blogers_insert_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/blogers_insert_ajax.php';
		break;
	case 'blogers_ordering_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/blogers/blogers_ordering_ajax.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}
				
?>