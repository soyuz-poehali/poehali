<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);

$count = count($data['content']['items']);
for ($i = 0; $i < $count; $i++) {
	$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['page_id'].'/site_portfolio/'.$data['content']['items'][$i]['image'];
	if(is_file($file))
		unlink($file);	
}

$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>