<?php
defined('AUTH') or die('Restricted access');

switch($catalog['settings']['section_product_card']) {
	case '1':
		$SITE->setHeadFile('/blocks/catalog/catalog/section/1/style.css');
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/section/1/content.php';
		break;
	case '999':
		$SITE->setHeadFile('/blocks/catalog/catalog/section/999/style.css');
		include $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/section/999/content.php';
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		include "404.php";
		exit;
}

?>