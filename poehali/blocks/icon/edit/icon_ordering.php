<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$icons = $_POST['icons'];

$content = $BLOCK_E->getBlock($id)['content'];

$icons_arr = explode(',', $icons);
$arr = array();

foreach ($icons_arr as $num) {
	$arr[] = $content['icons'][$num - 1];
}

$content['icons'] = $arr;


$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
?>