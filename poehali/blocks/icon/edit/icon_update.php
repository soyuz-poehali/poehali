<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = isset($_POST['num']) ? intval($_POST['num']) : false;
$icon = trim(strip_tags(htmlspecialchars($_POST['icon'])));
$text_1 = trim(strip_tags(htmlspecialchars($_POST['text_1'])));
$text_2 = trim(htmlspecialchars($_POST['text_2']));
$text_2 = nl2br($text_2);

$content = $BLOCK_E->getBlock($id)['content'];

if (!$num) { // Добавить фото
	$arr['icon'] = $icon;	
	$arr['text_1'] = $text_1;
	$arr['text_2'] = $text_2;
	$content['icons'][] = $arr;
} else {  // Обновить фото
	$content['icons'][$num - 1]['icon'] = $icon;	
	$content['icons'][$num - 1]['text_1'] = $text_1;
	$content['icons'][$num - 1]['text_2'] = $text_2;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>