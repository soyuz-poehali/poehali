<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = intval($_POST['style_id']);
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['type'] = 'buttonup';
$data['status'] = '1';

$data['content']['color'] = '#4CFB33';
$data['content']['size'] = 80;
$data['content']['bottom'] = 50;
$data['content']['left'] = 50;

// Проверка размещения блока на странице
if ($BLOCK_E->getBlockCount($data) > 0) {
	echo json_encode(array('answer' => 'message', 'text' => 'Кнопка уже размещена!'));
	exit;
}

$block_id = $BLOCK_E->insertBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>