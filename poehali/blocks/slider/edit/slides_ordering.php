<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$slides = $_POST['slides'];

$content = $BLOCK_E->getBlock($id)['content'];

$slides_arr = explode(',', $slides);
$arr = array();

foreach ($slides_arr as $num) {
	$arr[] = $content['slides'][$num - 1];
}

$content['slides'] = $arr;

$BLOCK_E->updateBlockContent($id, $content);
echo json_encode(array('answer' => 'success'));

exit;

?>