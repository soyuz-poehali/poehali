<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icons_num = $_POST['icons_num'];
$icons_num_arr = explode(',', $icons_num);

$content = $BLOCK_E->getBlock($id)['content'];


$arr_new = [];
foreach ($icons_num_arr as $i_num) {
	$arr_new[] = $content['items'][($num - 1)]['icons'][$i_num - 1];
}

$content['items'][($num - 1)]['icons'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>