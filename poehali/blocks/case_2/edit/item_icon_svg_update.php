<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icon_num = intval($_POST['icon_num']);
$svg_name = trim(htmlspecialchars(strip_tags($_POST['svg_name'])));

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$content['items'][($num-1)]['icons'][($icon_num-1)]['ico'] = $svg_name;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>