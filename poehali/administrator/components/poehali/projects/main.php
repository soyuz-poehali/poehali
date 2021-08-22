<?php
defined('AUTH') or die('Restricted access');

switch ($SITE->url_arr[4]) {
	case '':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/mainpage.php';
		break;
	case 'add':
	case 'edit':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/edit.php';
		break;
	case 'insert':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/insert.php';
		break;
	case 'update':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/update.php';
		break;
	case 'delete':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/delete.php';
		break;
	case 'up':
	case 'down':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/ordering.php';
		break;
	case 'inactive':
	case 'active':
	case 'completed':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/status.php';
		break;
	case 'blogers_list_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/blogers_list_ajax.php';
		break;
	case 'bloger_insert_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/bloger_insert_ajax.php';
		break;
	case 'bloger_delete_ajax':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/bloger_delete_ajax.php';
		break;		
	case 'map':
		include $_SERVER['DOCUMENT_ROOT'].'/administrator/components/poehali/projects/map.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}
				
?>