<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$pub = intval($_POST['pub']);
$catalog_id = intval($_POST['catalog_id']);

$content = $BLOCK_E->getBlock($id)['content'];

$content['basket'] = array(
	'pub' => $pub,
	'catalog_id' => $catalog_id,
);

$BLOCK_E->updateBlockContent($id, $content);
echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>