<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$fields = $_POST['fields'];

$content = $BLOCK_E->getBlock($id)['content'];

$arr = array();
$fields_arr = explode(',', $fields);

foreach ($fields_arr as $num) {
	$arr[] = $content['fields'][$num - 1];
}

$content['fields'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>