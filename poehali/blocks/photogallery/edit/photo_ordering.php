<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$photos = $_POST['photos'];

$content = $BLOCK_E->getBlock($id)['content'];

$photos_arr = explode(',', $photos);
$arr = array();

foreach ($photos_arr as $num) {
	$arr[] = $content['photos'][$num - 1];
}

$content['photos'] = $arr;
$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));

exit;

?>