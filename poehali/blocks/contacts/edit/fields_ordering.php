﻿<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$fields = $_POST['fields'];

$content = $BLOCK_E->getBlock($id)['content'];

$fields_arr = explode(',', $fields);
$arr = array();

foreach ($fields_arr as $num) {
	$arr[] = $content['fields'][$num - 1];
}

$content['fields'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success', 'id' => $id));
exit;

?>