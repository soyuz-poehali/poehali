<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$field_num = $_POST['field_num'];

$content = $BLOCK_E->getBlock($id)['content'];

unset($content['fields'][$field_num- 1]);

$arr_new = array();
foreach ($content['fields'] as $item) {
	$arr_new[] = $item;
}

$content['fields'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>