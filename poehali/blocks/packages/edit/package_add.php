<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$data['id'] = intval($_POST['id']);
$data['page_id'] = intval($_POST['p']);

$content = $BLOCK_E->getBlock($data['id'])['content'];

$arr['text_1'] = 'Текст 1';
$arr['text_2'] = 'Текст 2';
$arr['button'] = 'Подробнее';
$arr['link'] = '';

$content['packages'][] = $arr;

$BLOCK_E->updateBlockContent($data['id'], $content);

echo json_encode(array('answer' => 'reload', 'id' => $data['id']));

exit;
?>