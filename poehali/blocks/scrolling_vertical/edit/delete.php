<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$data = $BLOCK_E->getBlock($id);
$content = $data['content'];

$file = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$data['id'].'/site_portfolio/'.$content['image'];
if (is_file($file))
	unlink($file);	


$BLOCK_E->deleteBlock($data);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>