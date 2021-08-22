<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icon_num = intval($_POST['icon_num']);

$content = $BLOCK_E->getBlock($id)['content'];

unset($content['items'][($num-1)]['icons'][$icon_num-1]);

// Удаляем дырки из массива - пересобираем массив
$arr = $content['items'][($num-1)]['icons'];
$arr_new = array();

foreach ($arr as $item){
	$arr_new[] = $item;
} 

$content['items'][($num-1)]['icons'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>