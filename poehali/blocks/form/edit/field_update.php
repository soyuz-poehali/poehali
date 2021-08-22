<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$field_num = isset($_POST['field_num']) ? intval($_POST['field_num']) : false;
$type = trim(strip_tags(htmlspecialchars($_POST['type'])));
$text = trim(strip_tags(htmlspecialchars($_POST['text'])));
$required = intval($_POST['required']);

$content = $BLOCK_E->getBlock($id)['content'];

$type_arr = array('text', 'email', 'textarea', 'checkbox');

if (!in_array($type, $type_arr)) 
	exit;

if (!$field_num) { 
	// Добавить поле	
	$arr['type'] = $type;
	$arr['text'] = $text;
	$arr['required'] = $required;
	$content['fields'][] = $arr;
} else {
	// Обновить поле	
	$content['fields'][$field_num - 1]['type'] = $type;
	$content['fields'][$field_num - 1]['text'] = $text;
	$content['fields'][$field_num - 1]['required'] = $required;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>