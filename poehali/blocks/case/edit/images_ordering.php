<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$images = $_POST['images'];

$content = $BLOCK_E->getBlock($id)['content'];

$images_arr = explode(',', $images);
$arr = array();
foreach ($images_arr as $num) {
	$arr[] = $content['images'][$num - 1];
}

$content['images'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;
?>