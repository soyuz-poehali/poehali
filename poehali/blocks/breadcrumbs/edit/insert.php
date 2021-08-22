<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'breadcrumbs';
$data['status'] = '1';

// Проверка размещения блока на странице
if ($BLOCK_E->getBlockCount($data) > 0) {
	echo json_encode(array('answer' => 'message', 'text' => 'Блок уже размещён ранее.<br>Допустимо размещение только одного блока на странице'));
	exit;
}

// Начальная инициализация массива, ниже переопределяется в файле insert.php
$data['content'] = array(
	'style' => 1,
	'bg_type' => 'c',
	'bg_color' => '#ffffff',
	'bg_image' => '',
	'bg_image_size' => 'cover',
	'color' => '#444444',
	'font_size' => '16',
	'max_width' => '1440',
	'margin' => '20',
);

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>