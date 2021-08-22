<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

// Единственную сцену удалять нельзя - проверка
if (count($content['items']) == 1) {
	echo json_encode(array('answer' => 'rerror', 'message' => 'Последнюю сцену нельзя удалить'));
	exit;
}

$file_old = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/virtual_tour/'.$content['items'][$num-1]['image'];

if (is_file($file_old))
	unlink($file_old);

unset($content['items'][$num-1]);

// Удаляем дырки из массива - пересобираем массив
$arr_new = array();
foreach ($content['items'] as $item){
	$arr_new[] = $item;
}
$content['items'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>