<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data['page_id'] = intval($_POST['p']);

$data = $BLOCK_E->getBlock($id);

// УДАЛЯЕМ ИЗОБРАЖЕНИЕ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image/';
$file_old = $dir.$data['content']['image'];
if(is_file($file_old)) 
	unlink($file_old);

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'success'));
exit;

?>