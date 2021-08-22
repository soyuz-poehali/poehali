<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);

$field_num = isset($_POST['field_num']) ? intval($_POST['field_num']) : false;
$type = isset($_POST['type']) ? $_POST['type'] : '';
$cnt = trim($_POST['content']);

$content = $BLOCK_E->getBlock($id)['content'];

if (!$field_num) {  // Добавить поле
	$arr['type'] = $type;
	$arr['content'] = $cnt;

	if ($type == 'mapyandex') {
		$arr['coordinate'] = array(55.76, 37.64);
		$arr['points'] = false;
		$arr['zoom'] = 7;
	}

	$content['fields'][] = $arr;	
} else {  // Обновить поле	
	$content['fields'][$field_num - 1]['content'] = $cnt;
}

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>