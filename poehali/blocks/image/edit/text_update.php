<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$text = $_POST['text'];

$content = $BLOCK_E->getBlock($id)['content'];
$content['text'] = $text;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success'));
exit;

?>