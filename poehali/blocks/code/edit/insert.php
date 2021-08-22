<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['page_id'] = intval($_POST['p']);
$data['type'] = 'code';
$data['ordering'] = $BLOCK_E->getMaxOrdering($data['page_id']) + 1;
$data['status'] = '1';
$data['content'] = $_POST['code'];

$block_id = $BLOCK_E->insertBlock($data, False);

echo json_encode(array('answer' => 'reload', 'id' => $block_id));
exit;
?>