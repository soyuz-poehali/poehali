<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];

if (count($content['icons']) < 2) {
	echo json_encode(array('answer' => 'error', 'message' => 'Последнюю иконку нельзя удалить. Блок не может быть без иконок.'));
	exit;	
}

unset($content['icons'][$num - 1]);


// Удаляем дырки из массива - пересобираем массив
$arr = $content['icons'];
$arr_new = array();

foreach ($arr as $item) {
	$arr_new[] = $item;
}

$content['icons'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;

?>