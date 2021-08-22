<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$video_num = intval($_POST['video_num']);

$content = $BLOCK_E->getBlock($id)['content'];

$i = $video_num - 1;
unset($content['videos'][$i]);

// Удаляем дырки из массива - пересобираем массив
$arr_new = array();
foreach ($content['videos'] as $item) {
	$arr_new[] = $item;
}

$content['videos'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;
?>