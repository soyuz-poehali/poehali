<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$icon_num = intval($_POST['icon_num']);
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));

$content = $BLOCK_E->getBlock($id)['content'];

$content['items'][($num-1)]['icons'][($icon_num-1)]['text'] = $text;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>