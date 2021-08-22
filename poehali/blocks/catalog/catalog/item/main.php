<?php
defined('AUTH') or die('Restricted access');

switch($catalog['settings']['item_product_card']) {
	case '1':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/item/1/content.php';
		break;
	case '999':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/item/999/content.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}

?>