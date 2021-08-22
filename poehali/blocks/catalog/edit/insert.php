<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/Catalog/Catalog.php';
$BLOCK_E = new BlockEdit;
$CATALOG = new Catalog;

$page_id = intval($_POST['p']);
$template_id = intval($_POST['style_id']);
$ordering = $BLOCK_E->getMaxOrdering($page_id) + 1;

$data = [];
$data['page_id'] = $page_id;
$data['type'] = 'catalog';
$data['ordering'] = $ordering;
$data['status'] = '1';
$data['content'] = [];
$data['content']['max_width'] = '1440';
$data['content']['margin'] = '60';
$data['content']['catalog_id'] = '0';

// Подключаем первый компонент типа каталог, если он существует
$catalogs = $CATALOG->getCatalogs();

if ($catalogs)
	$data['content']['catalog_id'] = $catalogs[0]['id'];

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));

?>