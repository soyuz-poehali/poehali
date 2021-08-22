<?php
defined('AUTH') or die('Restricted access');

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$images_num = $_POST['images_num'];
$images_num_arr = explode(',', $images_num);

$arr_new = [];
foreach ($images_num_arr as $i_num) {
	$arr_new[] = $block['items'][($num - 1)]['images'][($i_num - 1)];
}

$block['items'][($num - 1)]['images'] = $arr_new;
$settings = serialize($block);

$BLOCK_EDIT->updateBlock(array('id' => $block_id, 'settings' => serialize($block)));

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;

?>