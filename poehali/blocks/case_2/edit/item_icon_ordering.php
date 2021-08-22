<?php
defined('AUTH') or die('Restricted access');

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icons_num = $_POST['icons_num'];
$icons_num_arr = explode(',', $icons_num);

$arr_new = [];
foreach ($icons_num_arr as $i_num) {
	$arr_new[] = $block['items'][($num - 1)]['icons'][($i_num - 1)];
}

$block['items'][($num - 1)]['icons'] = $arr_new;
$settings = serialize($block);

$BLOCK_EDIT->updateBlock(array('id' => $block_id, 'settings' => serialize($block)));

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;

?>