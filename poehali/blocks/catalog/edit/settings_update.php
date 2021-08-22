<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$content['catalog_id'] = intval($_POST['catalog_id']);
$content['max_width'] = intval($_POST['max_width']);
$content['margin'] = intval($_POST['margin']);

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload'));
exit;

?>