<?php
defined('AUTH') or die('Restricted access');
switch($catalog['settings']['shop_basket_cart']) {
	case '1':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/1/main.php';
		break;
	case '999':
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/999/main.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}

?>