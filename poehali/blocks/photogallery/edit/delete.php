<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);

// УДАЛЯЕМ ИЗОБРАЖЕНИЯ
$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/photogallery/';
foreach ($data['content']['photos'] as $photo) {
	if (is_file($dir.$photo['file'])) 
		unlink($dir.$photo['file']);
}

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'reload'));
exit;

?>