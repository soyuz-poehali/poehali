<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$videos = $_POST['videos'];

$content = $BLOCK_E->getBlock($id)['content'];

$videos_arr = explode(',', $videos);
$arr = array();

foreach ($videos_arr as $num) {
	$arr[] = $content['videos'][$num - 1];
}

$content['videos'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;
?>