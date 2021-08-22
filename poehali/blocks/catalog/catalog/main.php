<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/classes/BlockCatalog.php';
$CATALOG = new BlockCatalog;

$catalog = $CATALOG->getCatalog($data['content']['catalog_id']);

if ($catalog) {
	// Подключаем вывод содержимого каталога
	if ($SITE->url_arr[1] == '') {
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/catalog/main.php';
	} else if ($SITE->url_arr[1] == 'basket') {
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/basket/main.php';
	} else if ($SITE->url_arr[2] == '') {
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/section/main.php';
	} else if ($SITE->url_arr[3] == '') {
		include_once $_SERVER['DOCUMENT_ROOT'].'/blocks/catalog/catalog/item/main.php';
	}
}

?>