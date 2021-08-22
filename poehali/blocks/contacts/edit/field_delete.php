<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];

if (count($content['fields']) < 2) {
	echo json_encode(array('answer' => 'error', 'message' => 'Последнее поле нельзя удалить. Контакты не может быть пустые. Не нужны контакты - удалите блок целиком.'));
	exit;	
}

unset($content['fields'][$num - 1]);


// УДАЛЯЕМ ДЫРКИ ИЗ МАССИВА
$arr_new = array();
foreach ($content['fields'] as $item) {
	$arr_new[] = $item;
}

$content['fields'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>