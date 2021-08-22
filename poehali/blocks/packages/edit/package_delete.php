<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];

if (count($content['packages']) < 2) {
	echo json_encode(array('answer' => 'error', 'message' => 'Последний блок нельзя удалить.'));
	exit;	
}

unset($content['packages'][$num - 1]);

// УДАЛЯЕМ ДЫРКИ ИЗ МАССИВА
$arr_new = array();
foreach ($content['packages'] as $item) {
	$arr_new[] = $item;
}

$content['packages'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>