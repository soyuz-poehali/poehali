<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$img_dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/'.$content['items'][$num-1]['folder'];


if (count($content['items']) == 1) {
	echo json_encode(array('answer' => 'success', 'message' => 'Единственный элемент удалить нельзя'));
	exit;	
}

remove_directory($img_dir);

unset($content['items'][$num-1]);

// Удаляем дырки из массива - пересобираем массив
$arr = $content['items'];
$arr_new = array();
foreach ($arr as $item){
	$arr_new[] = $item;
}
$content['items'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>