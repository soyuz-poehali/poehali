<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['id'] = intval($_POST['id']);
$data['page_id'] = intval($_POST['p']);

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'success'));
exit;

?>