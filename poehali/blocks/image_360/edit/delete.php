<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/remove_directory/remove_directory.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

foreach ($content['items'] as $item) {
	$item_dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/image_360/'.$item['folder'];
	remove_directory($item_dir);
}

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'success'));
exit;

?>