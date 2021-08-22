<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/case_2/';

copy($_SERVER['DOCUMENT_ROOT'].'/blocks/case_2/edit/template/1/1.jpg', $dir.'new.jpg');

$content['items'][($num-1)]['images'][] = 'new.jpg';

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>