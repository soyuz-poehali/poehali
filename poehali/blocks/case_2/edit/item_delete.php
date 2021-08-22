<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];

for ($i = 0; $i < count($content['items'][$num - 1]['images']); $i++) {
	unlink($_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/case_2/'.$content['items'][$num - 1]['images'][$i]);
}

unset($content['items'][$num - 1]);

// Удаляем дырки из массива - пересобираем массив
$arr_new = array();

foreach ($content['items'] as $item) {
	$arr_new[] = $item;
} 

$content['items'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>