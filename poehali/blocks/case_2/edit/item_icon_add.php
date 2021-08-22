<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$num = intval($_POST['num']);

$content = $BLOCK_E->getBlock($id)['content'];

$arr_icon['text'] = 'НОВАЯ';
$arr_icon['ico'] = 'im-christmas-12';

$content['items'][($num-1)]['icons'][] = $arr_icon;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>