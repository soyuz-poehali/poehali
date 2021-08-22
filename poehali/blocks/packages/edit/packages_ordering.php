<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$nums_list = $_POST['packages'];

$content = $BLOCK_E->getBlock($id)['content'];

$nums_arr = explode(',', $nums_list);
$arr = array();

foreach ($nums_arr as $num) {
	$arr[] = $content['packages'][$num - 1];
}

$content['packages'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>