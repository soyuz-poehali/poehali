<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];
$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case/'.$content['images'][$num - 1];
unlink($file);

unset($content['images'][$num - 1]);

// Удаляем дырки из массива - пересобираем массив
$arr_new = array();
foreach ($content['images'] as $item) {
	$arr_new[] = $item;
}

$content['images'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>