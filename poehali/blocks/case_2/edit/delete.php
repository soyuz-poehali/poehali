<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['id'] = intval($_POST['id']);
$data['page_id'] = intval($_POST['p']);
$content = $BLOCK_E->getBlock($data['id'])['content'];

foreach ($content['items'] as $item) {
	foreach ($item['images'] as $image) {
		$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/case_2/'.$image;
		if(is_file($file))
			unlink($file);	
	}
}

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'success'));
exit;

?>