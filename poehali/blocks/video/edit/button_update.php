<?php
defined('AUTH') or die('Restricted access');
include_once $_SERVER['DOCUMENT_ROOT'].'/edit/blocks/classes/BlockEdit.php';
$BLOCK_E = new BlockEdit;

$page_id = intval($_POST['p']);
$id = intval($_POST['id']);

$content = $BLOCK_E->getBlock($id)['content'];

$num = intval($_POST['num']);
$button_num = intval($_POST['button_num']);
$on = intval($_POST['on']);
$text = trim(htmlspecialchars(strip_tags($_POST['text'])));
$link = trim(htmlspecialchars(strip_tags($_POST['link'])));
$bg_color = $_POST['bg_color'];
$text_color = $_POST['text_color'];
$style = $_POST['style'];
$radius = $_POST['radius'];

$i = $num - 1;

$button = 'button_'.$button_num;

$content['videos'][$i][$button]['on'] = $on;
$content['videos'][$i][$button]['text'] = $text;
$content['videos'][$i][$button]['link'] = $link;
$content['videos'][$i][$button]['bg_color'] = $bg_color;
$content['videos'][$i][$button]['text_color'] = $text_color;
$content['videos'][$i][$button]['style'] = $style;
$content['videos'][$i][$button]['radius'] = $radius;

$BLOCK_E->updateBlockContent($id, $content);

echo json_encode(array('answer' => 'reload', 'id' => $id));
exit;

?>