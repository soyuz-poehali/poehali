<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$content = $BLOCK_E->getBlock($id)['content'];

$content['size'] = intval($_POST['size']);
$content['bottom'] = intval($_POST['bottom']);
$content['left'] = intval($_POST['left']);
$content['color'] = $_POST['color'];

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;


?>