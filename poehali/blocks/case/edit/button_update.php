<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];
$content['button']['on'] = intval($_POST['on']);
$content['button']['text'] = trim(htmlspecialchars(strip_tags($_POST['text'])));
$content['button']['bg_color'] = $_POST['bg_color'];
$content['button']['text_color'] = $_POST['text_color'];
$content['button']['style'] = $_POST['style'];
$content['button']['radius'] = $_POST['radius'];

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>