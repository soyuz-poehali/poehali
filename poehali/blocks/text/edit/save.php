<?php
defined('AUTH') or die('Restricted access');

include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$id = intval($_POST['id']);
$page_id = intval($_POST['p']);
$text = trim($_POST['text']);

$text = strip_tags($text, '<table><tbody><th><tr><td><img><h1><h2><h3><h4><h5><h6><section><div><p><span><a><b><strong><i><em><u><s><sub><sup><hr><ul><ol><li><blockquote><pre><address>');

$arr = array('script');
$text = str_replace($arr, '', $text);

$content = $BLOCK_E->getBlock($id)['content'];
$content['text'] = $text;
$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'success'));
exit;

?>