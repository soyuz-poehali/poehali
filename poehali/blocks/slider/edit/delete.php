<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);

$data = $BLOCK_E->getBlock($id);

$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/slider/';

// УДАЛЯЕМ СЛАЙДЫ
foreach ($data['content']['slides'] as $slide) {
	$s = $dir.$slide['file'];

	if(is_file($s)) 
		unlink($s);
}

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'success'));
exit;

?>