<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$num = intval($_POST['num']);
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));
$link = trim(htmlspecialchars(strip_tags($_POST['link'])));

$content['items'][($num-1)]['text'] = $text;
$content['items'][($num-1)]['link'] = $link;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>