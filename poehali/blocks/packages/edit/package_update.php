<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);
$field = trim(strip_tags(htmlspecialchars($_POST['field'])));
$text = $_POST['content'];

$content = $BLOCK_E->getBlock($id)['content'];

// ПОЛЯ
switch ($field) {
	case 'text_1' : $content['packages'][$num - 1]['text_1'] = $text; break;
	case 'text_2' : $content['packages'][$num - 1]['text_2'] = $text; break;
	case 'button' : $content['packages'][$num - 1]['button'] = $text; break;
	case 'link' : $content['packages'][$num - 1]['link'] = $text; break;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;
?>