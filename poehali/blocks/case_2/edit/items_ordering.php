<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$items_num = $_POST['items_num'];

$content = $BLOCK_E->getBlock($id)['content'];

$items_num_arr = explode(',', $items_num);
$arr = array();

foreach ($items_num_arr as $num) {
	$arr[] = $content['items'][$num - 1];
}

$content['items'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;
?>