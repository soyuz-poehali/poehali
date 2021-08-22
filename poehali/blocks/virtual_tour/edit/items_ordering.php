<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$list = $_POST['list'];

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$arr = explode(';', $list);
$arr_new = [];
for ($i=0; $i<count($arr); $i++) {
	$arr_new[] = $content['items'][$arr[$i] - 1];
}

$content['items'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>