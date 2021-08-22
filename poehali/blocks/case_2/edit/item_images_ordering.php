<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$images_num = $_POST['images_num'];
$images_num_arr = explode(',', $images_num);

$content = $BLOCK_E->getBlock($id)['content'];

$arr_new = [];
$i = 0;
foreach ($images_num_arr as $img_num) {
	$arr_new[] = $content['items'][$num - 1]['images'][$img_num - 1];
	$i++;
}

$content['items'][$num - 1]['images'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>