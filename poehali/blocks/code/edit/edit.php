<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);

$data = $BLOCK_E->getBlock($id, False);

echo json_encode(array('answer' => 'success', 'code' => $data['content']));
exit;
?>