<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);
$slide_num = isset($_POST['slide_num']) ? intval($_POST['slide_num']) : false;

$content = $BLOCK_E->getBlock($id)['content'];


$dir = $_SERVER['DOCUMENT_ROOT'].'/files/pages/'.$page_id.'/slider';
$path = $dir.'/'.$content['slides'][$slide_num - 1]['file'];

if(is_file($path)) 
	unlink($path);

unset($content['slides'][$slide_num - 1]);

$arr = $content['slides'];
$arr_new = array();
foreach ($arr as $item) {
	$arr_new[] = $item;
}
$content['slides'] = $arr_new;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success'));
exit;

?>